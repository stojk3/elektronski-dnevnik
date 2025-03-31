<?php

namespace Drupal\Tests\menu_item_role_access\Functional;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\user\UserInterface;

/**
 * Tests handling of menu links hierarchies.
 *
 * @group Menu
 */
class InheritParentAccessTest extends MenuItemDisplayBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * The machine name of the menu.
   *
   * @var string
   */
  protected string $menuName = 'menu_test';

  /**
   * The authenticated user.
   *
   * @var \Drupal\user\UserInterface|\Drupal\user\Entity\User|false
   */
  protected UserInterface $authenticatedUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->setInheritParentAccessConfig();
    $this->authenticatedUser = $this->drupalCreateUser([], 'Authenticated user', FALSE, ['roles' => ['authenticated']]);
  }

  /**
   * Assert that the inherit parent access config is set to TRUE.
   */
  public function testInheritParentAccessEnabled() {
    $this->assertTrue(\Drupal::config('menu_item_role_access.config')->get('inherit_parent_access'));
  }

  /**
   * Assert that the anonymous user can access content restricted to anonymous.
   */
  public function testAnonymousUserCanAccessChildMenuItem() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test no roles',
      'menu_item_override_children' => TRUE,
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $child_options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/#child']],
      'title' => 'Child link',
      'parent' => 'menu_link_content:' . $link->uuid(),
    ];

    $child_link = MenuLinkContent::create($child_options);
    $child_link->save();

    $this->drupalGet('<front>');

    // Check our menu item is not showing to the authenticated user.
    $this->assertSession()->pageTextContains($child_link->label());
  }

  /**
   * Assert that the anonymous user can access content restricted to anonymous.
   */
  public function testAnonymousUserCanAccessRestrictedChildMenuItem() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test anon role',
      'menu_item_override_children' => TRUE,
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $child_options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/#child']],
      'title' => 'Child link anon role',
      'menu_item_roles' => [
        'authenticated',
      ],
      'parent' => 'menu_link_content:' . $link->uuid(),
    ];

    $child_link = MenuLinkContent::create($child_options);
    $child_link->save();

    $this->drupalGet('<front>');

    // Check our menu item is showing to the anonymous user.
    $this->assertSession()->pageTextContains($child_link->label());

    $this->drupalLogin($this->authenticatedUser);
    $this->drupalGet('<front>');

    // Check our menu item is not showing to the authenticated user.
    $this->assertSession()->pageTextNotContains($child_link->label());
  }

  /**
   * Assert access isn't inherited if it isn't enabled on the menu item.
   */
  public function testDisableInheritAccessForMenuItem() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test no roles',
      'menu_item_override_children' => FALSE,
      'menu_item_roles' => [
        'authenticated',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $child_options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/#child']],
      'title' => 'Child link',
      'menu_item_override_children' => FALSE,
      'menu_item_roles' => [
        'anonymous',
      ],
      'parent' => 'menu_link_content:' . $link->uuid(),
    ];

    $child_link = MenuLinkContent::create($child_options);
    $child_link->save();

    $this->drupalLogin($this->authenticatedUser);
    $this->drupalGet('<front>');

    // Check our menu item is not showing to the authenticated user.
    $this->assertSession()->pageTextNotContains($child_link->label());
  }

  /**
   * Updates the config to allow inherit parent access for menu items.
   */
  private function setInheritParentAccessConfig(): void {
    $config_factory = \Drupal::configFactory();
    $config = $config_factory->getEditable('menu_item_role_access.config');
    $config->set('inherit_parent_access', TRUE);
    $config->save(TRUE);
  }

}

<?php

namespace Drupal\Tests\menu_item_role_access\Functional;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * Tests handling of menu links hierarchies.
 *
 * @group Menu
 */
class PermissionsViewMenuLinkContentTest extends MenuItemDisplayBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

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

    $this->authenticatedUser = $this->drupalCreateUser([], 'Authenticated user', FALSE, ['roles' => [User::AUTHENTICATED_ROLE]]);
  }

  /**
   * Assert that the anonymous user can access content restricted to anonymous.
   */
  public function testAnonymousUserCanAccessMenuItemWithNoRoles() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test no roles',
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    // Check our menu item is showing.
    $this->assertSession()->linkExists($link->label());
  }

  /**
   * Assert that the authenticated user can access content with no restrictions.
   */
  public function testAuthenticatedUserCanAccessMenuItemWithNoRoles() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test no roles',
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalLogin($this->authenticatedUser);
    $this->drupalGet('<front>');

    // Check our menu item is showing.
    $this->assertSession()->linkExists($link->label());
  }

  /**
   * Assert that the anonymous user can access content restricted to anonymous.
   */
  public function testAnonymousUserCanAccessMenuItemWithAnonymousRole() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test anonymous',
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');

    // Check our menu item is showing.
    $this->assertSession()->linkExists($link->label());
  }

  /**
   * Assert that the anonymous user cannot access restricted menu links.
   */
  public function testAuthenticatedUserCannotAccessAnonymousMenuItem() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test authenticated cannot see',
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->assertTrue('anonymous' === $link->menu_item_roles->target_id);

    $this->drupalLogin($this->authenticatedUser);
    $this->drupalGet('<front>');

    // Check our menu item is not showing to the authenticated user.
    $this->assertSession()->linkNotExists($link->label());
  }

  /**
   * Assert that the authenticated user cannot access restricted menu links.
   */
  public function testAnonymousUserCannotAccessAuthenticatedMenuItem() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test anonymous cannot see',
      'menu_item_roles' => [
        'authenticated',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->assertTrue('authenticated' === $link->menu_item_roles->target_id);

    $this->drupalGet('<front>');

    // Check our menu item is not showing to the authenticated user.
    $this->assertSession()->linkNotExists($link->label());
  }

}

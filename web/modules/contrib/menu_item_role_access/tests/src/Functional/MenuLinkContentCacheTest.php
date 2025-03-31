<?php

namespace Drupal\Tests\menu_item_role_access\Functional;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\Tests\system\Functional\Cache\AssertPageCacheContextsAndTagsTrait;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;

/**
 * Tests the caching of menu items with menu_item_role_access.
 *
 * @group Menu
 */
class MenuLinkContentCacheTest extends MenuItemDisplayBrowserTestBase {

  use AssertPageCacheContextsAndTagsTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'block',
    'router_test',
    'menu_ui',
    'menu_link_content',
    'menu_item_role_access',
    'page_cache',
    'dynamic_page_cache',
  ];

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
    $this->enablePageCaching();
  }

  /**
   * Assert that the caches are updated for the anonymous user.
   */
  public function testAnonymousPageCacheMenuItem() {
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

    $this->drupalGet('<front>');
    // Make sure the page was not cached.
    $this->assertTrue(in_array('MISS', $this->getCacheHeaderValues('x-drupal-cache')));

    // Make sure our link exists at this point.
    $this->assertSession()->linkExists($link->label());

    $this->drupalGet('<front>');
    // Make sure the page is still cached.
    $this->assertTrue(in_array('HIT', $this->getCacheHeaderValues('x-drupal-cache')));

    $link->set('menu_item_roles', ['authenticated']);
    $link->save();

    $this->assertTrue('authenticated' === $link->menu_item_roles->target_id);
    $this->drupalGet('<front>');
    // Make sure the page is no longer cached as we have updated the menu item.
    $this->assertTrue(in_array('MISS', $this->getCacheHeaderValues('x-drupal-cache')));
    // Check our menu item is no longer showing for anonymous users.
    $this->assertSession()->linkNotExists($link->label());
  }

}

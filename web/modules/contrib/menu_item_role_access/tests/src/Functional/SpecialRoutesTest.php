<?php

namespace Drupal\Tests\menu_item_role_access\Functional;

use Drupal\menu_link_content\Entity\MenuLinkContent;

/**
 * Tests handling of menu links special routes.
 *
 * @group Menu
 */
class SpecialRoutesTest extends MenuItemDisplayBrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Assert that we can create a link to the front page.
   */
  public function testSpecialRouteFront() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test front',
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->linkExists($link->label());
  }

  /**
   * Assert that a front link still has access validated.
   */
  public function testSpecialRouteFrontNoAccess() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'internal:/']],
      'title' => 'Link test front no access',
      'menu_item_roles' => [
        'authenticated',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->linkNotExists($link->label());
  }

  /**
   * Assert that we can create a nolink, link .
   */
  public function testSpecialRouteNolink() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'route:<nolink>']],
      'title' => 'Link test no link',
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->pageTextContains($link->label());
  }

  /**
   * Assert that a nolink route still has access validated.
   */
  public function testSpecialRouteNolinkNoAccess() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'route:<nolink>']],
      'title' => 'Link test front no access',
      'menu_item_roles' => [
        'authenticated',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->pageTextNotContains($link->label());
  }

  /**
   * Assert that we can create a none link.
   */
  public function testSpecialRouteNone() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'route:<none>']],
      'title' => 'Link test none',
      'menu_item_roles' => [
        'anonymous',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->linkExists($link->label());
  }

  /**
   * Assert that a none route still has access validated.
   */
  public function testSpecialRouteNoneNoAccess() {
    $options = [
      'menu_name' => $this->menuName,
      'bundle' => 'menu_link_content',
      'link' => [['uri' => 'route:<none>']],
      'title' => 'Link test none no access',
      'menu_item_roles' => [
        'authenticated',
      ],
    ];
    $link = MenuLinkContent::create($options);
    $link->save();

    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);

    // Check our field exists.
    $this->assertSession()->linkNotExists($link->label());
  }

}

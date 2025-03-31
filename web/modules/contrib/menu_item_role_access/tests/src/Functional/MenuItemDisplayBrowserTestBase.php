<?php

namespace Drupal\Tests\menu_item_role_access\Functional;

use Drupal\system\Entity\Menu;
use Drupal\Tests\BrowserTestBase;

/**
 * A base class to provide the content block for menu blocks.
 *
 * @group Menu
 */
abstract class MenuItemDisplayBrowserTestBase extends BrowserTestBase {

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
  ];

  /**
   * The machine name of the menu.
   *
   * @var string
   */
  protected string $menuName = 'menu_test';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    Menu::create([
      'id' => $this->menuName,
      'label' => 'Test menu',
      'description' => 'Description text',
    ])->save();

    // Add our menu to the content region.
    $this->addBlockToContent($this->menuName);
  }

  /**
   * Allows a menu block to be placed in the content region.
   *
   * @param string $block_name
   *   The menu name to put in the content region.
   */
  protected function addBlockToContent(string $block_name): void {
    // Allow blocks to expand out all menu items.
    $block_settings = [
      'level' => 1,
      'depth' => 0,
      'expand_all_items' => TRUE,
    ];
    // Enable a test block and place it in an invalid region.
    $block = $this->drupalPlaceBlock('system_menu_block:' . $block_name, $block_settings);
    \Drupal::configFactory()->getEditable('block.block.' . $block->id())->set('region', 'content')->save();
  }

}

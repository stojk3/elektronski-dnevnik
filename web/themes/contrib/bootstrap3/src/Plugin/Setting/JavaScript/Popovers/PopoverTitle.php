<?php

namespace Drupal\bootstrap3\Plugin\Setting\JavaScript\Popovers;

use Drupal\bootstrap3\Plugin\Setting\SettingBase;

/**
 * The "popover_title" theme setting.
 *
 * @ingroup plugins_setting
 *
 * @BootstrapSetting(
 *   id = "popover_title",
 *   type = "textfield",
 *   title = @Translation("title"),
 *   description = @Translation("Default title value if <code>title</code> attribute isn't present."),
 *   defaultValue = "",
 *   groups = {
 *     "javascript" = @Translation("JavaScript"),
 *     "popovers" = @Translation("Popovers"),
 *     "options" = @Translation("Options"),
 *   },
 * )
 */
class PopoverTitle extends SettingBase {

  /**
   * {@inheritdoc}
   */
  public function drupalSettings() {
    return !!$this->theme->getSetting('popover_enabled');
  }

}

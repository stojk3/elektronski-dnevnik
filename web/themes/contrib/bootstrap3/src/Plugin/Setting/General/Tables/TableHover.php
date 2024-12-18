<?php

namespace Drupal\bootstrap3\Plugin\Setting\General\Tables;

use Drupal\bootstrap3\Plugin\Setting\SettingBase;

/**
 * The "table_hover" theme setting.
 *
 * @ingroup plugins_setting
 *
 * @BootstrapSetting(
 *   id = "table_hover",
 *   type = "checkbox",
 *   title = @Translation("Hover rows"),
 *   description = @Translation("Enable a hover state on table rows."),
 *   defaultValue = 1,
 *   groups = {
 *     "general" = @Translation("General"),
 *     "tables" = @Translation("Tables"),
 *   },
 * )
 */
class TableHover extends SettingBase {}

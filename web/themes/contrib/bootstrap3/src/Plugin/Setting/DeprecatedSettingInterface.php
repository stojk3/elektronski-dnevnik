<?php

namespace Drupal\bootstrap3\Plugin\Setting;

use Drupal\bootstrap3\DeprecatedInterface;

/**
 * Interface DeprecatedInterface.
 */
interface DeprecatedSettingInterface extends DeprecatedInterface, SettingInterface {

  /**
   * The setting that replaces the deprecated setting.
   *
   * @return \Drupal\bootstrap3\Plugin\Setting\SettingInterface
   *   The replacement setting.
   */
  public function getDeprecatedReplacementSetting();

}

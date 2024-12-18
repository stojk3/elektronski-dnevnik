<?php

namespace Drupal\bootstrap3\Plugin;

use Drupal\bootstrap3\Theme;

/**
 * Manages discovery and instantiation of Bootstrap hook alters.
 *
 * @ingroup plugins_alter
 */
class AlterManager extends PluginManager {

  /**
   * Constructs a new \Drupal\bootstrap3\Plugin\AlterManager object.
   *
   * @param \Drupal\bootstrap3\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Alter', 'Drupal\bootstrap3\Plugin\Alter\AlterInterface', 'Drupal\bootstrap3\Annotation\BootstrapAlter');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':alter', $this->getCacheTags());
  }

}

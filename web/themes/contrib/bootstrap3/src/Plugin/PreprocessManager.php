<?php

namespace Drupal\bootstrap3\Plugin;

use Drupal\bootstrap3\Theme;

/**
 * Manages discovery and instantiation of Bootstrap preprocess hooks.
 *
 * @ingroup plugins_preprocess
 */
class PreprocessManager extends PluginManager {

  /**
   * Constructs a new \Drupal\bootstrap3\Plugin\PreprocessManager object.
   *
   * @param \Drupal\bootstrap3\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Preprocess', 'Drupal\bootstrap3\Plugin\Preprocess\PreprocessInterface', 'Drupal\bootstrap3\Annotation\BootstrapPreprocess');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':preprocess', $this->getCacheTags());
  }

}

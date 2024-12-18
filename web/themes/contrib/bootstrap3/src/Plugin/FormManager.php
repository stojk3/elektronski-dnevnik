<?php

namespace Drupal\bootstrap3\Plugin;

use Drupal\bootstrap3\Theme;

/**
 * Manages discovery and instantiation of Bootstrap form alters.
 *
 * @ingroup plugins_form
 */
class FormManager extends PluginManager {

  /**
   * Constructs a new \Drupal\bootstrap3\Plugin\FormManager object.
   *
   * @param \Drupal\bootstrap3\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Form', 'Drupal\bootstrap3\Plugin\Form\FormInterface', 'Drupal\bootstrap3\Annotation\BootstrapForm');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':form', $this->getCacheTags());
  }

}

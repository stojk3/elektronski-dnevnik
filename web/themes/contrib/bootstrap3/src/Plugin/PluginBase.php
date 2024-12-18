<?php

namespace Drupal\bootstrap3\Plugin;

use Drupal\Core\Plugin\PluginBase as CorePluginBase;
use Drupal\bootstrap3\Bootstrap;

/**
 * Base class for an update.
 *
 * @ingroup utility
 */
class PluginBase extends CorePluginBase {

  /**
   * The currently set theme object.
   *
   * @var \Drupal\bootstrap3\Theme
   */
  protected $theme;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    $this->theme = Bootstrap::getTheme(isset($configuration['theme']) ? $configuration['theme'] : NULL);
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

}

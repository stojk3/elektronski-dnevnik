<?php

namespace Drupal\bootstrap3\Plugin;

use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\bootstrap3\Theme;
use Drupal\bootstrap3\Utility\Element;

/**
 * Manages discovery and instantiation of Bootstrap pre-render callbacks.
 *
 * @ingroup plugins_prerender
 */
class PrerenderManager extends PluginManager implements TrustedCallbackInterface {

  /**
   * Constructs a new \Drupal\bootstrap3\Plugin\PrerenderManager object.
   *
   * @param \Drupal\bootstrap3\Theme $theme
   *   The theme to use for discovery.
   */
  public function __construct(Theme $theme) {
    parent::__construct($theme, 'Plugin/Prerender', 'Drupal\bootstrap3\Plugin\Prerender\PrerenderInterface', 'Drupal\bootstrap3\Annotation\BootstrapPrerender');
    $this->setCacheBackend(\Drupal::cache('discovery'), 'theme:' . $theme->getName() . ':prerender', $this->getCacheTags());
  }

  /**
   * Pre-render render array element callback.
   *
   * @param array $element
   *   The render array element.
   *
   * @return array
   *   The modified render array element.
   */
  public static function preRender(array $element) {
    if (!empty($element['#bootstrap_ignore_pre_render'])) {
      return $element;
    }

    $e = Element::create($element);

    if ($e->isType('machine_name')) {
      $e->addClass('form-inline', 'wrapper_attributes');
    }

    // Add smart descriptions to the element, if necessary.
    $e->smartDescription();

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks() {
    return ['preRender'];
  }

}

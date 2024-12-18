<?php

namespace Drupal\bootstrap3\Plugin\Prerender;

use Drupal\bootstrap3\Utility\Element;

/**
 * Pre-render callback for the "dropbutton" element type.
 *
 * @ingroup plugins_prerender
 *
 * @BootstrapPrerender("dropbutton",
 *   replace = "Drupal\Core\Render\Element\Dropbutton::preRenderDropbutton"
 * )
 *
 * @see \Drupal\Core\Render\Element\Dropbutton::preRenderDropbutton()
 */
class Dropbutton extends PrerenderBase {

  /**
   * {@inheritdoc}
   */
  public static function preRenderElement(Element $element) {
    $element['#attached']['library'][] = 'bootstrap3/dropdown';

    // Enable targeted theming of specific dropbuttons (e.g., 'operations' or
    // 'operations__node').
    if ($subtype = $element->getProperty('subtype')) {
      $element->setProperty('theme', $element->getProperty('theme') . "__$subtype");
    }
  }

}

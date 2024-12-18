<?php

namespace Drupal\bootstrap3\Plugin\Prerender;

use Drupal\bootstrap3\Utility\Element;

/**
 * Pre-render callback for the "captcha" element type.
 *
 * @ingroup plugins_prerender
 *
 * @BootstrapPrerender("captcha",
 *   action = @BootstrapConstant(
 *     "\Drupal\bootstrap3\Bootstrap::CALLBACK_PREPEND"
 *   )
 * )
 */
class Captcha extends PrerenderBase {

  /**
   * {@inheritdoc}
   */
  public static function preRenderElement(Element $element) {
    parent::preRenderElement($element);
    $element->setProperty('smart_description', FALSE, TRUE);
  }

}

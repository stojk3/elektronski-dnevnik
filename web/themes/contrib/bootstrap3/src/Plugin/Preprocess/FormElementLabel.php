<?php

namespace Drupal\bootstrap3\Plugin\Preprocess;

use Drupal\bootstrap3\Utility\Element;
use Drupal\bootstrap3\Utility\Variables;

/**
 * Pre-processes variables for the "form_element_label" theme hook.
 *
 * @ingroup plugins_preprocess
 *
 * @BootstrapPreprocess("form_element_label")
 */
class FormElementLabel extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessElement(Element $element, Variables $variables) {
    // Map the element properties.
    $variables->map(['attributes', 'is_checkbox', 'is_radio']);

    // Preprocess attributes.
    $this->preprocessAttributes();
  }

}

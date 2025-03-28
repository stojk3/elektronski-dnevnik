<?php

namespace Drupal\bootstrap3\Plugin\Preprocess;

use Drupal\bootstrap3\Utility\Variables;

/**
 * Pre-processes for the "item_list__dropdown" theme hook.
 *
 * @ingroup plugins_preprocess
 *
 * @BootstrapPreprocess("item_list__dropdown")
 */
class ItemListDropdown extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  protected function preprocessVariables(Variables $variables) {
    parent::preprocessVariables($variables);

    $variables->alignment = $variables->getContext('alignment');
  }

}

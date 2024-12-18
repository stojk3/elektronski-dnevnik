<?php

namespace Drupal\bootstrap3\Plugin\Preprocess;

use Drupal\bootstrap3\Utility\Variables;

/**
 * Pre-processes variables for the "container__help_block" theme hook.
 *
 * @ingroup plugins_preprocess
 *
 * @BootstrapPreprocess("container__help_block")
 */
class ContainerHelpBlock extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessVariables(Variables $variables) {
    $variables->addClass('help-block');
  }

}

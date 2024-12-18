<?php

namespace Drupal\bootstrap3\Plugin\Alter;

use Drupal\bootstrap3\Plugin\PluginBase;

/**
 * Implements hook_page_attachments_alter().
 *
 * @ingroup plugins_alter
 *
 * @BootstrapAlter("page_attachments")
 */
class PageAttachments extends PluginBase implements AlterInterface {

  /**
   * {@inheritdoc}
   */
  public function alter(&$attachments, &$context1 = NULL, &$context2 = NULL) {
    if ($this->theme->livereloadUrl()) {
      $attachments['#attached']['library'][] = 'bootstrap3/livereload';
    }
    if ($this->theme->getSetting('popover_enabled')) {
      $attachments['#attached']['library'][] = 'bootstrap3/popover';
    }
    if ($this->theme->getSetting('tooltip_enabled')) {
      $attachments['#attached']['library'][] = 'bootstrap3/tooltip';
    }
    $attachments['#attached']['drupalSettings']['bootstrap'] = $this->theme->drupalSettings();
  }

}

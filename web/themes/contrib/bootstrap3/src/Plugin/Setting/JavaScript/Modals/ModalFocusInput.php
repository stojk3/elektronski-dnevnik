<?php

namespace Drupal\bootstrap3\Plugin\Setting\JavaScript\Modals;

use Drupal\bootstrap3\Plugin\Setting\SettingBase;
use Drupal\bootstrap3\Utility\Element;
use Drupal\Core\Form\FormStateInterface;

/**
 * The "modal_focus_input" theme setting.
 *
 * @ingroup plugins_setting
 *
 * @BootstrapSetting(
 *   id = "modal_focus_input",
 *   type = "checkbox",
 *   title = @Translation("focusInput"),
 *   description = @Translation("Enabling this focuses on the first available and visible input found in the modal after it's opened. If no element is found, the close button (if visible) is focused instead."),
 *   defaultValue = 1,
 *   groups = {
 *     "javascript" = @Translation("JavaScript"),
 *     "modals" = @Translation("Modals"),
 *     "options" = @Translation("Options"),
 *   },
 * )
 */
class ModalFocusInput extends SettingBase {

  /**
   * {@inheritdoc}
   */
  public function alterFormElement(Element $form, FormStateInterface $form_state, $form_id = NULL) {
    parent::alterFormElement($form, $form_state, $form_id);
    $setting = $this->getSettingElement($form, $form_state);
    $setting->setProperty('states', [
      'visible' => [
        ':input[name="modal_enabled"]' => ['checked' => TRUE],
      ],
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function drupalSettings() {
    return !!$this->theme->getSetting('modal_enabled');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return ['rendered', 'library_info'];
  }

}
<?php

namespace Drupal\bootstrap5;

use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Bootstrap5 subtheme form manager.
 */
class SubthemeFormManager {

  /**
   * The subtheme manager.
   *
   * @var \Drupal\bootstrap5\SubthemeManager
   */
  protected SubthemeManager $subthemeManager;

  /**
   * The theme extension list.
   *
   * @var \Drupal\Core\Extension\ThemeExtensionList
   */
  protected $themeExtensionList;

  /**
   * SubthemeFormManager constructor.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger interface.
   * @param \Drupal\Core\Extension\ThemeExtensionList $theme_extension_list
   *   The theme extension list.
   */
  public function __construct(FileSystemInterface $file_system, MessengerInterface $messenger, ThemeExtensionList $theme_extension_list) {
    $this->subthemeManager = new SubthemeManager($file_system, $messenger, $theme_extension_list);
  }

  /**
   * Validate callback.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @see hook_form_alter()
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $result = $this->subthemeManager->validateSubtheme($form_state->getValue('subtheme_folder'), $form_state->getValue('subtheme_machine_name'));

    if (is_array($result)) {
      $form_state->setErrorByName(...$result);
    }
  }

  /**
   * Submit callback.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @see hook_form_alter()
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Create subtheme.
    $themeMName = $form_state->getValue('subtheme_machine_name');
    $themeName = $form_state->getValue('subtheme_name');
    $subthemePathValue = $form_state->getValue('subtheme_folder');
    if (empty($themeName)) {
      $themeName = $themeMName;
    }

    $this->subthemeManager->createSubtheme($themeMName, $subthemePathValue, $themeName);
  }

}

<?php

namespace Drupal\admin_rights\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class AssignAdminForm extends FormBase {

  public function getFormId() {
    return 'assign_admin_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['teacher_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Teacher ID'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Assign Admin'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $teacher_id = $form_state->getValue('teacher_id');
    
    // Call your function to assign admin rights.
    create_and_assign_admin_from_teacher($teacher_id);

    // Use the messenger service to display a message.
    \Drupal::messenger()->addMessage($this->t('Admin rights assigned to teacher with ID %id.', ['%id' => $teacher_id]), MessengerInterface::TYPE_STATUS);
  }
}

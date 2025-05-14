<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class DepartmentRegisterForm extends FormBase {

  public function getFormId() {
    return 'department_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['ime'] = [
      '#type' => 'textfield',
      '#title' => 'Ime odeljenja',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['generacija'] = [
      '#type' => 'textfield',
      '#title' => 'Generacija',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Registruj',
      '#attributes' => ['class' => ['btn-success']],
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();

    try {
      $connection->insert('departments')
        ->fields([
          'ime' => $form_state->getValue('ime'),
          'generacija' => $form_state->getValue('generacija'),
        ])
        ->execute();

      \Drupal::messenger()->addMessage('Uspešno ste registrovali odeljenje!', MessengerInterface::TYPE_STATUS);

    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('Greška pri registraciji: ' . $e->getMessage(), MessengerInterface::TYPE_ERROR);
    }
  }
}

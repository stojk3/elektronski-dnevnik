<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class StudentRegisterForm extends FormBase {

  public function getFormId() {
    return 'student_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['ime'] = [
      '#type' => 'textfield',
      '#title' => 'Ime',
      '#required' => TRUE,
    ];

    $form['prezime'] = [
      '#type' => 'textfield',
      '#title' => 'Prezime',
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#required' => TRUE,
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#required' => TRUE,
    ];

    $form['datum_rodjenja'] = [
      '#type' => 'date',
      '#title' => 'Datum rođenja',
      '#required' => TRUE,
    ];

    $form['sifra'] = [
      '#type' => 'password',
      '#title' => 'Šifra',
      '#required' => TRUE,
    ];

    $form['generacija'] = [
      '#type' => 'textfield',
      '#title' => 'Generacija',
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Registruj se',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();

    try {
      $connection->insert('students')
        ->fields([
          'ime' => $form_state->getValue('ime'),
          'prezime' => $form_state->getValue('prezime'),
          'email' => $form_state->getValue('email'),
          'username' => $form_state->getValue('username'),
          'datum_rodjenja' => $form_state->getValue('datum_rodjenja'),
          'sifra' => $form_state->getValue('sifra'),
          'generacija' => $form_state->getValue('generacija'),
        ])
        ->execute();

      \Drupal::messenger()->addMessage('Uspešno ste registrovali učenika!', MessengerInterface::TYPE_STATUS);

    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('Greška pri registraciji: ' . $e->getMessage(), MessengerInterface::TYPE_ERROR);
    }
  }
}

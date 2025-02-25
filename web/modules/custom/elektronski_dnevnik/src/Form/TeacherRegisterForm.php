<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class TeacherRegisterForm extends FormBase {

  public function getFormId() {
    return 'teacher_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    $subjects = $connection->select('subjects', 's')
      ->fields('s', ['id', 'ime'])
      ->execute()
      ->fetchAllKeyed();

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

    $form['subject_id'] = [
      '#type' => 'select',
      '#title' => 'Predmet',
      '#options' => $subjects,
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
    $subject_id = $form_state->getValue('subject_id');
    $subject_name = $connection->select('subjects', 's')
      ->fields('s', ['ime'])
      ->condition('id', $subject_id)
      ->execute()
      ->fetchField();

    try {
      $connection->insert('teachers')
        ->fields([
          'ime' => $form_state->getValue('ime'),
          'prezime' => $form_state->getValue('prezime'),
          'email' => $form_state->getValue('email'),
          'username' => $form_state->getValue('username'),
          'datum_rodjenja' => $form_state->getValue('datum_rodjenja'),
          'sifra' => $form_state->getValue('sifra'), 
          'predmet' => $subject_name,
          'subject_id' => $subject_id,
        ])
        ->execute();

      \Drupal::messenger()->addMessage('Uspešno ste registrovali profesora!', MessengerInterface::TYPE_STATUS);
      \Drupal::logger('elektronski_dnevnik')->notice('Form state values: ' . print_r($form_state->getValues(), TRUE));


    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('Greška pri registraciji: ' . $e->getMessage(), MessengerInterface::TYPE_ERROR);
    }
  }
}
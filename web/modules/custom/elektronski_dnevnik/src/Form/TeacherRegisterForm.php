<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Role;

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
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['prezime'] = [
      '#type' => 'textfield',
      '#title' => 'Prezime',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['datum_rodjenja'] = [
      '#type' => 'date',
      '#title' => 'Datum rođenja',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['sifra'] = [
      '#type' => 'password',
      '#title' => 'Šifra',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['subject_id'] = [
      '#type' => 'select',
      '#title' => 'Predmet',
      '#options' => $subjects,
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $role_options = [];
    if ($role = Role::load('teacher')) {
      $role_options['teacher'] = $role->label();
    }

    if (!empty($role_options)) {
      $form['role'] = [
        '#type' => 'select',
        '#title' => 'Uloga',
        '#options' => $role_options,
        '#default_value' => 'teacher',
        '#required' => TRUE,
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      ];
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Registruj se',
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
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

      $user = User::create();
      $user->setUsername($form_state->getValue('username'));
      $user->setEmail($form_state->getValue('email'));
      $user->setPassword($form_state->getValue('sifra'));

      if ($role = Role::load('teacher')) {
        $user->addRole('teacher');
      }

      $user->activate();
      $user->save();

      \Drupal::messenger()->addMessage('Uspešno ste registrovali profesora!', MessengerInterface::TYPE_STATUS);
      \Drupal::logger('elektronski_dnevnik')->notice('Form state values: ' . print_r($form_state->getValues(), TRUE));

    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('Greška pri registraciji: ' . $e->getMessage(), MessengerInterface::TYPE_ERROR);
    }
  }
}

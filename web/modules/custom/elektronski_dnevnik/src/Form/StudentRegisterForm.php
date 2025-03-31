<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Role;

class StudentRegisterForm extends FormBase {

  public function getFormId() {
    return 'student_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

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

    $form['generacija'] = [
      '#type' => 'textfield',
      '#title' => 'Generacija',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $role_options = [];
    if ($role = Role::load('student')) {
      $role_options['student'] = $role->label();
    }

    if (!empty($role_options)) {
      $form['role'] = [
        '#type' => 'select',
        '#title' => 'Uloga',
        '#options' => $role_options,
        '#default_value' => 'student',
        '#required' => TRUE,
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      ];
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Registruj',
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('username');
    $existing_user = user_load_by_name($username);

    if ($existing_user) {
      $form_state->setErrorByName('username', 'Korisničko ime već postoji. Molimo unesite drugo.');
    }
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

      $user = User::create();
      $user->setUsername($form_state->getValue('username'));
      $user->setEmail($form_state->getValue('email'));
      $user->setPassword($form_state->getValue('sifra'));
      
      if ($role = Role::load('student')) {
        $user->addRole('student');
      }
      
      $user->activate();
      $user->save();

      \Drupal::messenger()->addMessage('Uspešno ste registrovali učenika!', MessengerInterface::TYPE_STATUS);

    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('Greška pri registraciji: ' . $e->getMessage(), MessengerInterface::TYPE_ERROR);
    }
  }
}

<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;

class UserEditForm extends FormBase {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function getFormId() {
    return 'user_edit_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $type = NULL, $id = NULL) {
    if (!$type || !$id) {
      \Drupal::messenger()->addError('Nedostaju parametri za tip ili ID.');
      return $form;
    }

    $connection = \Drupal::database();
    $user_data = NULL;
    $user_uid = NULL;
    $old_username = NULL;

    if ($type === 'student') {
      $user_data = $connection->select('students', 's')
        ->fields('s')
        ->condition('id', $id)
        ->execute()
        ->fetchAssoc();

      if ($user_data && isset($user_data['username'])) {
        $old_username = $user_data['username'];
        $user_uid = $connection->select('users_field_data', 'u')
          ->fields('u', ['uid'])
          ->condition('name', $old_username)
          ->execute()
          ->fetchField();
      }
    }
    elseif ($type === 'teacher') {
      $user_data = $connection->select('teachers', 't')
        ->fields('t')
        ->condition('id', $id)
        ->execute()
        ->fetchAssoc();

      if ($user_data && isset($user_data['username'])) {
        $old_username = $user_data['username'];
        $user_uid = $connection->select('users_field_data', 'u')
          ->fields('u', ['uid'])
          ->condition('name', $old_username)
          ->execute()
          ->fetchField();
      }
    }
    elseif ($type === 'admin') {
      $user_data = $connection->select('users_field_data', 'u')
        ->fields('u')
        ->condition('uid', $id)
        ->execute()
        ->fetchAssoc();
      $user_uid = $id;
      $old_username = $user_data['name'] ?? NULL;
    }
    else {
      \Drupal::messenger()->addError('Nepoznat tip korisnika.');
      return $form;
    }

    if (!$user_data) {
      \Drupal::messenger()->addError('Korisnik nije pronađen u bazi.');
      return $form;
    }

    $form['ime'] = [
      '#type' => 'textfield',
      '#title' => 'Ime',
      '#default_value' => $user_data['ime'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['prezime'] = [
      '#type' => 'textfield',
      '#title' => 'Prezime',
      '#default_value' => $user_data['prezime'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#default_value' => $user_data['email'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => 'Korisničko ime',
      '#default_value' => $user_data['username'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['datum_rodjenja'] = [
      '#type' => 'date',
      '#title' => 'Datum rođenja',
      '#default_value' => $user_data['datum_rodjenja'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['sifra'] = [
      '#type' => 'textfield',
      '#title' => 'Šifra',
      '#default_value' => $user_data['sifra'] ?? '',
      '#required' => FALSE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    if ($type === 'student') {
      $form['generacija'] = [
        '#type' => 'textfield',
        '#title' => 'Generacija',
        '#default_value' => $user_data['generacija'] ?? '',
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      ];
    }

    if ($type === 'teacher') {
      $form['predmet'] = [
        '#type' => 'textfield',
        '#title' => 'Predmet',
        '#default_value' => $user_data['predmet'] ?? '',
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      ];
    }

    $form['back'] = [
      '#type' => 'submit',
      '#value' => 'Nazad',
      '#submit' => ['::backForm'],
      '#limit_validation_errors' => [],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Sačuvaj',
    ];

    $form_state->set('user_type', $type);
    $form_state->set('user_id', $id);
    $form_state->set('user_uid', $user_uid);
    $form_state->set('old_username', $old_username);

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_type = $form_state->get('user_type');
    $id = $form_state->get('user_id');
    $user_uid = $form_state->get('user_uid');
    $old_username = $form_state->get('old_username');
    $table = $this->getTableFromType($user_type);

    $new_username = $form_state->getValue('username');
    $new_email = $form_state->getValue('email');
    $new_password = $form_state->getValue('sifra');

    if ($old_username) {
      $user_row = $this->database->select('users_field_data', 'u')
        ->fields('u', ['uid'])
        ->condition('name', $old_username)
        ->execute()
        ->fetchAssoc();

      if ($user_row && isset($user_row['uid'])) {
        $update_fields = [];
        if ($new_username !== NULL && $new_username !== '') {
          $existing = $this->database->select('users_field_data', 'u')
            ->fields('u', ['uid'])
            ->condition('name', $new_username)
            ->condition('uid', $user_row['uid'], '<>')
            ->execute()
            ->fetchField();
          if ($existing) {
            \Drupal::messenger()->addError('Korisničko ime već postoji u sistemu. Izaberite drugo korisničko ime.');
            return;
          }
          $update_fields['name'] = $new_username;
        }
        if ($new_email !== NULL && $new_email !== '') {
          $update_fields['mail'] = $new_email;
        }
        if (!empty($update_fields)) {
          $this->database->update('users_field_data')
            ->fields($update_fields)
            ->condition('name', $old_username)
            ->execute();
        }
        if ($new_password !== NULL && $new_password !== '') {
          $user = User::load($user_row['uid']);
          if ($user) {
            $user->setPassword($new_password);
            $user->save();
          }
        }
      }
    }

    if ($user_type === 'student' || $user_type === 'teacher') {
      $update_fields = [];
      if ($new_username !== NULL && $new_username !== '') {
        $update_fields['username'] = $new_username;
      }
      if ($new_email !== NULL && $new_email !== '') {
        $update_fields['email'] = $new_email;
      }
      if ($new_password !== NULL && $new_password !== '') {
        $update_fields['sifra'] = $new_password;
      }
      foreach (['ime', 'prezime', 'datum_rodjenja', 'generacija', 'predmet'] as $field) {
        $val = $form_state->getValue($field);
        if ($val !== NULL && $val !== '') {
          $update_fields[$field] = $val;
        }
      }
      if (!empty($update_fields) && $old_username) {
        $this->database->update($table)
          ->fields($update_fields)
          ->condition('username', $old_username)
          ->execute();
      }
    }

    if ($user_type === 'admin') {
      $update_fields = [];
      if ($new_username !== NULL && $new_username !== '') {
        $update_fields['name'] = $new_username;
      }
      if ($new_email !== NULL && $new_email !== '') {
        $update_fields['mail'] = $new_email;
      }
      if (!empty($update_fields)) {
        $this->database->update('users_field_data')
          ->fields($update_fields)
          ->condition('uid', $id)
          ->execute();
      }
      if ($new_password !== NULL && $new_password !== '') {
        $user = User::load($id);
        if ($user) {
          $user->setPassword($new_password);
          $user->save();
        }
      }
    }

    $this->messenger()->addStatus($this->t('Korisnik uspešno izmenjen.'));

    $user_type = $form_state->get('user_type');
    $user_id = $form_state->get('user_id');
    $form_state->setRedirect('elektronski_dnevnik.user_info', [
      'type' => $user_type,
      'id' => $user_id,
    ]);
  }

  public function backForm(array &$form, FormStateInterface $form_state) {
    $id = $form_state->getValue('record_id');
    $form_state->setRedirect('elektronski_dnevnik.admin_users_controller', ['id' => $id]);
  }

  private function getTableFromType($type) {
    switch ($type) {
      case 'student':
        return 'students';
      case 'teacher':
        return 'teachers';
      case 'admin':
        return 'users_field_data';
    }
    return NULL;
  }
}

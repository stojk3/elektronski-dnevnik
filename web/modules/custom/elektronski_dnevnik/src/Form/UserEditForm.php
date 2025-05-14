<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UserEditForm extends FormBase {

  protected $database;
  protected $requestStack;

  public function __construct(Connection $database, RequestStack $request_stack) {
    $this->database = $database;
    $this->requestStack = $request_stack;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('request_stack')
    );
  }

  public function getFormId() {
    return 'user_edit_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $request = $this->requestStack->getCurrentRequest();
    $id = $request->get('id');
    $name = $request->get('name');
    $surname = $request->get('surname');

    if (!is_numeric($id) && empty($name) && empty($surname)) {
      return ['#markup' => 'Nevalidni podaci za pretragu.'];
    }

    $record = null;
    $type = null;

    // First, check the students table
    $query = $this->database->select('students', 's')
        ->fields('s')
        ->condition('id', $id)
        ->condition('ime', $name)
        ->condition('prezime', $surname);
    $result = $query->execute()->fetchAssoc();

    if ($result) {
      $record = $result;
      $type = 'student';
    }

    // If not found in students, check the teachers table
    if (!$record) {
      $query = $this->database->select('teachers', 't')
        ->fields('t')
        ->condition('id', $id)
        ->condition('ime', $name)
        ->condition('prezime', $surname);
      $result = $query->execute()->fetchAssoc();

      if ($result) {
        $record = $result;
        $type = 'teacher';
      }
    }

    // If not found in teachers, check the users field data (administrators)
    if (!$record) {
      $query = $this->database->select('users_field_data', 'u')
        ->fields('u')
        ->condition('uid', $id)  // Corrected to uid for the users table
        ->condition('name', $name)
        ->condition('mail', $surname); // If surname is to be matched with email, this is fine
      $result = $query->execute()->fetchAssoc();

      if ($result) {
        $record = $result;
        $type = 'administrator';
      }
    }

    if (!$record) {
      return ['#markup' => 'Korisnik nije pronađen.'];
    }

    // Build form fields
    foreach ($record as $key => $value) {
      if ($key === 'id') continue;
      $form[$key] = [
        '#type' => 'textfield',
        '#title' => ucfirst(str_replace('_', ' ', $key)),
        '#default_value' => $value,
        '#required' => TRUE,
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
      '#value' => 'Sačuvaj izmene',
    ];

    $form['record_id'] = [
      '#type' => 'hidden',
      '#value' => $id,
    ];

    $form['record_type'] = [
      '#type' => 'hidden',
      '#value' => $type,
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $id = $form_state->getValue('record_id');
    $type = $form_state->getValue('record_type');

    switch ($type) {
      case 'student':
        $table = 'students';
        break;
      case 'teacher':
        $table = 'teachers';
        break;
      case 'administrator':
        $table = 'users_field_data';
        break;
      default:
        \Drupal::messenger()->addError('Nepoznat tip korisnika.');
        return;
    }

    // Get form field values
    $fields = $form_state->getValues();
    unset(
      $fields['submit'],
      $fields['form_build_id'],
      $fields['form_token'],
      $fields['form_id'],
      $fields['record_id'],
      $fields['record_type'],
      $fields['op']
    );

    // Update database
    $this->database->update($table)
      ->fields($fields)
      ->condition('id', $id)
      ->execute();

    \Drupal::messenger()->addMessage("Uspešno izmenjen $type sa ID-em: $id.");
  }

  public function backForm(array &$form, FormStateInterface $form_state) {
    $id = $form_state->getValue('record_id');
    $form_state->setRedirect('elektronski_dnevnik.admin_users_controller', ['id' => $id]);
  }
}

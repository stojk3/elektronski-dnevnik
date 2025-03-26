<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentActivityForm extends FormBase {

  public function getFormId() {
    return 'student_activity_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['datum_upisa'] = [
        '#type' => 'date',
        '#title' => 'Datum upisa',
        '#default_value' => date('Y-m-d', strtotime('+1 day')),
        '#required' => TRUE,
        '#min' => date('Y-m-d', strtotime('+1 day')),
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['vrsta_aktivnosti'] = [
        '#type' => 'select',
        '#title' => 'Vrsta aktivnosti',
        '#options' => [
            'odgovaranje' => 'Odgovaranje',
            'pismeni' => 'Pismeni',
            'kontrolni' => 'Kontrolni',
            'blic' => 'Blic test',
        ],
        '#required' => TRUE,
    ];

    $current_user = \Drupal::currentUser();
    $connection = \Drupal::database();
    $user_username = $current_user->getAccountName();

    $teacher_id = $this->getTeacherIdByUsername($user_username);

    $subjects_query = $connection->query(
      "SELECT id, ime FROM {subjects} WHERE id = (SELECT subject_id FROM {teachers} WHERE id = :teacher_id)",
      [':teacher_id' => $teacher_id]
    )->fetchAllKeyed();
    
    $departments_query = $connection->query("SELECT id, ime FROM {departments}")->fetchAllKeyed();

    $form['predmet'] = [
        '#type' => 'select',
        '#title' => 'Predmet',
        '#options' => $subjects_query,
        '#required' => TRUE,
    ];

    $form['odeljenje'] = [
        '#type' => 'select',
        '#title' => 'Odeljenje',
        '#options' => $departments_query,
        '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => 'Snimi',
    ];

    return $form;
  }

  protected function getTeacherIdByUsername($user_username) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
      ':username' => $user_username
    ])->fetchField();
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getAccountName();
    
    $teacher_id = $this->getTeacherIdByUsername($user_username);

    $connection->insert('student_activity')
      ->fields([
        'datum_upisa' => $form_state->getValue('datum_upisa'),
        'vrsta_aktivnost' => $form_state->getValue('vrsta_aktivnosti'),
        'department_id' => $form_state->getValue('odeljenje'),
        'predmet_id' => $form_state->getValue('predmet'),
        'teacher_id' => $teacher_id,
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Podaci o aktivnosti su uspešno sačuvani.');
  }
}

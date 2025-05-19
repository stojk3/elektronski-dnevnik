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
 '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],    ];

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
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $current_user = \Drupal::currentUser();
    $connection = \Drupal::database();
    $user_username = $current_user->getAccountName();

    $teacher_id = $this->getTeacherIdByUsername($user_username);

    $subjects_query = $connection->query(
      "SELECT id, ime FROM {subjects} WHERE id = (SELECT subject_id FROM {teachers} WHERE id = :teacher_id)",
      [':teacher_id' => $teacher_id]
    )->fetchAllKeyed();

    $departments_query = $connection->query("SELECT ime FROM {departments}")->fetchCol();

    $form['predmet'] = [
      '#type' => 'select',
      '#title' => 'Predmet',
      '#options' => $subjects_query,
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['odeljenje'] = [
      '#type' => 'select',
      '#title' => 'Odeljenje',
      '#options' => array_combine($departments_query, $departments_query),
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#attributes' => ['class' => ['btn-success']],
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

  protected function getDepartmentIdByClass($class) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {departments} WHERE ime = :ime", [
      ':ime' => $class
    ])->fetchField();
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getAccountName();

    $teacher_id = $this->getTeacherIdByUsername($user_username);

    $datum_upisa = $form_state->getValue('datum_upisa');
    $predmet_id = $form_state->getValue('predmet');
    $odeljenje_ime = $form_state->getValue('odeljenje');
    $odeljenje_id = $this->getDepartmentIdByClass($odeljenje_ime);

    $existing_activity = $connection->query(
      "SELECT COUNT(*) FROM {student_activity} WHERE datum_upisa = :datum AND predmet_id = :predmet_id AND department_id = :odeljenje_id",
      [
        ':datum' => $datum_upisa,
        ':predmet_id' => $predmet_id,
        ':odeljenje_id' => $odeljenje_id
      ]
    )->fetchField();

    if ($existing_activity > 0) {
      \Drupal::messenger()->addError('Za ovo odeljenje i predmet već postoji aktivnost na odabrani datum. Nemojte unositi više od jedne aktivnosti po danu.');
      return;
    }

    $connection->insert('student_activity')
      ->fields([
        'datum_upisa' => $datum_upisa,
        'vrsta_aktivnost' => $form_state->getValue('vrsta_aktivnosti'),
        'department_id' => $odeljenje_id,
        'predmet_id' => $predmet_id,
        'teacher_id' => $teacher_id,
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Podaci o aktivnosti su uspešno sačuvani.');
  }
}

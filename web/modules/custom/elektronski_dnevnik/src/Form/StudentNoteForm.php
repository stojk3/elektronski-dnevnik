<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentNoteForm extends FormBase {

  public function getFormId() {
    return 'student_note_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['datum_upisa'] = [
      '#type' => 'hidden',
      '#value' => date('Y-m-d'),
    ];

    $current_user = \Drupal::currentUser();
    $connection = \Drupal::database();
    $user_username = $current_user->getAccountName();
    $query = $connection->select('teachers', 't')
      ->fields('t', ['subject_id'])
      ->condition('t.username', $user_username, '=')
      ->execute()
      ->fetchCol();
    if (!empty($query)) {
      $subjects_id = $query;
      $subjects_query = $connection->select('subjects', 's')
        ->fields('s', ['id', 'ime'])
        ->condition('s.id', $subjects_id, 'IN')
        ->execute();
      $subjects = [];
      foreach ($subjects_query as $row) {
        $subjects[$row->id] = $row->ime;
      }
      $form['predmet'] = [
        '#type' => 'select',
        '#title' => 'Predmet',
        '#options' => $subjects,
        '#required' => TRUE,
        '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      ];
    } else {
      $form['message'] = [
        '#markup' => 'Nema predmeta blablabla',
      ];
    }

    $departments_query = $connection->query("SELECT id, ime FROM {departments}")->fetchAllKeyed();
    
    $form['odeljenje'] = [
      '#type' => 'select',
      '#title' => 'Odeljenje',
      '#options' => array_combine($departments_query, $departments_query),
      '#required' => TRUE,
      '#attributes' => ['style' => 'width: 810px; height: 40px; line-height: 38px; padding: 0 10px;'],
      '#ajax' => [
        'callback' => '::updateStudents',
        'wrapper' => 'combined-container',
        'event' => 'change',
      ],
    ];

    $form['combined-container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'combined-container'],
    ];

    $odeljenjePrivremeni = $form_state->getValue('odeljenje');
    $students = $this->loadStudentsByClass($odeljenjePrivremeni);

    $student_options = [];
    foreach ($students as $student) {
      if (isset($student->student_id, $student->ime, $student->prezime)) {
        $student_options[$student->student_id] = $student->ime . ' ' . $student->prezime;
      }
    }
    if (!empty($student_options)) {
      $form['combined-container']['ucenici'] = [
        '#type' => 'select',
        '#title' => 'Učenici',
        '#options' => $student_options,
      ];
    }

    $form['napomena'] = [
      '#type' => 'textarea',
      '#title' => 'Napomena',
      '#required' => TRUE,
      '#rows' => 4,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      '#value' => 'Snimi',
    ];

    $form['#attached']['html_head'][] = [
      [
        '#tag' => 'style',
        '#value' => '
          .input-group-addon { 
            display: none !important; 
          }
        ',
      ],
      'hide_ajax_button',
    ];    

    return $form;
  }

  protected function loadStudentsByClass($class) {
    $connection = \Drupal::database();
    $depId = $connection->query("SELECT id FROM {departments} WHERE ime LIKE :ime", [
      ':ime' => $class
    ])->fetchField();

    $students = $connection->query("
      SELECT s.id AS student_id, s.ime, s.prezime 
      FROM {students} s
      INNER JOIN {students_departments} sd ON s.id = sd.student_id
      WHERE sd.department_id = :department_id
    ", [
      ':department_id' => $depId
    ])->fetchAll();

    return $students;
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

    $predmet_id = $form_state->getValue('predmet');
    $odeljenje_ime = $form_state->getValue('odeljenje');
    $odeljenje_id = $this->getDepartmentIdByClass($odeljenje_ime);
    $student_id = $form_state->getValue('ucenici');

    $connection->insert('student_notes')
      ->fields([
        'datum_upisa' => $form_state->getValue('datum_upisa'),
        'napomena' => $form_state->getValue('napomena'),
        'department_id' => $odeljenje_id,
        'predmet_id' => $predmet_id,
        'student_id' => $student_id,
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Napomena je uspešno sačuvana.');
  }

  public function updateStudents(array &$form, FormStateInterface $form_state) {
    return $form['combined-container'];
  }
  
}

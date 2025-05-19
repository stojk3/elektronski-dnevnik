<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentClassForm extends FormBase {

  public function getFormId() {
    return 'student_class_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['datum_upisa'] = [
      '#type' => 'date',
      '#title' => 'Datum upisa',
      '#default_value' => date('Y-m-d'),
      '#required' => TRUE,
      '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],
      '#disabled' => TRUE,
      '#ajax' => [
        'callback' => '::updateWeekAndClasses',
        'wrapper' => 'combined-container',
      ],
    ];

    $selected_date = $form_state->getValue('datum_upisa') ?? date('Y-m-d');
    $week_number = $this->getWeekNumberFromDate($selected_date);

    $form['redni_broj_nedelje'] = [
      '#type' => 'number',
      '#title' => 'Redni broj nedelje',
      '#default_value' => $week_number,
      '#required' => TRUE,
      '#disabled' => TRUE,
       '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],
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
 '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],        '#ajax' => [
          'callback' => '::updateCombinedContainer',
          'wrapper' => 'combined-container',
        ],
      ];
    } else {
      $form['message'] = [
        '#markup' => 'Nema predmeta blablabla',
      ];
    }

    $departments_query = $connection->query("SELECT ime FROM {departments}")->fetchCol();

    $form['odeljenje'] = [
      '#type' => 'select',
      '#title' => 'Odeljenje',
      '#options' => array_combine($departments_query, $departments_query),
      '#required' => TRUE,
 '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],      '#ajax' => [
        'callback' => '::updateCombinedContainer',
        'wrapper' => 'combined-container',
        'event' => 'change',
      ],
    ];

    $form['combined-container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'combined-container'],
    ];


    $odeljenjePrivremeni = $form_state->getValue('odeljenje');
    $odeljenjeZaSlanje = $this->getDepartmentIdByClass($odeljenjePrivremeni);

    $avaliable_classes = $this->getAvailableClassNumbers($selected_date, $odeljenjeZaSlanje);

    $form['combined-container']['redni_broj_casa'] = [
      '#type' => 'select',
      '#title' => 'Redni broj časa',
      '#options' => $avaliable_classes,
      '#required' => TRUE,
 '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],    ];
    
    $total_classes = $this->getTotalClassesForSubjectAndClass(
      $form_state->getValue('predmet'),
      $odeljenjeZaSlanje,
    );

    $form['combined-container']['ukupno_casova'] = [
      '#type' => 'number',
      '#title' => 'Ukupan broj časova',
      '#default_value' => $total_classes,
      '#required' => TRUE,
       '#attributes' => ['style' => 'width: 1140px; height: 40px; line-height: 38px; padding: 0 10px;'],
      '#disabled' => TRUE,
    ];

    $students = $this->loadStudentsByClass($odeljenjePrivremeni);

    $student_options = [];
    foreach ($students as $student) {
      if (isset($student->student_id, $student->ime, $student->prezime)) {
        $student_options[$student->student_id] = $student->ime . ' ' . $student->prezime;
      }
    }

    if (!empty($student_options)) {
      $form['combined-container']['ucenici'] = [
        '#type' => 'checkboxes',
        '#title' => 'Učenici',
        '#options' => $student_options,
      ];
    }

    $form['tema'] = [
      '#type' => 'textarea',
      '#title' => 'Tema',
      '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Snimi',
      '#attributes' => ['class' => ['btn-success']],
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

  protected function getWeekNumberFromDate($date) {
    $first_week_date = '2024-09-01';
    $date_diff = (strtotime($date) - strtotime($first_week_date)) / (60 * 60 * 24 * 7);
    return ceil($date_diff) + 1;
  }

  protected function getAvailableClassNumbers($date, $odeljenje) {
    $connection = \Drupal::database();
    $result = $connection->query("SELECT redni_broj_casa FROM {student_class} WHERE datum_upisa = :date AND department_id = :odeljenje", [
      ':date' => $date,
      ':odeljenje' => $odeljenje,
    ])->fetchCol();

    $class_numbers = range(1, 7);
    foreach ($result as $taken_class) {
      unset($class_numbers[array_search($taken_class, $class_numbers)]);
    }

    $form['redni_broj_casa']['#options'] = array_combine($class_numbers, $class_numbers);

    return array_combine($class_numbers, $class_numbers);
  }

  protected function getTotalClassesForSubjectAndClass($subject, $class) {
    $connection = \Drupal::database();
    $total_classes = $connection->query("SELECT COUNT(*) FROM {student_class} WHERE predmet_id = :subject AND department_id = :class", [
      ':subject' => $subject,
      ':class' => $class,
    ])->fetchField();

    return $total_classes;
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

  protected function getSubjectIdBySubject($subject) {
    $connection = \Drupal::database();
    $subject_id = $connection->query("SELECT id FROM {subjects} WHERE ime = :ime", [
      ':ime' => $subject
    ])->fetchField();
    return $subject_id;
  }

  protected function getTeacherIdByUsername($user_username) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
      ':username' => $user_username
    ])->FetchField();
  }

  protected function isClassTaken($class, $date, $class_number) {
    $connection = \Drupal::database();
    $result = $connection->query("SELECT COUNT(*) FROM {student_class} WHERE datum_upisa = :date AND redni_broj_casa = :class_number AND department_id = :class", [
      ':date' => $date,
      ':class_number' => $class_number,
      ':class' => $class,
    ])->fetchField();
      
    \Drupal::logger('elektronski-dnevnik')->notice($result);

    return $result > 0;
  }
  

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $date = $form_state->getValue('datum_upisa');
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getDisplayName();

    $teacher_id = $this->getTeacherIdByUsername($user_username);

    $class = $form_state->getValue('odeljenje');
    $depId = $this->getDepartmentIdByClass($class);

    $connection->insert('student_class')
      ->fields([
        'tema' => $form_state->getValue('tema'),
        'datum_upisa' => $date,
        'ukupno_casova' => $form_state->getValue('ukupno_casova'),
        'redni_broj_casa' => $form_state->getValue('redni_broj_casa'),
        'department_id' => $depId,
        'teacher_id' => $teacher_id,
        'predmet_id' => $form_state->getValue('predmet'),
      ])
      ->execute();
    
    $selected_students = array_filter($form_state->getValue('ucenici'));
    if (!empty($selected_students)) {
        foreach ($selected_students as $student_id => $is_absent) {
            if ($is_absent) {
                $connection->insert('student_attendance')
                  ->fields([
                    'datum_upisa' => $date,
                    'redni_broj_casa' => $form_state->getValue('redni_broj_casa'),
                    'student_id' => $student_id,
                    'predmet_id' => $form_state->getValue('predmet'),
                  ])
                  ->execute();
            }
        }
    }
    \Drupal::messenger()->addMessage('Podaci o času i prisutnosti učenika su uspešno sačuvani.');
  }

  public function updateWeekAndClasses(array &$form, FormStateInterface $form_state) {
    $selected_date = $form_state->getValue('datum_upisa') ?? date('Y-m-d');
    $selected_class = $form_state->getValue('odeljenje');
    $form['redni_broj_nedelje']['#default_value'] = $this->getWeekNumberFromDate($selected_date);

    $class_numbers = range(1, 7);

    foreach ($class_numbers as $key => $class_number) {
      if ($this->isClassTaken($selected_class, $selected_date, $class_number)) {
        unset($class_numbers[$key]);
      }
    }

    $form['redni_broj_casa']['#options'] = $this->getAvailableClassNumbers($selected_date);

    return $form;
  }

  public function updateCombinedContainer(array &$form, FormStateInterface $form_state) {
    return $form['combined-container'];
  }

}

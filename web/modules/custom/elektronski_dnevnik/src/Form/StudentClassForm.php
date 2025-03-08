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
        '#title' => t('Datum upisa'),
        '#default_value' => date('Y-m-d'),
        '#required' => TRUE,
        '#ajax' => [
            'callback' => '::updateWeekAndClasses',
            'wrapper' => 'class-info-container',
        ],
    ];

    $selected_date = $form_state->getValue('datum_upisa') ?? date('Y-m-d');
    $week_number = $this->getWeekNumberFromDate($selected_date);

    $form['redni_broj_nedelje'] = [
        '#type' => 'number',
        '#title' => t('Redni broj nedelje'),
        '#default_value' => $week_number,
        '#required' => TRUE,
        '#disabled' => TRUE,
    ];

    $avaliable_classes = $this->getAvaliableClassNumbers($selected_date);

    $form['redni_broj_casa'] = [
        '#type' => 'select',
        '#title' => t('Redni broj časa'),
        '#options' => $avaliable_classes,
        '#required' => TRUE,
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

        $subjects_query = $connection->select('subject', 's')
                ->fields('s', ['id', 'predmet'])
                ->condition('s.id', $subjects_id, 'IN')
                ->execute();

        $subjects = [];
        foreach ($subjects_query as $row) {
            $subjects[$row->id] = t($row->predmet);
        }

        $form['predmet'] = [
            '#type' => 'select',
            '#title' => t('Predmet'),
            '#options' => $subjects,
            '#required' => TRUE,
            '#ajax' => [
                'callback' => '::updateCombinedContainer',
                'wrapper' => 'combined-container',
            ],
        ];
    } else {
        $form['message'] = [
            '#markup' => t('Nema predmeta blablabla'),
        ];
    }

    $form['odeljenje'] = [
        '#type' => 'select',
        '#title' => t('Odeljenje'),
        '#options' => [
            'I1' => t('I1'),
            'I2' => t('I2'),
            'I3' => t('I3'),
            'II1' => t('II1'),
            'II2' => t('II2'),
            'II3' => t('II3'),
            'III1' => t('III1'),
            'III2' => t('III2'),
            'III3' => t('III3'),
            'IV1' => t('IV1'),
            'IV2' => t('IV2'),
            'IV3' => t('IV3'),
        ],
        '#required' => TRUE,
        '#ajax' => [
            'callback' => '::updateCombinedContainer',
            'wrapper' => 'combined-container',
        ],
    ];

    $form['combined-container'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'combined-container'],
    ];

    $total_classes = $this->getTotalClassesForSubjectAndClass(
        $form_state->getValue('predmet'),
        $form_state->getValue('odeljenje'),
    );

    $form['combined-container']['ukupno_casova'] = [
        '#type' => 'number',
        '#title' => t('Ukupno CHASOVA(zameni ovde sa ch)'),
        '#default_value' => $total_classes,
        '#required' => TRUE,
        '#disabled' => TRUE,
    ];

    $selected_class = $form_state->getValue('odeljenje');
    $students = $this->loadStudentsByClass($selected_class);

    if (!empty($students)) {
        $form['combined-container']['ucenici'] = [
            '#type' => 'checkboxes',
            '#title' => 'Ucenici',
            '#options' => array_reduce($students, function ($carry, $student) {
                $carry[$student->id] = $student->first_name . ' ' . $student->last_name;
                return $carry;
            }, []),
        ];
    } else {
        $form['combined-container']['ucenici'] = [
            '#markup' => t('Nema ucenika u @odeljenje', ['@odeljenje' => $selected_class]),
        ];
    }

    $form['tema'] = [
        '#type' => 'textarea',
        '#title' => t('Tema'),
        '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => t('Snimi'),
    ];

    return $form;
  }

  protected function getWeekNumberFromDate($date) {
    $first_week_date = '2024-09-01';
    $date_diff = (strtotime($date) - strtotime($first_week_date)) / (60 *60 *24 * 7);
    return ceil($date_diff) + 1;
  }

  protected function getAvailableClassNumbers($date) {
    $connection = \Drupal::database();
    $result = $connection->query("SELECT redni_broj_casa FROM {student_class} WHERE datum_upisa = :date", [
      ':date' => $date,
    ])->fetchCol();

    $class_numbers = range(1, 7);
    foreach ($result as $taken_class) {
      unset($class_numbers[array_search($taken_class, $class_numbers)]);
    }

    return array_combine($class_numbers, $class_numbers);
  }

  protected function getTotalClassesForSubjectAndClass($subject, $class) {
    $connection = \Drupal::database();
    return $connection->query("SELECT COUNT(*) FROM {student_class} WHERE predmet_id = :subject AND department_id = :class", [
      ':subject' => $subject,
      ':class' => $class,
    ])->fetchField();
  }
  
  protected function loadStudentsByClass($class) {
    $connection = \Drupal::database();
    $depId = $connection->query("SELECT id FROM {departments} WHERE ime LIKE :ime", [
      ':ime' => $class
    ])->fetchField();

    return $connection->query("SELECT student_id FROM {students_departments} WHERE department_id = :department_id", [
        ':department_id' => $depId
    ])->fetchAll();
  }

  protected function getDepartmentIdByClass($class) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {departments} WHERE ime = :ime", [
        ':ime' => $class
    ])->fetchField();
  }

  protected function getSubjectIdBySubject($subject) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {subjects} WHERE ime = :ime", [
        ':ime' => $subject
    ])->fetchField();
  }

  protected function getTeacherIdByUsername($user_username) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
        ':username' => $user_username
    ])->FetchField();
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $date = $form_state->getValue('datum_upisa');
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getAccountName();

    $teacher_id = getTeacherIdByUsername($user_username);

    $class = $form_state->getValue('odeljenje');
    $depId = $this->getDepartmentIdByClass($class);

    $subject = $form_state->getValue('predmet');
    $subject_id = $this->getSubjectIdBySubject($subject);

    $connection->insert('class_entries')
      ->fields([
        'tema' => $form_state->getValue('tema'),
        'datum_upisa' => $date,
        'ukupno_casova' => $form_state->getValue('ukupno_casova'),
        'redni_broj_casa' => $form_state->getValue('redni_broj_casa'),
        'department_id' => $depId,
        'teacher_id' => $teacher_id,
        'predmet_id' => $subject_id,
      ])
      ->execute();

    foreach ($form_state->getValue('ucenici') as $student_id => $is_absent) {
      if ($is_absent) {
        $connection->insert('student_attendance')
          ->fields([
            'datum_upisa' => $date,
            'redni_broj_casa' => $form_state->getValue('redni_broj_casa'),
            'student_id' => $student_id,
            'predmet_id' => $subject_id,
          ])
          ->execute();
      }
    }

    \Drupal::messenger()->addMessage(t('Podaci o času i prisutnosti učenika su uspešno sačuvani.'));
  }

  public function updateWeekAndClasses(array &$form, FormStateInterface $form_state) {
    return $form;
  }

  public function updateCombinedContainer(array &$form, FormStateInterface $form_state) {
    return $form['combined_container'];
  }
}
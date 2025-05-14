<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class HomeRoomAttendanceForm extends FormBase {

  public function getFormId() {
    return 'homeroom_attendance_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getAccountName();

    $teacher_id = $this->getTeacherIdByUsername($user_username);
    $department_id = $this->getDepartmentIdByTeacherId($teacher_id);
    $students = $this->getStudents($department_id);

    $form['students'] = [
      '#type' => 'table',
      '#header' => ['Ime i Prezime', 'Predmet', 'Datum', 'Redni broj časa', 'Izostanci'],
      '#empty' => t('Nema izostanaka.'),
    ];

    foreach ($students as $student) {
      $row_id = $student->student_id . '_' . str_replace('-', '', $student->datum_upisa) . '_' . $student->redni_broj_casa . '_' . $student->predmet_id;
      $form['students'][$row_id] = [
        'full_name' => [
          '#type' => 'markup',
          '#markup' => $student->ime . ' ' . $student->prezime,
        ],
        'subject' => [
          '#type' => 'markup',
          '#markup' => $student->predmet,
        ],
        'date' => [
          '#type' => 'markup',
          '#markup' => $student->datum_upisa
        ],
        'class_number' => [
          '#type' => 'markup',
          '#markup' => $student->redni_broj_casa,
        ],
        'attendance' => [
          '#type' => 'select',
          '#options' => [
            'present' => t('Present'),
            'absent' => t('Absent'),
            'late' => t('Late'),
          ],
        ],
      ];
    }

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save Attendance'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    foreach ($values['students'] as $student_id => $attendance) {
      $this->saveAttendance($student_id, $attendance['attendance']);
    }
    \Drupal::messenger()->addMessage(t('Attendance saved successfully.'));
  }

  protected function getStudents($department_id) {
    $connection = \Drupal::database();

    $query = $connection->select('student_attendance', 'sa');
    $query->fields('sa', ['student_id', 'datum_upisa', 'redni_broj_casa', 'predmet_id']);

    $query->innerJoin('students', 'st', 'sa.student_id = st.id');
    $query->fields('st', ['ime', 'prezime']);

    $query->innerJoin('subjects', 'p', 'sa.predmet_id = p.id');
    $query->addField('p', 'ime', 'predmet');

    $query->innerJoin('students_departments', 'sd', 'st.id = sd.student_id');
    $query->condition('sd.department_id', $department_id, '=');

    $result = $query->execute()->fetchAll();
    return $result;
  }

  protected function getTeacherIdByUsername($user_username) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
      ':username' => $user_username,
    ])->fetchField();
  }

  protected function getDepartmentIdByTeacherId($teacher_id) {
    $connection = \Drupal::database();
    $query = $connection->select('teachers_departments', 'td');
    $query->fields('td', ['department_id']);
    $query->condition('td.teacher_id', $teacher_id, '=');
    return $query->execute()->fetchField();
  }

  protected function saveAttendance($student_id, $attendance_status) {
    $connection = \Drupal::database();
    $connection->merge('student_attendance')
      ->key(['student_id' => $student_id])
      ->fields(['attendance_status' => $attendance_status])
      ->execute();
  }
}

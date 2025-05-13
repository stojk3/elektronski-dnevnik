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
        $connection = \Drupal::database();
        $user_username = $current_user->getAccountName();

        $teacher_id = $this->getTeacherIdByUsername($user_username);
        $department_id = $this->getClassId($teacher_id);
        $students = $this->getStudents($department_id);
        $form['students'] = [
            '#type' => 'table',
            '#header' => ['Ime i Prezime', 'Izostanci'],
            '#empty' => t('Nema izostanaka.'),
        ];
        foreach ($students as $student) {
            $form['students'][$student->id] = [
                'full_name' => [
                    '#type' => 'markup',
                    '#markup' => $student->ime . ' ' . $student->prezime,
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

        // Prvo uzmi sve student_id za dati department_id
        $student_ids = $connection->select('students_departments', 'sd')
            ->fields('sd', ['student_id'])
            ->condition('sd.department_id', $department_id, '=')
            ->execute()
            ->fetchCol(); // fetchCol() vraća niz vrednosti iz jedne kolone

        // Ako nema studenata, vrati prazan niz
        if (empty($student_ids)) {
            return [];
        }

        // Sada uzmi samo studente koji su u tabeli student_attendance
        $attendance_student_ids = $connection->select('student_attendance', 'sa')
            ->fields('sa', ['student_id'])
            ->condition('sa.student_id', $student_ids, 'IN') // Proveri samo studente iz prvog upita
            ->execute()
            ->fetchCol(); // fetchCol() vraća niz student_id iz tabele student_attendance

        // Ako nema studenata u tabeli student_attendance, vrati prazan niz
        if (empty($attendance_student_ids)) {
            return [];
        }

        // Dohvati ime i prezime iz tabele students za sve student_id koji su u tabeli student_attendance
        return $connection->select('students', 'st')
            ->fields('st', ['id', 'ime', 'prezime']) // Pretpostavljam da su kolone 'id', 'ime', 'prezime'
            ->condition('st.id', $attendance_student_ids, 'IN') // Koristi IN za niz student_id
            ->execute()
            ->fetchAll();
    }

    protected function getClassId($teacher_id) {
        $connection = \Drupal::database();
        return $connection->select('teachers_departments', 't')
            ->fields('t', ['department_id'])
            ->condition('t.teacher_id', $teacher_id, '=')
            ->execute()
            ->fetchField();
    }

    protected function getTeacherIdByUsername($user_username) {
        $connection = \Drupal::database();
        return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
          ':username' => $user_username
        ])->fetchField();
    }
}

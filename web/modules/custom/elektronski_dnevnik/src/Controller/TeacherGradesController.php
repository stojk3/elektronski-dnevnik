<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TeacherGradesController extends ControllerBase {

    public function viewGrades() {
        $form = [];

        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();

        $teacher_id = $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $department_id = $connection->query("SELECT department_id FROM {teachers_departments} WHERE teacher_id = :teacher_id", [
            ':teacher_id' => $teacher_id
        ])->fetchField();

        $students = $this->loadStudentsByClass($department_id);
        $subjects = $this->loadSubjects();

        $rows = [];
        foreach ($students as $student) {
            $grades = $this->loadGradesForStudent($student->student_id);
            $row = [
                'student' => $student->ime . ' ' . $student->prezime,
            ];

            foreach ($subjects as $subject) {
                $subject_grades = $grades[$subject->id] ?? [];
                $row[$subject->id] = empty($subject_grades) ? $this->t('/') : implode(', ', $subject_grades);
            }

            $rows[] = $row;
        }

        $header = ['student' => $this->t('Učenik')] + array_column($subjects, 'ime', 'id');

        $form['grades_table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('Nema podataka.'),
        ];

        return $form;
    }

    protected function loadSubjects() {
        $connection = \Drupal::database();
        return $connection->query("SELECT id, ime FROM {subjects}")->fetchAll();
    }

    protected function loadGradesForStudent($student_id) {
        $connection = \Drupal::database();
        $results = $connection->query("SELECT ocena, predmet_id FROM {student_grades} WHERE student_id = :student_id", [
            ':student_id' => $student_id
        ])->fetchAll();

        $grades_by_subject = [];
        foreach ($results as $result) {
            $grades_by_subject[$result->predmet_id][] = $result->ocena;
        }

        return $grades_by_subject;
    }

    protected function loadStudentsByClass($department_id) {
        $connection = \Drupal::database();
        return $connection->query("SELECT s.id AS student_id, s.ime, s.prezime FROM {students} s INNER JOIN {students_departments} sd ON s.id = sd.student_id WHERE sd.department_id = :department_id", [
            ':department_id' => $department_id
        ])->fetchAll();
    }
}

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

        $query = $connection->select('teachers', 't')
        ->fields('t', ['subject_id'])
        ->condition('t.username', $user_username, '=')
        ->execute()
        ->fetchCol();
    }

    public function viewGrades(Request $request = null) {
        $request = $request ?? \Drupal::request();
        $form = [];

        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = Database::getConnection();

        $teacher_id = $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $department_id = $connection->query("SELECT department_id FROM {teachers_departments} WHERE teacher_id = :teacher_id", [
            ':teacher_id' => $teacher_id
        ])->fetchField();

        $selected_semester = $request->query->get('semester') ?? '1';

        $form['semester_select'] = [
            '#type' => 'form',
            '#method' => 'get',
            '#action' => \Drupal::request()->getRequestUri(),
            'semester' => [
                '#type' => 'select',
                '#title' => $this->t('Izaberi polugodište'),
                '#options' => [
                    '1' => 'Prvo polugodište',
                    '2' => 'Drugo polugodište',
                    '3' => 'Kombinovano',
                ],
                '#value' => $selected_semester,
                '#attributes' => ['onchange' => 'this.form.submit();'],
                '#name' => 'semester',
            ],
        ];

        $students = $this->loadStudentsByClass($department_id);
        $subjects = $this->loadSubjects();

        $rows = [];
        foreach ($students as $student) {
            $grades = $this->loadGradesForStudent($student->student_id);
            $row = [
                'student' => $student->ime . ' ' . $student->prezime,
            ];

            $subject_averages = [];

            foreach ($subjects as $subject) {
                $subject_grades = $grades[$subject->id][$selected_semester] ?? [];

                $row[$subject->id] = !empty($subject_grades) ? implode(', ', $subject_grades) : $this->t('');

                if (!empty($subject_grades)) {
                    $subject_avg = array_sum($subject_grades) / count($subject_grades);
                    $rounded = ($subject_avg - floor($subject_avg) >= 0.5)
                        ? ceil($subject_avg)
                        : floor($subject_avg);
                    $subject_averages[] = $rounded;
                }
            }

            $row['average'] = !empty($subject_averages)
                ? number_format(array_sum($subject_averages) / count($subject_averages), 2, ',', '.')
                : $this->t('');

            $rows[] = $row;
        }

        $header = ['student' => $this->t('Učenik')] + array_column($subjects, 'ime', 'id') + ['average' => $this->t('Prosek')];

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
        $results = $connection->query("SELECT ocena, predmet_id, datum_upisa FROM {student_grades} WHERE student_id = :student_id", [
            ':student_id' => $student_id
        ])->fetchAll();

        $grades_by_subject = [];

        foreach ($results as $result) {
            $semester = $this->getSemesterForGrade($result->datum_upisa);
            if (!isset($grades_by_subject[$result->predmet_id])) {
                $grades_by_subject[$result->predmet_id] = ['1' => [], '2' => []];
            }
            if ($semester === '1' || $semester === '2') {
                $grades_by_subject[$result->predmet_id][$semester][] = $result->ocena;
            }
        }

        // Kombinovano sabira sve
        foreach ($grades_by_subject as $subject_id => &$entry) {
            $entry['3'] = array_merge($entry['1'], $entry['2']);
        }

        return $grades_by_subject;
    }

    protected function loadStudentsByClass($department_id) {
        $connection = \Drupal::database();
        return $connection->query("SELECT s.id AS student_id, s.ime, s.prezime FROM {students} s INNER JOIN {students_departments} sd ON s.id = sd.student_id WHERE sd.department_id = :department_id", [
            ':department_id' => $department_id
        ])->fetchAll();
    }

    private function getSemesterForGrade($datum) {
        if ($datum >= '2024-09-01' && $datum <= '2024-12-24') {
            return '1';
        } elseif ($datum >= '2025-01-15' && $datum <= '2025-06-24') {
            return '2';
        }
        return '0';
    }
}

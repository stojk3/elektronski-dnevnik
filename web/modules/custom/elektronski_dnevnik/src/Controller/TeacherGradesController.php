<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class TeacherGradesController extends ControllerBase {

    public function handle(Request $request) {
        $connection = Database::getConnection();
        $build = [];

        $departments = $connection->select('departments', 'd')
            ->fields('d', ['id', 'ime'])
            ->execute()
            ->fetchAllKeyed();

        $options = $departments;

        $selected_department = $request->query->get('department');
        $selected_semester = $request->query->get('semester');
        if (empty($selected_semester)) {
            $selected_semester = '1';
        }

        $semester_options = [
          '1' => 'Prvo polugodište',
          '2' => 'Drugo polugodište',
          '3' => 'Kombinovano',
      ];

      $build['form'] = [
          '#type' => 'form',
          '#method' => 'get',
          '#action' => \Drupal::request()->getRequestUri(),
          'department' => [
            '#type' => 'select',
            '#title' => $this->t('Izaberi odeljenje'),
            '#options' => $options,
            '#value' => $selected_department ?? '',
            '#attributes' => ['onchange' => 'this.form.submit();'],
            '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
            '#name' => 'department',
         ],  
          'semester' => [
              '#type' => 'select',
              '#title' => $this->t('Izaberi polugodište'),
              '#options' => $semester_options,
              '#value' => $selected_semester,
              '#attributes' => ['onchange' => 'this.form.submit();'],
              '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
              '#name' => 'semester',
          ],
      ];      

      if (!empty($selected_department) && in_array($selected_semester, ['1', '2', '3'])) {
          $students = $this->getStudentIdsByDepartment($connection, $selected_department);
          $subject_id = $this->getSubjectIdForCurrentUser($connection);
          if ($subject_id && !empty($students)) {
              $grades = [];
              if ($selected_semester == '3') {
                $grades_1 = $this->getGrades($connection, array_keys($students), $subject_id, '1');
                $grades_2 = $this->getGrades($connection, array_keys($students), $subject_id, '2');

                foreach ($grades_2 as $student_id => $grade_list) {
                    if (isset($grades_1[$student_id])) {
                        $grades_1[$student_id] = array_merge($grades_1[$student_id], $grade_list);
                    } else {
                        $grades_1[$student_id] = $grade_list;
                    }
                }
                $grades = $grades_1;
              } else {
                  $grades = $this->getGrades($connection, array_keys($students), $subject_id, $selected_semester);
              }
            
              $header = ['Učenik', 'Ocene', 'Prosek'];
              $rows = [];
              foreach ($students as $student_id => $student_name) {
                $student_grades = $grades[$student_id] ?? [];
                $average = count($student_grades) > 0 ? array_sum($student_grades) / count($student_grades) : 0;
                $average_formatted = count($student_grades) > 0 ? number_format($average, 2, ',', '.') : '';
                $rows[] = [
                    'data' => [
                        $student_name,
                        implode(', ', $student_grades),
                        $average_formatted,
                    ],
                ];
              }            
              $build['table'] = [
                  '#type' => 'table',
                  '#header' => $header,
                  '#rows' => $rows,
                  '#empty' => $this->t('Nema podataka.'),
              ];
          }
      }
      return $build;
    }

    private function getStudentIdsByDepartment($connection, $department_id) {
        $student_ids_query = $connection->select('students_departments', 'sd')
            ->fields('sd', ['student_id'])
            ->condition('department_id', $department_id)
            ->execute();

        $student_ids = [];
        foreach ($student_ids_query as $record) {
            $student_ids[] = $record->student_id;
        }

        if (empty($student_ids)) {
            return [];
        }

        $students_query = $connection->select('students', 's')
            ->fields('s', ['id', 'ime', 'prezime'])
            ->condition('id', $student_ids, 'IN')
            ->execute();

        $students = [];
        foreach ($students_query as $record) {
            $students[$record->id] = $record->ime . ' ' . $record->prezime;
        }

        return $students;
    }

    private function getSubjectIdForCurrentUser($connection) {
        $current_user = \Drupal::currentUser()->getAccountName();

        $subject_id = $connection->select('teachers', 't')
            ->fields('t', ['subject_id'])
            ->condition('username', $current_user)
            ->execute()
            ->fetchField();

        return $subject_id;
    }

    private function getGrades($connection, array $student_ids, $subject_id, $semester) {
        $query = $connection->select('student_grades', 'g')
            ->fields('g', ['student_id', 'ocena', 'datum_upisa'])
            ->condition('predmet_id', $subject_id)
            ->condition('student_id', $student_ids, 'IN');

        if ($semester == '1') {
            $query->condition('datum_upisa', ['2024-09-01', '2024-12-24'], 'BETWEEN');
        } elseif ($semester == '2') {
            $query->condition('datum_upisa', ['2025-01-15', '2025-06-24'], 'BETWEEN');
        }

        $results = $query->execute();

        $grades = [];
        foreach ($results as $record) {
            $grades[$record->student_id][] = $record->ocena;
        }

        return $grades;
    }
}

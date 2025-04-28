<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class TeacherGradesController extends ControllerBase {

    public function handle(Request $request) {
        $connection = Database::getConnection();
        $build = [];
      
        // Korak 1: Ucitaj sva odeljenja za select box
        $departments = $connection->select('departments', 'd')
          ->fields('d', ['id', 'ime'])
          ->execute()
          ->fetchAllKeyed();
      
        // Renderuj select box
        $options = ['' => '- Izaberi odeljenje -'] + $departments;
      
        // Uhvati selektovano odeljenje
        $selected_department = \Drupal::request()->query->get('department');
      
        $build['form'] = [
          '#type' => 'form',
          '#method' => 'get',
          '#action' => \Drupal::request()->getRequestUri(),
          'department' => [
            '#type' => 'select',
            '#title' => $this->t('Izaberi odeljenje'),
            '#options' => $options,
            '#default_value' => $selected_department ?? '',
            '#attributes' => [
              'onchange' => 'this.form.submit();',
            ],
            '#name' => 'department', // OVO JE BITNO
          ],
        ];
      
        // Ako je odabrano odeljenje, prikazi tabelu
        if (!empty($selected_department)) {
          $students = $this->getStudentIdsByDepartment($connection, $selected_department);
          $subject_id = $this->getSubjectIdForCurrentUser($connection);
      
          if ($subject_id && !empty($students)) {
            $grades = $this->getGrades($connection, array_keys($students), $subject_id);
      
            // Napravi tabelu
            $header = ['Učenik', 'Ocene'];
            $rows = [];
      
            foreach ($grades as $student_id => $student_grades) {
              // Prikazujemo ime i prezime učenika
              $student_name = isset($students[$student_id]) ? $students[$student_id] : $student_id;

              $rows[] = [
                'data' => [
                  $student_name, // Ime učenika
                  implode(', ', $student_grades), // Ocene
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
        // Prvi upit: Uzimamo sve student_id vrednosti iz students_departments
        $student_ids_query = $connection->select('students_departments', 'sd')
            ->fields('sd', ['student_id'])
            ->condition('department_id', $department_id) // Filtriramo prema department_id
            ->execute();
    
        // Sakupljamo sve student_id u niz
        $student_ids = [];
        foreach ($student_ids_query as $record) {
            $student_ids[] = $record->student_id;
        }
    
        // Ako nema studenata u ovom odeljenju, vraćamo prazan niz
        if (empty($student_ids)) {
            return [];
        }
    
        // Drugi upit: Uzimamo ime i prezime svih studenata za dobijene student_id
        $students_query = $connection->select('students', 's')
            ->fields('s', ['id', 'ime', 'prezime'])
            ->condition('id', $student_ids, 'IN') // Filtriramo po student_id
            ->execute();
    
        // Sakupljamo ime i prezime studenata u niz
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

    private function getGrades($connection, array $student_ids, $subject_id) {
        $query = $connection->select('student_grades', 'g')
          ->fields('g', ['student_id', 'ocena'])
          ->condition('predmet_id', $subject_id)
          ->condition('student_id', $student_ids, 'IN')
          ->execute();

        $grades = [];
        foreach ($query as $record) {
          $grades[$record->student_id][] = $record->ocena;
        }
        return $grades;
    }

}

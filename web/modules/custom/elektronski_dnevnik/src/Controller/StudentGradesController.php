<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StudentGradesController extends ControllerBase {

    public function viewGrades() {
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();

        $student_id = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $results = $connection->query("SELECT ocena, predmet_id FROM {student_grades} WHERE student_id = :student_id", [
            ':student_id' => $student_id
        ])->fetchAll();  

        if (empty($results)) {
            return ['#markup' => $this->t('Nemate zabeležene ocene.')];
        }

        $grades_by_subject = [];
        foreach ($results as $result) {
            $subject_id = $result->predmet_id;
            if (!isset($grades_by_subject[$subject_id])) {
                $grades_by_subject[$subject_id] = [];
            }
            $grades_by_subject[$subject_id][] = [
                'ocena' => $result->ocena,
            ];
        }

        $subjects = [];
        foreach (array_keys($grades_by_subject) as $subject_id) {
            $subject_data = $connection->query("SELECT ime FROM {subjects} WHERE id = :subject_id", [
                ':subject_id' => $subject_id
            ])->fetchAssoc();
            $subjects[$subject_id] = $subject_data ? $subject_data['ime'] : $this->t('Nepoznati predmet');
        }

        $rows = [];
        foreach ($grades_by_subject as $subject_id => $grades) {
            $grades_string = [];
            $sum = 0;
            foreach ($grades as $grade) {
                $grades_string[] = "{$grade['ocena']}"; 
                $sum += $grade['ocena'];
            }
            $average = $sum / count($grades);
            $rows[] = [
                'subject' => ucfirst($subjects[$subject_id]),
                'grades' => implode(', ', $grades_string),
                'average' => number_format($average, 2),
            ];
        }

        $header = [
            'subject' => $this->t('Predmet'),
            'grades' => $this->t('Ocene'),
            'average' => $this->t('Prosečna ocena'),
        ];

        return [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('Nemate zabeležene ocene.'),
        ];
    }
}

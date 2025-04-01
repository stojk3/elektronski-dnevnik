<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StudentGradesController extends ControllerBase {

    protected $currentUser;

    public function __construct(AccountInterface $current_user) {
        $this->currentUser = $current_user;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('current_user')
        );
    }

    public function viewGrades() {
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();
    
        $user_data = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchAssoc();
    
        $student_id = $user_data['id'];
    
        $query = $connection->select('student_grades', 'g');
        $query->fields('g', ['ocena', 'predmet_id', 'tip_ocene', 'datum_upisa']);
        $query->condition('student_id', $student_id);
        $results = $query->execute()->fetchAll();
    
        if (empty($results)) {
            \Drupal::logger('elektronski_dnevnik')->info('Nema ocena za studenta ID: @student_id', ['@student_id' => $student_id]);
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
                'tip' => $result->tip_ocene,
                'datum' => $result->datum_upisa,
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
            foreach ($grades as $grade) {
                $grades_string[] = "{$grade['ocena']} ({$grade['tip']}, {$grade['datum']})";
            }
    
            $rows[] = [
                'subject' => ucfirst($subjects[$subject_id]),
                'grades' => implode('<br>', $grades_string), // Prikazivanje svih ocena u tom predmetu
                'id' => $subject_id,
            ];
        }
    
        $header = [
            'subject' => $this->t('Predmet'),
            'grades' => $this->t('Ocene'),
        ];
    
        return [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('Nemate zabeležene ocene.'),
            '#attributes' => ['class' => ['table', 'table-striped', 'table-bordered']], // Dodavanje Bootstrap klasa
            '#attached' => [
                'library' => [
                    'elektronski_dnevnik/grade_toggle', // Tvoj jQuery
                ],
            ],
        ];
    }    
}

<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StudentAttendanceController extends ControllerBase {
    
    public function viewAttendance() {
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();
    
        $student_id = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $results = $connection->query("SELECT datum_upisa, redni_broj_casa, predmet_id FROM {student_attendance} WHERE student_id = :student_id ORDER BY datum_upisa DESC", [
            ':student_id' => $student_id
        ])->fetchAll();          
    
        if (empty($results)) {
            return ['#markup' => $this->t('Nema evidentiranih izostanaka.')];
        }

        $attendance_by_date = [];
        foreach ($results as $record) {
            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :id", [
                ':id' => $record->predmet_id
            ])->fetchField();
    
            $attendance_by_date[$record->datum_upisa][] = [
                'redni_broj_casa' => $record->redni_broj_casa,
                'predmet' => $subject_name,
            ];
        }

        $rows = [];
        foreach ($attendance_by_date as $date => $classes) {
            $class_info = '';
            foreach ($classes as $class) {
                $class_info .= $class['predmet'] . ' - ' . $class['redni_broj_casa'] . '. čas<br>';
            }
    
            $rows[] = [
                'datum' => $date,
                'prisustvo' => [
                    'data' => ['#markup' => $class_info],
                ],
            ];
        }
    
        $header = [
            'datum' => $this->t('Datum'),
            'prisustvo' => $this->t('Izostali časovi'),
        ];
    
        return [
            '#type' => 'container',
            'attendance_table' => [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => $this->t('Nema evidentiranih prisustava.'),
            ],
            'total_absences' => [
                '#markup' => '<p><strong>' . $this->t('Ukupan broj izostanaka: @count', ['@count' => count($results)]) . '</strong></p>',
            ],
        ];        
    }
}
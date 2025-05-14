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

        $results = $connection->query("SELECT datum_upisa, redni_broj_casa, predmet_id, definisanost FROM {student_attendance} WHERE student_id = :student_id ORDER BY datum_upisa DESC", [
            ':student_id' => $student_id
        ])->fetchAll();          
    
        if (empty($results)) {
            return ['#markup' => $this->t('Nema evidentiranih izostanaka.')];
        }

        $opravdano_count = 0;
        $neopravdano_count = 0;
        $nedefinisano_count = 0;

        $attendance_by_date = [];
        foreach ($results as $record) {
            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :id", [
                ':id' => $record->predmet_id
            ])->fetchField();
    
            $attendance_by_date[$record->datum_upisa][] = [
                'redni_broj_casa' => $record->redni_broj_casa,
                'predmet' => $subject_name,
                'definisanost' => $record->definisanost,
            ];

            switch ($record->definisanost) {
                case 'opravdano':
                    $opravdano_count++;
                    break;
                case 'neopravdano':
                    $neopravdano_count++;
                    break;
                default:
                    $nedefinisano_count++;
                    break;
            }
        }

        $rows = [];
        foreach ($attendance_by_date as $date => $classes) {
            foreach ($classes as $class) {
                $rows[] = [
                    'datum' => date('d-m-Y', strtotime($date)),
                    'predmet' => $class['predmet'],
                    'cas' => $class['redni_broj_casa'],
                    'definisanost' => ucfirst($class['definisanost']),
                ];
            }
        }
    
        $header = [
            'datum' => $this->t('Datum'),
            'predmet' => $this->t('Predmet'),
            'cas' => $this->t('Redni broj časa'),
            'definisanost' => $this->t('Opravdano/Neopravdano'),
        ];
    
        return [
            '#type' => 'container',
            'attendance_table' => [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => $this->t('Nema evidentiranih prisustava.'),
            ],
            'justified_absences' => [
                '#markup' => '<p><strong>' . $this->t('Broj opravdanih izostanaka: @count', ['@count' => $opravdano_count]) . '</strong></p>',
            ],
            'unjustified_absences' => [
                '#markup' => '<p><strong>' . $this->t('Broj neopravdanih izostanaka: @count', ['@count' => $neopravdano_count]) . '</strong></p>',
            ],
            'undefined_absences' => [
                '#markup' => '<p><strong>' . $this->t('Broj nedefinisanih izostanaka: @count', ['@count' => $nedefinisano_count]) . '</strong></p>',
            ],
            'total_absences' => [
                '#markup' => '<p><strong>' . $this->t('Ukupan broj izostanaka: @count', ['@count' => count($results)]) . '</strong></p>',
            ],
        ];        
    }
}
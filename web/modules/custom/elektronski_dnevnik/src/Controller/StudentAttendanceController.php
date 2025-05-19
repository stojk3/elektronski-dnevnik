<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class StudentAttendanceController extends ControllerBase {
    
    public function viewAttendance(Request $request = null) {
        $request = $request ?? \Drupal::request();
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();
    
        $student_id = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $selected_semester = $request->query->get('semester') ?? '1';

        $form = [
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
                '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
                '#name' => 'semester',
            ],
        ];

        $query = $connection->select('student_attendance', 'sa');
        $query->fields('sa', ['datum_upisa', 'redni_broj_casa', 'predmet_id', 'definisanost']);
        $query->condition('sa.student_id', $student_id);
    
        if ($selected_semester === '1') {
            $dates = ['2024-09-01', '2024-12-24'];
            $query->condition('sa.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        }
        if ($selected_semester === '2') {
            $dates = ['2025-01-15', '2025-06-24'];
            $query->condition('sa.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        }
    
        $query->orderBy('sa.datum_upisa', 'DESC');
        $results = $query->execute()->fetchAll();

        if (empty($results)) {
            return [
                $form,
                ['#markup' => $this->t('Nema evidentiranih izostanaka za izabrano polugodište.')]
            ];
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
            $form,
            [
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

    private function getSemesterForGrade($datum) {
        if ($datum >= '2024-09-01' && $datum <= '2024-12-24') {
            return '1';
        } elseif ($datum >= '2025-01-15' && $datum <= '2025-06-24') {
            return '2';
        }
        return '0';
    }
}
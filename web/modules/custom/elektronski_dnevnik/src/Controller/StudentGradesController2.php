<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class StudentGradesController2 extends ControllerBase {

    public function viewGrades(Request $request = null) {
        $request = $request ?? \Drupal::request();
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = Database::getConnection();

        $student_id = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        if (!$student_id) {
            return ['#markup' => $this->t('Niste prijavljeni kao učenik.')];
        }

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
                ],
                '#value' => $selected_semester,
                '#attributes' => [
                    'onchange' => 'this.form.submit();',
                    'style' => 'height: 40px; line-height: 38px; padding: 0 10px;',
                ],
                '#name' => 'semester',
            ],
        ];

        $query = $connection->select('student_grades', 'sg');
        $query->fields('sg', ['ocena', 'predmet_id', 'datum_upisa', 'tip_ocene']);
        $query->condition('sg.student_id', $student_id);

        if ($selected_semester === '1') {
            $dates = ['2024-09-01', '2024-12-24'];
            $query->condition('sg.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        } elseif ($selected_semester === '2') {
            $dates = ['2025-01-15', '2025-06-24'];
            $query->condition('sg.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        }

        $query->orderBy('sg.datum_upisa', 'DESC');
        $grades_query = $query->execute()->fetchAll();

        $rows = [];
        foreach ($grades_query as $grade) {
            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :id", [
                ':id' => $grade->predmet_id
            ])->fetchField();

            $rows[] = [
                'predmet' => $subject_name,
                'ocena' => $grade->ocena,
                'tip_ocene' => ucfirst($grade->tip_ocene),
                'datum' => date('d-m-Y', strtotime($grade->datum_upisa)),
            ];
        }

        $header = [
            'predmet' => $this->t('Predmet'),
            'ocena' => $this->t('Ocena'),
            'tip_ocene' => $this->t('Tip ocene'),
            'datum' => $this->t('Datum'),
        ];

        return [
            $form,
            [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => $this->t('Nemate zabeležene ocene.'),
            ],
        ];
    }
}

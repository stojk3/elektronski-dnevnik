<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class StudentNoteController extends ControllerBase {

    public function viewNotes(Request $request = null) {
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
                    '3' => 'Kombinovano',
                ],
                '#value' => $selected_semester,
                '#attributes' => ['onchange' => 'this.form.submit();'],
                '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
                '#name' => 'semester',
            ],
        ];

        $query = $connection->select('student_notes', 'sn');
        $query->fields('sn', ['napomena', 'datum_upisa', 'predmet_id']);
        $query->condition('sn.student_id', $student_id);

        if ($selected_semester === '1') {
            $dates = ['2024-09-01', '2024-12-24'];
            $query->condition('sn.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        } elseif ($selected_semester === '2') {
            $dates = ['2025-01-15', '2025-06-24'];
            $query->condition('sn.datum_upisa', [$dates[0], $dates[1]], 'BETWEEN');
        }

        $query->orderBy('sn.datum_upisa', 'DESC');
        $notes_query = $query->execute()->fetchAll();

        $rows = [];
        foreach ($notes_query as $note) {
            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :id", [
                ':id' => $note->predmet_id
            ])->fetchField();

            $rows[] = [
                'predmet' => $subject_name,
                'napomena' => $note->napomena,
                'datum' => date('d-m-Y', strtotime($note->datum_upisa)),
            ];
        }

        $header = [
            'predmet' => $this->t('Predmet'),
            'napomena' => $this->t('Napomena'),
            'datum' => $this->t('Datum'),
        ];

        return [
            $form,
            [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => $this->t('Nema zabeleženih napomena.'),
            ],
        ];
    }
}

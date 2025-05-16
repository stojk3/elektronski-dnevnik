<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class HomeRoomNoteController extends ControllerBase {

    public function viewNotes(Request $request = null) {
        $request = $request ?? \Drupal::request();
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = Database::getConnection();

        $teacher_id = $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        if (!$teacher_id) {
            return ['#markup' => $this->t('Niste prijavljeni kao nastavnik.')];
        }

        $department_id = $connection->query("SELECT department_id FROM {teachers_departments} WHERE teacher_id = :teacher_id", [
            ':teacher_id' => $teacher_id
        ])->fetchField();

        if (!$department_id) {
            return ['#markup' => $this->t('Niste zaduženi ni za jedno odeljenje.')];
        }

        $student_ids = $connection->query("SELECT student_id FROM {students_departments} WHERE department_id = :department_id", [
            ':department_id' => $department_id
        ])->fetchAll();

        $student_ids_array = [];
        foreach ($student_ids as $student_id) {
            $student_ids_array[] = $student_id->student_id;
        }

        if (empty($student_ids_array)) {
            return ['#markup' => $this->t('Nema učenika u ovom odeljenju.')];
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
                '#name' => 'semester',
            ],
        ];

        $query = $connection->select('student_notes', 'sn');
        $query->fields('sn', ['napomena', 'datum_upisa', 'predmet_id', 'student_id']);
        $query->condition('sn.student_id', $student_ids_array, 'IN');

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
            $student_name = $connection->query("SELECT ime, prezime FROM {students} WHERE id = :id", [
                ':id' => $note->student_id
            ])->fetchField() . ' ' . $connection->query("SELECT prezime FROM {students} WHERE id = :id", [
                ':id' => $note->student_id
            ])->fetchField();

            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :id", [
                ':id' => $note->predmet_id
            ])->fetchField();

            $note_text = substr($note->napomena, 0, 50);
            if (strlen($note->napomena) > 50) {
                $note_text .= '...';
            }

            $rows[] = [
                'ucenik' => $student_name,
                'predmet' => $subject_name,
                'napomena' => [
                    'data' => [
                        '#markup' => '<div class="comment-column" data-full="' . $note->napomena . '">' . $note_text . '</div>',
                    ],
                ],
                'datum' => date('d-m-Y', strtotime($note->datum_upisa)),
            ];
        }

        $header = [
            'ucenik' => $this->t('Učenik'),
            'predmet' => $this->t('Predmet'),
            'napomena' => $this->t('Napomena'),
            'datum' => $this->t('Datum'),
        ];

        $build = [
            $form,
            [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => $this->t('Nema zabeleženih napomena.'),
                '#attached' => [
                    'library' => [
                        'elektronski_dnevnik/homeroom-note',
                    ],
                ],
            ],
        ];

        return $build;
    }
}

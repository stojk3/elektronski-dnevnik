<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

class StudentGradesController extends ControllerBase {

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
                    '3' => 'Kombinovano',
                ],
                '#value' => $selected_semester,
                '#attributes' => ['onchange' => 'this.form.submit();'],
                '#name' => 'semester',
            ],
        ];

        $subject_ids = $connection->query("SELECT id, ime FROM {subjects}")
            ->fetchAllAssoc('id');

        if (empty($subject_ids)) {
            return [
                $form,
                ['#markup' => $this->t('Nema unetih predmeta.')],
            ];
        }

        $grades_query = $connection->query("
            SELECT ocena, predmet_id, datum_upisa
            FROM {student_grades}
            WHERE student_id = :student_id",
            [':student_id' => $student_id]
        )->fetchAll();

        $grades_by_subject = [];
        foreach ($grades_query as $grade) {
            $subject_id = $grade->predmet_id;
            $semester = $this->getSemesterForGrade($grade->datum_upisa);

            if (!isset($grades_by_subject[$subject_id])) {
                $grades_by_subject[$subject_id] = ['1' => [], '2' => []];
            }

            if ($semester === '1' || $semester === '2') {
                $grades_by_subject[$subject_id][$semester][] = [
                    'ocena' => $grade->ocena,
                    'datum' => $grade->datum_upisa,
                ];
            }
        }

        $rows = [];
        foreach ($subject_ids as $subject_id => $subject) {
            $subject_name = ucfirst($subject->ime);
            $ocena_info = $grades_by_subject[$subject_id] ?? ['1' => [], '2' => []];
            $ocene = [];
            $sve_ocene = [];

            if ($selected_semester === '3') {
                $sve_spojene = array_merge(
                    $ocena_info['1'] ?? [],
                    $ocena_info['2'] ?? []
                );

                usort($sve_spojene, fn($a, $b) => strcmp($a['datum'], $b['datum']));

                foreach ($sve_spojene as $entry) {
                    $ocene[] = $entry['ocena'];
                    $sve_ocene[] = $entry['ocena'];
                }

            } else {
                foreach ($ocena_info[$selected_semester] ?? [] as $entry) {
                    $ocene[] = $entry['ocena'];
                    $sve_ocene[] = $entry['ocena'];
                }
            }

            $prosek = '';
            if (!empty($sve_ocene)) {
                $prosek = number_format(array_sum($sve_ocene) / count($sve_ocene), 2, ',', '.');
            }

            $rows[] = [
                'subject' => $subject_name,
                'grades' => !empty($ocene) ? implode(', ', $ocene) : $this->t(''),
                'average' => $prosek,
            ];
        }

        $header = [
            'subject' => $this->t('Predmet'),
            'grades' => $this->t('Ocene'),
            'average' => $this->t('Prosečna ocena'),
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

    private function getSemesterForGrade($datum) {
        if ($datum >= '2024-09-01' && $datum <= '2024-12-24') {
            return '1';
        } elseif ($datum >= '2025-01-15' && $datum <= '2025-06-24') {
            return '2';
        }
        return '0';
    }
}
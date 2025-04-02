<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentGradeForm extends FormBase {

    public function getFormId() {
        return 'student_grade_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $current_user = \Drupal::currentUser();
        $connection = \Drupal::database();
        $user_username = $current_user->getAccountName();

        $form['datum_upisa'] = [
            '#type' => 'date',
            '#title' => 'Datum upisa',
            '#default_value' => date('Y-m-d'),
            '#max' => date('Y-m-d'),
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 850px; height: 40px; line-height: 38px; padding: 0 10px;'],
        ];

        $query = $connection->select('teachers', 't')
            ->fields('t', ['subject_id'])
            ->condition('t.username', $user_username, '=')
            ->execute()
            ->fetchCol();

        if (!empty($query)) {
            $subjects_id = $query;
            $subjects_query = $connection->select('subjects', 's')
                ->fields('s', ['id', 'ime'])
                ->condition('s.id', $subjects_id, 'IN')
                ->execute();

            $subjects = [];
            foreach ($subjects_query as $row) {
                $subjects[$row->id] = $row->ime;
            }

            $form['predmet'] = [
                '#type' => 'select',
                '#title' => 'Predmet',
                '#options' => $subjects,
                '#required' => TRUE,
                '#attributes' => ['style' => 'width: 850px; height: 40px; line-height: 38px; padding: 0 10px;'],
                '#ajax' => [
                    'callback' => '::updateCombinedContainer',
                    'wrapper' => 'combined-container',
                ],
            ];
        } else {
            $form['message'] = ['#markup' => 'Nema predmeta blablabla'];
        }

        $form['tip_ocene'] = [
            '#type' => 'select',
            '#title' => 'Tip ocene',
            '#options' => [
                'kontrolni' => 'Kontrolni',
                'odgovaranje' => 'Odgovaranje',
                'prezentacija' => 'Prezentacija',
                'aktivnost' => 'Aktivnost',
            ],
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 850px; height: 40px; line-height: 38px; padding: 0 10px;'],
        ];

        $departments_query = $connection->query("SELECT ime FROM {departments}")->fetchCol();
        $form['odeljenje'] = [
            '#type' => 'select',
            '#title' => 'Odeljenje',
            '#options' => array_combine($departments_query, $departments_query),
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 850px; height: 40px; line-height: 38px; padding: 0 10px;'],
            '#ajax' => [
                'callback' => '::updateCombinedContainer',
                'wrapper' => 'combined-container',
            ],
        ];

        $form['combined-container'] = ['#type' => 'container', '#attributes' => ['id' => 'combined-container']];
        $odeljenjePrivremeni = $form_state->getValue('odeljenje');

        if (!empty($odeljenjePrivremeni)) {
            $students = $this->loadStudentsByClass($odeljenjePrivremeni);

            if (!empty($students)) {
                $form['combined-container']['ucenici'] = ['#type' => 'table', '#header' => ['Učenik', 'Ocena']];

                foreach ($students as $student) {
                    $form['combined-container']['ucenici'][$student->student_id]['name'] = ['#markup' => $student->ime . ' ' . $student->prezime];
                    $form['combined-container']['ucenici'][$student->student_id]['grade'] = [
                        '#type' => 'select',
                        '#options' => [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'],
                        '#empty_option' => '- Izaberi ocenu -',
                    ];
                }
            } else {
                $form['combined-container']['message'] = ['#markup' => 'Nema učenika u odabranom odeljenju.'];
            }
        }

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
            '#value' => 'Snimi',
        ];

        $form['#attached']['html_head'][] = [
            [
              '#tag' => 'style',
              '#value' => '
                .input-group-addon { 
                  display: none !important; 
                }
              ',
            ],
            'hide_ajax_button',
        ];          

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $students_grades = $form_state->getValue('ucenici');
        $has_grade = FALSE;

        if (is_array($students_grades)) {
            foreach ($students_grades as $data) {
                if (!empty($data['grade'])) {
                    $has_grade = TRUE;
                    break;
                }
            }
        }

        if (!$has_grade) {
            $form_state->setErrorByName('ucenici', 'Morate dodeliti barem jednu ocenu.');
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $connection = \Drupal::database();
        $date = $form_state->getValue('datum_upisa');
        $students_grades = $form_state->getValue('ucenici');
        $predmet = $form_state->getValue('predmet');

        if (is_array($students_grades)) {
            foreach ($students_grades as $student_id => $data) {
                $grade = $data['grade'];
                if (!empty($grade)) {
                    $connection->insert('student_grades')
                        ->fields([
                            'ocena' => $grade,
                            'tip_ocene' => $form_state->getValue('tip_ocene'),
                            'datum_upisa' => $date,
                            'student_id' => $student_id,
                            'predmet_id' => $predmet,
                        ])
                        ->execute();
                }
            }
            \Drupal::messenger()->addMessage('Ocene su uspešno sačuvane.');
        }
    }

    protected function loadStudentsByClass($class) {
        $connection = \Drupal::database();
        $depId = $connection->query("SELECT id FROM {departments} WHERE ime LIKE :ime", [':ime' => $class])->fetchField();

        return $connection->query(
            "SELECT s.id AS student_id, s.ime, s.prezime 
            FROM {students} s
            INNER JOIN {students_departments} sd ON s.id = sd.student_id
            WHERE sd.department_id = :department_id",
            [':department_id' => $depId]
        )->fetchAll();
    }

    public function updateCombinedContainer(array &$form, FormStateInterface $form_state) {
        return $form['combined-container'];
    }
}

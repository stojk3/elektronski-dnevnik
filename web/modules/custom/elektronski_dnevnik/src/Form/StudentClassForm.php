<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentClassForm extends FormBase {

  public function getFormId() {
    return 'student_class_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['datum_upisa'] = [
        '#type' => 'date',
        '#title' => t('Datum upisa'),
        '#default_value' => date('Y-m-d'),
        '#required' => TRUE,
        '#ajax' => [
            'callback' => '::updateWeekAndClasses',
            'wrapper' => 'class-info-container',
        ],
    ];

    $selected_date = $form_state->getValue('datum_upisa') ?? date('Y-m-d');
    $week_number = $this->getWeekNumberFromDate($selected_date);

    $form['redni_broj_nedelje'] = [
        '#type' => 'number',
        '#title' => t('Redni broj nedelje'),
        '#default_value' => $week_number,
        '#required' => TRUE,
        '#disabled' => TRUE,
    ];

    $avaliable_classes = $this->getAvaliableClassNumbers($selected_date);

    $form['redni_broj_casa'] = [
        '#type' => 'select',
        '#title' => t('Redni broj časa'),
        '#options' => $avaliable_classes,
        '#required' => TRUE,
    ];

    $current_user = \Drupal::currentUser();
    $connection = \Drupal::database();
    $user_username = $current_user->getAccountName();

    $query = $connection->select('teachers', 't')
        ->fields('t', ['subject_id'])
        ->condition('t.username', $user_username, '=')
        ->execute()
        ->fetchCol();
      
    if (!empty($query)) {
        $subjects_id = $query;

        $subjects_query = $connection->select('subject', 's')
                ->fields('s', ['id', 'predmet'])
                ->condition('s.id', $subjects_id, 'IN')
                ->execute();

        $subjects = [];
        foreach ($subjects_query as $row) {
            $subjects[$row->id] = t($row->predmet);
        }

        $form['predmet'] = [
            '#type' => 'select',
            '#title' => t('Predmet'),
            '#options' => $subjects,
            '#required' => TRUE,
            '#ajax' => [
                'callback' => '::updateCombinedContainer',
                'wrapper' => 'combined-container',
            ],
        ];
    } else {
        $form['message'] = [
            '#markup' => t('Nema predmeta blablabla'),
        ];
    }

    $form['odeljenje'] = [
        '#type' => 'select',
        '#title' => t('Odeljenje'),
        '#options' => [
            'I1' => t('I1'),
            'I2' => t('I2'),
            'I3' => t('I3'),
            'II1' => t('II1'),
            'II2' => t('II2'),
            'II3' => t('II3'),
            'III1' => t('III1'),
            'III2' => t('III2'),
            'III3' => t('III3'),
            'IV1' => t('IV1'),
            'IV2' => t('IV2'),
            'IV3' => t('IV3'),
        ],
        '#required' => TRUE,
        '#ajax' => [
            'callback' => '::updateCombinedContainer',
            'wrapper' => 'combined-container',
        ],
    ];

    $form['combined-container'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'combined-container'],
    ];

    $total_classes = $this->getTotalClassesForSubjectAndClass(
        $form_state->getValue('predmet'),
        $form_state->getValue('odeljenje'),
    );

    $form['combined-container']['ukupno_casova'] = [
        '#type' => 'number',
        '#title' => t('Ukupno CHASOVA(zameni ovde sa ch)'),
        '#default_value' => $total_classes,
        '#required' => TRUE,
        '#disabled' => TRUE,
    ];

    $selected_class = $form_state->getValue('odeljenje');
    $students = $this->loadStudentByClass($selected_class);

    if (!empty($students)) {
        $form['combined-container']['ucenici'] = [
            '#type' => 'checkboxes',
            '#title' => 'Ucenici',
            '#options' => array_reduce($students, function ($carry, $student) {
                $carry[$student->id] = $student->first_name . ' ' . $student->last_name;
                return $carry;
            }, []),
        ];
    } else {
        $form['combined-container']['ucenici'] = [
            '#markup' => t('Nema ucenika u @odeljenje', ['@odeljenje' => $selected_class]),
        ];
    }

    $form['tema'] = [
        '#type' => 'textarea',
        '#title' => t('Tema'),
        '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => t('Snimi'),
    ];

    return $form;
  }

  protected function getWeekNumberFromDate($date) {
    $first_week_date = '2024-09-01';
    $date_diff = (strtotime($date) - strtotime($first_week_date)) / (60 *60 *24 * 7);
    return ceil($date_diff) + 1;
  }

  
}

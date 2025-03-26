<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class StudentNoteForm extends FormBase {

  public function getFormId() {
    return 'student_note_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['datum_upisa'] = [
        '#type' => 'hidden',
        '#value' => date('Y-m-d'),
    ];

    $form['redni_broj_casa'] = [
        '#type' => 'select',
        '#title' => 'Redni broj časa',
        '#options' => [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
      ],
        '#required' => TRUE,
        '#ajax' => [
            'callback' => '::updateClassDetails',
            'wrapper' => 'class-details-wrapper',  // ID za wrapper koji sadrži odeljenje i učenike
            'effect' => 'fade',  // Efekat pri osvežavanju
        ],
    ];

    // Polje za odeljenje, biće prikazano ako je redni broj časa odabran
    $form['class_details_wrapper'] = [
        '#type' => 'container',
        '#attributes' => ['id' => 'class-details-wrapper'],
    ];

    // Ovo je polje za odeljenje koje je popunjeno na osnovu rednog broja časa
    $form['class_details_wrapper']['odeljenje'] = [
        '#type' => 'select',
        '#title' => 'Odeljenje',
        '#options' => [],
        '#disabled' => TRUE,  // Onemogućeno jer je samo za prikaz
    ];

    $selected_class = $form_state->getValue('redni_broj_casa');
    $selected_date = date('Y-m-d');
    
    // Ako je odabran redni broj časa, uzimamo detalje predmeta i odeljenja
    if ($selected_class) {
        $class_details = $this->getClassDetails($selected_date, $selected_class);
        
        if ($class_details) {
            // Automatsko popunjavanje odeljenja
            $form['odeljenje'] = [
                '#type' => 'select',
                '#title' => 'Odeljenje',
                '#options' => [
                    $class_details['department_id'] => $class_details['department_ime']
                ],
                '#disabled' => TRUE,  // Onemogućavamo menjanje
                '#default_value' => $class_details['department_id'],
            ];

            // Dohvatanje učenika iz baze za ovo odeljenje
            $students = $this->loadStudentsByClass($class_details['department_id']);

            // Ako postoje učenici u odeljenju, dodajemo ih u formu
            if (!empty($students)) {
                $form['students_container']['ucenici'] = [
                    '#type' => 'select',
                    '#title' => t('Učenici'),
                    '#options' => array_reduce($students, function ($carry, $student) {
                        $carry[$student->id] = $student->first_name . ' ' . $student->last_name;
                        return $carry;
                    }, []),
                    '#required' => TRUE,
                ];
            } else {
                $form['students_container']['ucenici'] = [
                    '#markup' => t('Nema učenika u odeljenju @odeljenje.', ['@odeljenje' => $class_details['department_ime']]),
                ];
            }
        }
    }

    $form['napomena'] = [
      '#type' => 'textarea',
      '#title' => 'Napomena',
      '#required' => TRUE,
      '#rows' => 4,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Snimi',
    ];

    return $form;
  }

  protected function getClassDetails($date, $class_number) {
    $connection = \Drupal::database();
    $result = $connection->query(
      "SELECT sc.predmet_id, sc.department_id, s.ime AS predmet_ime, d.ime AS department_ime
       FROM {student_class} sc
       LEFT JOIN {subjects} s ON sc.predmet_id = s.id
       LEFT JOIN {departments} d ON sc.department_id = d.id
       WHERE sc.datum_upisa = :date AND sc.redni_broj_casa = :class_number",
      [
        ':date' => $date,
        ':class_number' => $class_number,
      ]
    )->fetchAssoc();

    return $result;
  }

  protected function getTeacherIdByUsername($user_username) {
    $connection = \Drupal::database();
    return $connection->query("SELECT id FROM {teachers} WHERE username = :username", [
      ':username' => $user_username
    ])->fetchField();
  }

  protected function loadStudentsByClass($department_id) {
    $connection = \Drupal::database();
    $students = $connection->query(
        "SELECT id, first_name, last_name FROM {students} WHERE department_id = :department_id",
        [':department_id' => $department_id]
    )->fetchAll();

    return $students;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $current_user = \Drupal::currentUser();
    $user_username = $current_user->getAccountName();

    $datum_upisa = $form_state->getValue('datum_upisa');
    $predmet_id = $form_state->getValue('predmet');
    $odeljenje_id = $form_state->getValue('odeljenje');
    $redni_broj_casa = $form_state->getValue('redni_broj_casa');
    $napomena = $form_state->getValue('napomena');

    // Preuzimanje ID studenta (pretpostavljamo da je student povezan sa trenutnim korisnikom)
    $student_id = $current_user->id();

    // Unos nove napomene u tabelu
    $connection->insert('student_notes')
      ->fields([
        'datum_upisa' => $datum_upisa,
        'redni_broj_casa' => $redni_broj_casa,
        'napomena' => $napomena,
        'department_id' => $odeljenje_id,
        'predmet_id' => $predmet_id,
        'student_id' => $student_id,
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Napomena je uspešno sačuvana.');
  }
}

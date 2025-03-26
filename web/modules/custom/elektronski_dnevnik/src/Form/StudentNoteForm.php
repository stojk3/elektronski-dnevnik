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
    ];

    $selected_date = date('Y-m-d');
    $selected_class = $form_state->getValue('redni_broj_casa');
    if ($selected_class) {
        $class_details = $this->getClassDetails($selected_date, $selected_class);

        if ($class_details) {
            $form['predmet'] = [
                '#type' => 'hidden',
                '#value' => [$class_details['predmet_id'] => $class_details['predmet_ime']],
            ];

            $form['odeljenje'] = [
                '#type' => 'hidden',
                '#value' => [$class_details['department_id'] => $class_details['department_ime']],
            ];
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

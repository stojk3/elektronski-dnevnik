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
  }
}

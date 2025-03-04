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
  }
}
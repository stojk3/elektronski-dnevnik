<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class AssignStudentForm extends FormBase {

  public function getFormId() {
    return 'assign_student_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $connection = Database::getConnection();

    $students = $connection->query("SELECT id, CONCAT(ime, ' ', prezime) AS name FROM students")
      ->fetchAllKeyed();

    $departments = $connection->query("SELECT id, ime FROM departments")
      ->fetchAllKeyed();

    $form['generacija'] = [
      '#type' => 'textfield',
      '#title' => 'Generacija',
      '#required' => TRUE,
    ];

    $form['student_id'] = [
      '#type' => 'select',
      '#title' => 'Učenik',
      '#options' => $students,
      '#required' => TRUE,
    ];

    $form['department_id'] = [
      '#type' => 'select',
      '#title' => 'Odeljenje',
      '#options' => $departments,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Sačuvaj',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    
    $connection->insert('students_departments')
      ->fields([
        'generacija' => $form_state->getValue('generacija'),
        'student_id' => $form_state->getValue('student_id'),
        'department_id' => $form_state->getValue('department_id'),
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Učenik uspešno dodeljen odeljenju!');
  }

}

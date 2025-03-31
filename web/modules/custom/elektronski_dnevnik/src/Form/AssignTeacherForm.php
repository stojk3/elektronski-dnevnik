<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class AssignTeacherForm extends FormBase {

  public function getFormId() {
    return 'assign_teacher_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $connection = Database::getConnection();

    $teachers = $connection->query(
      "SELECT t.id, CONCAT(t.ime, ' ', t.prezime) AS name 
      FROM teachers t 
      LEFT JOIN teachers_departments td ON t.id = td.teacher_id 
      WHERE td.teacher_id IS NULL"
    )->fetchAllKeyed();

    $departments = $connection->query("SELECT id, ime FROM departments")
      ->fetchAllKeyed();

    $form['generacija'] = [
      '#type' => 'textfield',
      '#title' => 'Generacija',
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['teacher_id'] = [
      '#type' => 'select',
      '#title' => 'Profesor',
      '#options' => $teachers,
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['department_id'] = [
      '#type' => 'select',
      '#title' => 'Odeljenje',
      '#options' => $departments,
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Dodeli',
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    
    $connection->insert('teachers_departments')
      ->fields([
        'generacija' => $form_state->getValue('generacija'),
        'teacher_id' => $form_state->getValue('teacher_id'),
        'department_id' => $form_state->getValue('department_id'),
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Profesor uspešno dodeljen odeljenju!');
  }

}

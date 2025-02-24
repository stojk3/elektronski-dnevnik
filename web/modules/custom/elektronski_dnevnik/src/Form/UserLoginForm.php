<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserLoginForm extends FormBase {

  public function getFormId() {
    return 'elektronski_dnevnik_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Login'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('username');
    $password = $form_state->getValue('password');

    $connection = Database::getConnection();
    $tables = ['teachers', 'students'];

    foreach ($tables as $table) {
      $query = $connection->select($table, 'u')
        ->fields('u', ['id'])
        ->condition('username', $username)
        ->condition('password', $password)
        ->execute()
        ->fetchField();

      if ($query) {
        \Drupal::messenger()->addMessage($this->t('Login successful!'));
        $response = new RedirectResponse('/pocetna'); 
        $response->send();
        return;
      }
    }

    \Drupal::messenger()->addError($this->t('Invalid username or password.'));
  }
}

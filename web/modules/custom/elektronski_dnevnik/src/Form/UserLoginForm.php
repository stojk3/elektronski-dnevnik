<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserLoginForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'elektronski_dnevnik_login_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#attributes' => ['style' => 'height: 40px; line-height: 38px; padding: 0 10px;'],
      '#value' => $this->t('Login'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('username');
    $password = $form_state->getValue('password');

    $user = user_load_by_name($username);
    if ($user) {
      $auth = \Drupal::service('user.auth');
      if ($auth->authenticate($username, $password)) {
        user_login_finalize($user);
        $this->messenger()->addStatus($this->t('Login successful.'));
        $form_state->setRedirect('<front>');
        return;
      } else {
        $this->messenger()->addError($this->t('Invalid password.'));
        return;
      }
    }

    $connection = Database::getConnection();
    $tables = ['students', 'teachers'];

    foreach ($tables as $table) {
      $query = $connection->select($table, 'u')
        ->fields('u', ['id', 'sifra'])
        ->condition('username', $username)
        ->execute()
        ->fetchAssoc();

        if ($query && $password === $query['sifra']) {
        \Drupal::messenger()->addMessage($this->t('Login successful!'));

        $response = new RedirectResponse('/pocetna');
        $response->send();
        return;
      }
    }

    $this->messenger()->addError($this->t('Invalid username or password.'));
  }
}

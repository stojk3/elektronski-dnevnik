<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;

class UserDeleteConfirmForm extends ConfirmFormBase {

  /**
   * ID korisnika koji se briše.
   *
   * @var int
   */
  protected $id;

  /**
   * Tip korisnika koji se briše.
   *
   * @var string
   */
  protected $type;

  /**
   * Korisničko ime korisnika koji se briše.
   *
   * @var string
   */
  protected $username;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'elektronski_dnevnik_user_delete_confirm_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Da li ste sigurni da želite da obrišete ovog korisnika?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return $this->getRedirectUrl();
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Obriši');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $type = NULL, $id = NULL) {
    $this->id = $id;
    $this->type = $type;

    $connection = Database::getConnection();
    $username = NULL;

    if ($type === 'student') {
      $user = $connection->select('students', 's')
        ->fields('s', ['username'])
        ->condition('id', $id)
        ->execute()
        ->fetchAssoc();
      $username = $user['username'] ?? NULL;
    }
    elseif ($type === 'teacher') {
      $user = $connection->select('teachers', 't')
        ->fields('t', ['username'])
        ->condition('id', $id)
        ->execute()
        ->fetchAssoc();
      $username = $user['username'] ?? NULL;
    }
    elseif ($type === 'admin') {
      $user = $connection->select('users_field_data', 'u')
        ->fields('u', ['name'])
        ->condition('uid', $id)
        ->execute()
        ->fetchAssoc();
      $username = $user['name'] ?? NULL;
    }

    $this->username = $username;
    $form_state->set('delete_username', $username);

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = Database::getConnection();
    $username = $form_state->get('delete_username');
    $deleted = FALSE;

    if ($this->type === 'student' || $this->type === 'teacher') {
      if ($username) {
        $user_id = NULL;
        if ($this->type === 'student') {
          $user_id = $connection->select('students', 's')
            ->fields('s', ['id'])
            ->condition('username', $username)
            ->execute()
            ->fetchField();
        } elseif ($this->type === 'teacher') {
          $user_id = $connection->select('teachers', 't')
            ->fields('t', ['id'])
            ->condition('username', $username)
            ->execute()
            ->fetchField();
        }

        if ($this->type === 'student' && $user_id) {
          $connection->delete('student_attendance')
            ->condition('student_id', $user_id)
            ->execute();
        }

        $connection->delete('users_field_data')
          ->condition('name', $username)
          ->execute();

        $table = $this->type === 'student' ? 'students' : 'teachers';
        $connection->delete($table)
          ->condition('username', $username)
          ->execute();

        $deleted = TRUE;
      }
    }
    elseif ($this->type === 'admin') {
      $connection->delete('users_field_data')
        ->condition('uid', $this->id)
        ->execute();
      $deleted = TRUE;
    }

    if ($deleted) {
      $this->messenger()->addStatus($this->t('Korisnik je uspešno obrisan.'));
    } else {
      $this->messenger()->addError($this->t('Korisnik nije pronađen.'));
    }

    $form_state->setRedirectUrl($this->getRedirectUrl());
  }

  /**
   * Helper to get redirect url after brisanja.
   */
  protected function getRedirectUrl() {
    return \Drupal\Core\Url::fromRoute('elektronski_dnevnik.admin_users_controller');
  }
}

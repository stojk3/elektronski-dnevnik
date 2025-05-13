<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

class CustomUserController extends ControllerBase {

public function listUsers() {
  $connection = Database::getConnection();

  //tabela studenti
  $student_header = [
    'id' => 'ID',
    'name' => 'Ime i prezime',
    'email' => 'Email',
    'actions' => 'Akcije',
  ];

  $student_rows = [];
  $students = $connection->select('students', 's')
    ->fields('s', ['id', 'ime', 'prezime', 'email'])
    ->execute()
    ->fetchAll();

  foreach ($students as $student) {
    $student_rows[] = [
      'id' => $student->id,
      'name' => $student->ime . ' ' . $student->prezime,
      'email' => $student->email,
      'actions' => $this->buildActionLinks('student', $student->id),
    ];
  }

  //tabela profesori
  $teacher_header = [
    'id' => 'ID',
    'name' => 'Ime i prezime',
    'email' => 'Email',
    'actions' => 'Akcije',
  ];

  $teacher_rows = [];
  $teachers = $connection->select('teachers', 't')
    ->fields('t', ['id', 'ime', 'prezime', 'email'])
    ->execute()
    ->fetchAll();

  foreach ($teachers as $teacher) {
    $teacher_rows[] = [
      'id' => $teacher->id,
      'name' => $teacher->ime . ' ' . $teacher->prezime,
      'email' => $teacher->email,
      'actions' => $this->buildActionLinks('teacher', $teacher->id),
    ];
  }

  //tabela admina
  $admin_header = [
    'id' => 'ID',
    'name' => 'Korisničko ime',
    'email' => 'Email',
    'actions' => 'Akcije',
  ];

  $admin_rows = [];

  $admin_query = $connection->select('users_field_data', 'u')
    ->fields('u', ['uid', 'name', 'mail']);
  $admin_query->join('user__roles', 'r', 'u.uid = r.entity_id');
  $admin_query->condition('r.roles_target_id', 'administrator');
  $admin_query->condition('u.status', 1); // samo aktivni

  $admins = $admin_query->execute()->fetchAll();

  foreach ($admins as $admin) {
    $admin_rows[] = [
      'id' => $admin->uid,
      'name' => $admin->name,
      'email' => $admin->mail,
      'actions' => $this->buildActionLinks('admin', $admin->uid),
    ];
  }

  return [
    [
      '#markup' => '<h2>Učenici</h2>',
    ],
    [
      '#type' => 'table',
      '#header' => $student_header,
      '#rows' => $student_rows,
      '#empty' => 'Nema učenika u bazi.',
    ],
    [
      '#markup' => '<h2>Profesori</h2>',
    ],
    [
      '#type' => 'table',
      '#header' => $teacher_header,
      '#rows' => $teacher_rows,
      '#empty' => 'Nema profesora u bazi.',
    ],
    [
    '#markup' => '<h2>Administratori</h2>',
    ],
    [
    '#type' => 'table',
    '#header' => $admin_header,
    '#rows' => $admin_rows,
    '#empty' => 'Nema administratora u sistemu.',
    ],
  ];
}

  public function infoUser($type, $id) {
  $connection = \Drupal::database();
  $table = $type === 'student' ? 'students' : 'teachers';

  $user = $connection->select($table, 'u')
    ->fields('u')
    ->condition('id', $id)
    ->execute()
    ->fetchAssoc();

  if (!$user) {
    return ['#markup' => 'Korisnik nije pronađen.'];
  }

  $output = '<ul>';
  foreach ($user as $key => $value) {
    $output .= '<li><strong>' . ucfirst($key) . ':</strong> ' . $value . '</li>';
  }
  $output .= '</ul>';

  return [
    '#type' => 'markup',
    '#markup' => $output,
  ];
}


public function editUser($type, $id) {
  $connection = \Drupal::database();
  $table = $type === 'student' ? 'students' : 'teachers';

  $user = $connection->select($table, 'u')
    ->fields('u')
    ->condition('id', $id)
    ->execute()
    ->fetchAssoc();

  if (!$user) {
    return ['#markup' => 'Korisnik nije pronađen.'];
  }

  $form_action = '/custom-edit-submit/' . $type . '/' . $id;

  $form = '<form method="post" action="' . $form_action . '">';
  $form .= 'Email: <input type="text" name="email" value="' . htmlspecialchars($user['email']) . '"><br>';
  $form .= 'Ime: <input type="text" name="ime" value="' . htmlspecialchars($user['ime']) . '"><br>';
  $form .= 'Prezime: <input type="text" name="prezime" value="' . htmlspecialchars($user['prezime']) . '"><br>';
  $form .= '<button type="submit">Sačuvaj</button>';
  $form .= '</form>';

  return [
    '#type' => 'markup',
    '#markup' => $form,
  ];
}

  public function deleteUser($type, $id) {
    $connection = \Drupal::database();
    $table = $type === 'student' ? 'students' : 'teachers';

    $user = $connection->select($table, 'u')
      ->fields('u', ['ime', 'prezime'])
      ->condition('id', $id)
      ->execute()
      ->fetchAssoc();

    if (!$user) {
      return ['#markup' => 'Korisnik nije pronađen.'];
    }

    $confirm_url = Url::fromRoute('elektronski_dnevnik.user_delete_confirmed', [
      'type' => $type,
      'id' => $id,
    ])->toString();

    $cancel_url = Url::fromRoute('elektronski_dnevnik.user_info')->toString();

    $markup = "<p>Da li ste sigurni da želite da obrišete korisnika <strong>{$user['ime']} {$user['prezime']}</strong>?</p>";
    $markup .= "<a href=\"$confirm_url\" style=\"margin-right: 10px; color: red; font-weight: bold;\">Da, obriši</a>";
    $markup .= "<a href=\"$cancel_url\">Ne, nazad</a>";

    return [
      '#type' => 'markup',
      '#markup' => $markup,
    ];
  }

  public function deleteUserConfirmed($type, $id) {
  $connection = \Drupal::database();
  $table = $type === 'student' ? 'students' : 'teachers';

  try {
    $connection->delete($table)
      ->condition('id', $id)
      ->execute();
    \Drupal::messenger()->addMessage('Korisnik je uspešno obrisan.');
  } catch (\Exception $e) {
    \Drupal::messenger()->addError('Korisnik ne može biti obrisan zbog povezanih podataka.');
  }

  return $this->redirect('elektronski_dnevnik.user_info');
}

  private function buildActionLinks($type, $id) {
  $info_url = Url::fromRoute('elektronski_dnevnik.user_info', ['type' => $type, 'id' => $id]);
  $edit_url = Url::fromRoute('elektronski_dnevnik.user_edit', ['type' => $type, 'id' => $id]);
  $delete_url = Url::fromRoute('elektronski_dnevnik.user_delete', ['type' => $type, 'id' => $id]);

  $button_style = 'padding:6px 12px;margin-right:5px;border-radius:4px;color:#fff;text-decoration:none;font-weight:bold;display:inline-block;';

  return [
    'data' => [
      '#type' => 'container',
      'view' => [
        '#type' => 'link',
        '#title' => $this->t('Informacije'),
        '#url' => $info_url,
        '#attributes' => [
          'style' => $button_style . 'background-color:#3498db;',
        ],
      ],
      'edit' => [
        '#type' => 'link',
        '#title' => $this->t('Izmeni'),
        '#url' => $edit_url,
        '#attributes' => [
          'style' => $button_style . 'background-color:#f39c12;',
        ],
      ],
      'delete' => [
        '#type' => 'link',
        '#title' => $this->t('Obriši'),
        '#url' => $delete_url,
        '#attributes' => [
          'style' => $button_style . 'background-color:#e74c3c;',
        ],
      ],
    ],
  ];
}
}

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
  ];
}

  public function infoUser($type, $id) {
    return [
      '#markup' => "INFO: $type korisnik ID $id",
    ];
  }

  public function editUser($type, $id) {
    return [
      '#markup' => "EDIT: $type korisnik ID $id",
    ];
  }

  public function deleteUser($type, $id) {
    return [
      '#markup' => "DELETE: $type korisnik ID $id",
    ];
  }

  private function buildActionLinks($type, $id) {
    $edit_url = Url::fromRoute('elektronski_dnevnik.user_edit', ['type' => $type, 'id' => $id]);
    $delete_url = Url::fromRoute('elektronski_dnevnik.user_delete', ['type' => $type, 'id' => $id]);
    $info_url = Url::fromRoute('elektronski_dnevnik.user_info', ['type' => $type, 'id' => $id]);

    return [
      'data' => [
        '#type' => 'operations',
        '#links' => [
          'info' => ['title' => 'Info', 'url' => $info_url],
          'edit' => ['title' => 'Izmeni', 'url' => $edit_url],
          'delete' => ['title' => 'Obriši', 'url' => $delete_url],
        ],
      ],
    ];
  }
}

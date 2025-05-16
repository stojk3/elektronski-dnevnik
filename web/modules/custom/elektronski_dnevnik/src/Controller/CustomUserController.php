<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

class CustomUserController extends ControllerBase {

public function listUsers() {
  $connection = Database::getConnection();

  $student_header = [
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
      'name' => $student->ime . ' ' . $student->prezime,
      'email' => $student->email,
      'actions' => $this->buildActionLinks('student', $student->id),
    ];
  }

  $teacher_header = [
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

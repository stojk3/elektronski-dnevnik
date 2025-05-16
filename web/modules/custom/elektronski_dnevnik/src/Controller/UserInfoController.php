<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

class UserInfoController extends ControllerBase {
  public function infoUser($type, $id) {
    $connection = \Drupal::database();
    $table = null;

    switch ($type) {
      case 'student':
        $table = 'students';
        $id_field = 'id';
        break;
      case 'teacher':
        $table = 'teachers';
        $id_field = 'id';
        break;
      default:
        return ['#markup' => 'Nepoznat tip korisnika.'];
    }

    $user = $connection->select($table, 'u')
      ->fields('u')
      ->condition($id_field, $id)
      ->execute()
      ->fetchAssoc();

    if (!$user) {
      return ['#markup' => 'Korisnik nije pronađen.'];
    }

    $output = '<ul>';
    foreach ($user as $key => $value) {
      if ($key === 'id' || $key === 'uid') continue;
      if ($type === 'teacher' && $key === 'subject_id') continue;
      $output .= '<li><strong>' . ucfirst($key) . ':</strong> ' . $value . '</li>';
    }
    $output .= '</ul>';

    return [
      '#type' => 'container',
      'output' => [
        '#markup' => $output,
      ],
      'back' => [
        '#type' => 'link',
        '#title' => 'Nazad',
        '#url' => Url::fromRoute('elektronski_dnevnik.admin_users_controller'),
        '#attributes' => [
          'class' => ['button'],
          'style' => 'margin-top:15px;display:inline-block;',
        ],
      ],
    ];
  }

}
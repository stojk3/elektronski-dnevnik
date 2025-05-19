<?php

namespace Drupal\elektronski_dnevnik\Service;

use Drupal\Core\Database\Database;

class ClassPromotionService {

  protected $connection;

  public function __construct() {
    $this->connection = Database::getConnection();
  }

    public function getCurrentClasses() {
    $query = $this->connection->select('departments', 'd')
        ->fields('d', ['id', 'ime'])
        ->execute();

    return $query->fetchAllAssoc('id');
    }

    public function promoteClasses(array $department_ids) {
    $generacije = ['I', 'II', 'III', 'IV'];
    foreach ($department_ids as $id) {
        $department = $this->connection->select('departments', 'd')
        ->fields('d', ['ime'])
        ->condition('id', $id)
        ->execute()
        ->fetchAssoc();

        if ($department) {
        $ime = $department['ime'];
        // Pretpostavljamo da je ime u formatu "I1", "II2", itd.
        if (preg_match('/^(I{1,3}|IV)(.+)$/', $ime, $matches)) {
            $trenutna = $matches[1];
            $ostatak = $matches[2];
            $idx = array_search($trenutna, $generacije);
            if ($idx !== FALSE && $idx < count($generacije) - 1) {
            $nova = $generacije[$idx + 1] . $ostatak;
            $this->connection->update('departments')
                ->fields(['ime' => $nova])
                ->condition('id', $id)
                ->execute();
            }
        }
        }
    }
    }
}
<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StudentActivityController extends ControllerBase {

    public function viewActivity() {
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();

        $student_id = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchField();

        $user_dep_data = $connection->query("SELECT department_id FROM {students_departments} WHERE student_id = :student_id", [
            ':student_id' => $student_id
        ])->fetchAssoc();

        $department_id = $user_dep_data['department_id'];
        $current_date = date('Y-m-d');

        $results = $connection->query("SELECT vrsta_aktivnost, datum_upisa, predmet_id FROM {student_activity} WHERE department_id = :department_id AND datum_upisa > :current_date ORDER BY datum_upisa ASC", [
            ':department_id' => $department_id,
            ':current_date' => $current_date
        ])->fetchAll();        

        if (empty($results)) {
            return ['#markup' => $this->t('Nemate zakazanih aktivnosti.')];
        }

        $rows = [];
        foreach ($results as $row) {
            $subject_name = $connection->query("SELECT ime FROM {subjects} WHERE id = :predmet_id", [
                ':predmet_id' => $row->predmet_id
            ])->fetchField();

            $rows[] = [
                'datum' => $row->datum_upisa,
                'tip_aktivnosti' => $row->vrsta_aktivnost,
                'predmet' => $subject_name,
            ];
        }

        $header = [
            'datum' => $this->t('Datum aktivnosti'),
            'tip_aktivnosti' => $this->t('Tip aktivnosti'),
            'predmet' => $this->t('Predmet'),
        ];

        return [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('Nemate zakazanih aktivnosti.'),
        ];
    }
}

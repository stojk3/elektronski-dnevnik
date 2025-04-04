<?php

namespace Drupal\elektronski_dnevnik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StudentActivityController extends ControllerBase {

    protected $currentUser;

    public function __construct(AccountInterface $current_user) {
        $this->currentUser = $current_user;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('current_user')
        );
    }

    public function viewActivity() {
        $current_user = \Drupal::currentUser();
        $user_username = $current_user->getAccountName();
        $connection = \Drupal::database();

        $user_data = $connection->query("SELECT id FROM {students} WHERE username = :username", [
            ':username' => $user_username
        ])->fetchAssoc();

        if (!$user_data) {
            return ['#markup' => $this->t('Nemate pristup zakazanim aktivnostima.')];
        }

        $student_id = $user_data['id'];

        \Drupal::logger('student_activity')->notice('Student ID: @student_id', [
            '@student_id' => $student_id
        ]);

        $user_dep_data = $connection->query("SELECT department_id FROM {students_departments} WHERE student_id = :student_id", [
            ':student_id' => $student_id
        ])->fetchAssoc();

        if (!$user_dep_data) {
            return ['#markup' => $this->t('Nemate odeljenje, pa samim tim ni zakazane aktivnosti.')];
        }

        $department_id = $user_dep_data['department_id'];
        $current_date = date('Y-m-d');

        \Drupal::logger('student_activity')->notice('Department ID: @dep_id, Date: @date', [
            '@dep_id' => $department_id,
            '@date' => $current_date
        ]);

        $query = $connection->select('student_activity', 'g')
            ->fields('g', ['vrsta_aktivnost', 'datum_upisa', 'predmet_id'])
            ->condition('g.department_id', $department_id)
            ->condition('g.datum_upisa', $current_date, '>')
            ->orderBy('datum_upisa', 'ASC')
            ->execute();

        $results = $query->fetchAll();

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

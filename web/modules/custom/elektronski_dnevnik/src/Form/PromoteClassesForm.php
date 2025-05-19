<?php

namespace Drupal\elektronski_dnevnik\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\elektronski_dnevnik\Service\ClassPromotionService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PromoteClassesForm extends FormBase {

  protected $classPromotionService;

  public function __construct(ClassPromotionService $classPromotionService) {
    $this->classPromotionService = $classPromotionService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('elektronski_dnevnik.class_promotion_service')
    );
  }

  public function getFormId() {
    return 'promote_classes_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $classes = $this->classPromotionService->getCurrentClasses();
    $options = [];
    foreach ($classes as $class) {
      $options[$class->id] = $class->ime;
    }

    $form['classes'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select classes to promote'),
      '#options' => $options,
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Promote Classes'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $selected_classes = array_filter($form_state->getValue('classes'));

    if (!empty($selected_classes)) {
      $this->classPromotionService->promoteClasses(array_keys($selected_classes));
      $this->messenger()->addStatus($this->t('Selected classes have been promoted.'));
    } else {
      $this->messenger()->addError($this->t('No classes were selected for promotion.'));
    }
  }
}
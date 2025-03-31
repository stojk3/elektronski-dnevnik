<?php

namespace Drupal\content_access\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\node\NodeGrantDatabaseStorageInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Node Access settings form.
 *
 * @package Drupal\content_access\Form
 */
class ContentAccessPageForm extends FormBase {
  use ContentAccessRoleBasedFormTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   *   The entity type manager.
   */
  protected $entityTypeManager;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The node grant storage.
   *
   * @var \Drupal\node\NodeGrantDatabaseStorageInterface
   */
  protected $grantStorage;

  /**
   * ContentAccessPageForm constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\node\NodeGrantDatabaseStorageInterface $grant_storage
   *   The node grant storage.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ModuleHandlerInterface $module_handler, NodeGrantDatabaseStorageInterface $grant_storage) {
    $this->entityTypeManager = $entity_type_manager;
    $this->moduleHandler = $module_handler;
    $this->grantStorage = $grant_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('module_handler'),
      $container->get('node.grant_storage')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'content_access_page';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $defaults = [];

    foreach (_content_access_get_operations() as $op => $label) {
      $defaults[$op] = content_access_per_node_setting($op, $node);
    }

    $this->roleBasedForm($form, $defaults, $node->getType());

    // Add an after_build handler that disables checkboxes, which are enforced
    // by permissions.
    $build_info = $form_state->getBuildInfo();
    $build_info['files'][] = [
      'module' => 'content_access',
      'type' => 'inc',
      'name' => 'content_access.admin',
    ];
    $form_state->setBuildInfo($build_info);

    foreach (['update', 'update_own', 'delete', 'delete_own'] as $op) {
      $form['per_role'][$op]['#process'][] = '::forcePermissions';
    }

    // ACL form.
    if ($this->moduleHandler->moduleExists('acl')) {
      // This is disabled when there is no node passed.
      $form['acl'] = [
        '#type' => 'details',
        '#title' => $this->t('User access control lists'),
        '#description' => $this->t('These settings allow you to grant access to specific users.'),
        '#open' => TRUE,
        '#tree' => TRUE,
      ];

      foreach (['view', 'update', 'delete'] as $op) {
        $acl_id = content_access_get_acl_id($node, $op);

        $view = (int) ($op == 'view');
        $update = (int) ($op == 'update');
        acl_node_add_acl($node->id(), $acl_id, $view, $update, (int) ($op == 'delete'), content_access_get_settings('priority', $node->getType()));

        $form['acl'][$op] = acl_edit_form($form_state, $acl_id, $this->t('Grant @op access', ['@op' => $op]));

        $post_acl_id = $this->getRequest()->request->get('acl_' . $acl_id, NULL);
        $form['acl'][$op]['#collapsed'] = !isset($post_acl_id) && !json_decode($form['acl'][$op]['user_list']['#default_value']);
      }
    }

    $storage['node'] = $node;
    $form_state->setStorage($storage);

    $form['reset'] = [
      '#type' => 'submit',
      '#value' => $this->t('Reset to defaults'),
      '#weight' => 10,
      '#submit' => ['::pageResetSubmit'],
      '#access' => !empty(content_access_get_per_node_settings($node)),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#weight' => 10,
    ];

    // @todo not true anymore?
    // http://drupal.org/update/modules/6/7#hook_node_access_records
    if (!$node->isPublished()) {
      $this->messenger()->addError($this->t("Warning: Your content is not published, so this settings are not taken into account as long as the content remains unpublished."));
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $settings = [];
    $storage = $form_state->getStorage();
    $values = $form_state->getValues();
    $node = $storage['node'];

    foreach (_content_access_get_operations() as $op => $label) {
      // Set the settings so that further calls will return this settings.
      $filtered_values = array_filter($values[$op]);
      $settings[$op] = array_keys($filtered_values);
    }

    // Save per-node settings.
    content_access_save_per_node_settings($node, $settings);

    if ($this->moduleHandler->moduleExists('acl')) {
      $values = $form_state->getValues();
      foreach (['view', 'update', 'delete'] as $op) {
        acl_save_form($values['acl'][$op]);
      }
      $this->moduleHandler->invokeAll('user_acl', $settings);
    }

    // Apply new settings.
    $grants = $this->entityTypeManager->getAccessControlHandler('node')->acquireGrants($node);
    $this->grantStorage->write($node, $grants);
    $this->moduleHandler->invokeAll('per_node', [$settings, $node]);

    foreach (Cache::getBins() as $cache_backend) {
      $cache_backend->deleteAll();
    }
    // xxxx
    // route: node.configure_rebuild_confirm:
    // path:  '/admin/reports/status/rebuild'.
    $this->messenger()->addMessage($this->t('Your changes have been saved. You may have to <a href=":rebuild">rebuild permissions</a> for your changes to take effect.',
      [':rebuild' => Url::fromRoute('node.configure_rebuild_confirm')->toString()]));
  }

  /**
   * Submit callback for reset on content_access_page().
   */
  public function pageResetSubmit(array &$form, FormStateInterface $form_state) {
    $storage = $form_state->getStorage();
    content_access_delete_per_node_settings($storage['node']);
    $node = $storage['node'];
    $grants = $this->entityTypeManager->getAccessControlHandler('node')->acquireGrants($node);
    $this->grantStorage->write($node, $grants);

    $this->messenger()->addMessage($this->t('The permissions have been reset to the content type defaults.'));
  }

  /**
   * Checkboxes access for content.
   *
   * Formapi #process callback, that disables checkboxes for roles without
   * access to content.
   */
  public function forcePermissions($element, FormStateInterface $form_state, &$complete_form) {
    $storage = $form_state->getStorage();
    if (!empty($storage['node'] && is_array($element['#parents']))) {
      $node = $storage['node'];
      foreach (content_access_get_settings(reset($element['#parents']), $node->getType()) as $rid) {
        $element[$rid]['#disabled'] = TRUE;
        $element[$rid]['#attributes']['disabled'] = 'disabled';
        $element[$rid]['#value'] = TRUE;
        $element[$rid]['#checked'] = TRUE;

        $prefix_attr = new Attribute([
          'title' => $this->t("Permission is granted due to the content type\'s access control settings."),
        ]);
        $element[$rid]['#prefix'] = '<span ' . $prefix_attr . '>';
        $element[$rid]['#suffix'] = "</span>";
      }
    }
    return $element;
  }

}

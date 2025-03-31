<?php

namespace Drupal\content_access\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\Role;
use Drupal\user\PermissionHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Node Access settings form.
 */
class ContentAccessAdminSettingsForm extends FormBase {

  use ContentAccessRoleBasedFormTrait;

  /**
   * The permission handler.
   *
   * @var \Drupal\user\PermissionHandlerInterface
   */
  protected $permissionHandler;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new ContentAccessAdminSettingsForm.
   *
   * @param \Drupal\user\PermissionHandlerInterface $permission_handler
   *   The permission handler.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   */
  public function __construct(PermissionHandlerInterface $permission_handler, ModuleHandlerInterface $module_handler) {
    $this->permissionHandler = $permission_handler;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.permissions'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'content_access_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_type = NULL) {
    $storage = [
      'node_type' => $node_type,
    ];

    $form_state->setStorage($storage);

    // Add role based per content type settings.
    $defaults = [];
    foreach (_content_access_get_operations() as $op => $label) {
      $defaults[$op] = content_access_get_settings($op, $node_type);
    }

    $this->roleBasedForm($form, $defaults, $node_type);

    // Per node:
    $form['node'] = [
      '#type' => 'details',
      '#title' => $this->t('Per content node access control settings'),
      '#open' => FALSE,
      '#description' => $this->t('Optionally you can enable per content node access control settings. If enabled, a new tab for the content access settings appears when viewing content. You have to configure permission to access these settings at the <a href=":url">permissions</a> page.', [
        ':url' => Url::fromRoute('user.admin_permissions')->toString(),
      ]),
    ];
    $form['node']['per_node'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable per content node access control settings'),
      '#default_value' => content_access_get_settings('per_node', $node_type),
    ];

    $form['advanced'] = [
      '#type' => 'details',
      '#title' => $this->t('Advanced'),
      '#open' => FALSE,
    ];
    $form['advanced']['priority'] = [
      '#type' => 'weight',
      '#title' => $this->t('Give content node grants priority'),
      '#default_value' => content_access_get_settings('priority', $node_type),
      '#description' => $this->t('If you are only using this access control module, you can safely ignore this. If you are using multiple access control modules you can adjust the priority of this module.'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#weight' => 10,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $storage = $form_state->getStorage();
    /** @var \Drupal\user\Entity\Role $roles */
    $roles = Role::loadMultiple();
    $roles_permissions = [];
    foreach ($roles as $rid => $role) {
      $roles_permissions[$rid] = $role->getPermissions();
    }

    $permissions = $this->permissionHandler->getPermissions();
    $node_type = $storage['node_type'];

    // Remove disabled modules permissions, so they can't raise exception
    // in ::savePermissions().
    foreach ($roles_permissions as $rid => $role_permissions) {
      foreach ($role_permissions as $permission => $value) {
        if (!array_key_exists($permission, $permissions)) {
          unset($roles_permissions[$rid][$permission]);
        }
      }
    }

    foreach (['update', 'update_own', 'delete', 'delete_own'] as $op) {
      foreach ($values[$op] as $rid => $value) {
        $permission = content_access_get_permission_by_op($op, $node_type);
        if ($value) {
          $roles_permissions[$rid][$permission] = TRUE;
        }
        else {
          $roles_permissions[$rid][$permission] = FALSE;
        }
      }
      // Don't save the setting, so its default value (get permission) is
      // applied always.
      unset($values[$op]);
    }

    $this->savePermissions($roles_permissions);

    // Update content access settings.
    $settings = content_access_get_settings('all', $node_type);
    foreach (content_access_available_settings() as $setting) {
      if (isset($values[$setting])) {
        $settings[$setting] = is_array($values[$setting]) ? array_keys(array_filter($values[$setting])) : $values[$setting];
      }
    }
    content_access_set_settings($settings, $node_type);

    // Mass update the nodes, but only if necessary.
    if (content_access_get_settings('per_node', $node_type) ||
      content_access_get_settings('view', $node_type) != $form['per_role']['view']['#default_value'] ||
      content_access_get_settings('view_own', $node_type) != $form['per_role']['view_own']['#default_value'] ||
      content_access_get_settings('priority', $node_type) != $form['advanced']['priority']['#default_value'] ||
      content_access_get_settings('per_node', $node_type) != $form['node']['per_node']['#default_value']
    ) {

      // If per node has been disabled and we use the ACL integration, we have
      // to remove possible ACLs now.
      if (!content_access_get_settings('per_node', $node_type) && $form['node']['per_node']['#default_value'] && $this->moduleHandler->moduleExists('acl')) {
        _content_access_remove_acls($node_type);
      }

      if (content_access_mass_update([$node_type])) {
        $node_types = node_type_get_names();
        // This does not gurantee a rebuild.
        $this->messenger()->addMessage($this->t('Permissions have been changed for the content type @types.<br />You may have to <a href=":rebuild">rebuild permissions</a> for your changes to take effect.',
        [
          '@types' => $node_types[$node_type],
          ':rebuild' => Url::fromRoute('node.configure_rebuild_confirm')->toString(),
        ]));
      }
    }
    else {
      $this->messenger()->addMessage($this->t('No change.'));
    }

  }

  /**
   * Saves the given permissions by role to the database.
   */
  protected function savePermissions($roles_permissions) {
    foreach ($roles_permissions as $rid => $permissions) {
      user_role_change_permissions($rid, $permissions);
    }
  }

}

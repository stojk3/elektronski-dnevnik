<?php

namespace Drupal\content_access\Form;

use Drupal\user\Entity\Role;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Template\Attribute;

/**
 * Common components for Content Access forms.
 */
trait ContentAccessRoleBasedFormTrait {

  /**
   * Builds the role based permission form for the given defaults.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param array $defaults
   *   Array of defaults for all operations.
   * @param string $type
   *   The node type id.
   */
  protected function roleBasedForm(array &$form, array $defaults = [], $type = NULL) {
    $description = [
      t('Note that users need at least the %access_content permission to be able to deal in any way with content.', [
        '%access_content' => t('access content'),
      ]),
      t('Furthermore note that content which is not published is treated in a different way by Drupal: It can be viewed only by its author or users with the %perm permission.', [
        '%perm' => t('bypass node access'),
      ]),
    ];
    $form['per_role'] = [
      '#type' => 'fieldset',
      '#title' => t('Role based access control settings'),
      '#description' => implode(' ', $description),
    ];

    $operations = _content_access_get_operations($type);
    $user_roles = Role::loadMultiple();
    $roles = [];
    foreach ($user_roles as $role) {
      $roles[$role->id()] = $role->get('label');
    }
    foreach ($operations as $op => $label) {
      // Make sure defaults are set properly.
      $defaults += [$op => []];

      $form['per_role'][$op] = [
        '#type' => 'checkboxes',
        '#prefix' => '<div class="content_access-div">',
        '#suffix' => '</div>',
        '#options' => $roles,
        '#title' => $label,
        '#default_value' => $defaults[$op],
      ];

      $form['per_role'][$op]['#process'] = [
        [
          '\Drupal\Core\Render\Element\Checkboxes',
          'processCheckboxes',
        ],
        [
          '\Drupal\content_access\Form\ContentAccessRoleBasedFormTrait',
          'disableCheckboxes',
        ],
      ];
    }

    $form['per_role']['clearer'] = [
      '#value' => '<br clear="all" />',
    ];

    $form['#attached']['library'][] = 'content_access/drupal.content_access';

    return $form;
  }

  /**
   * Checkboxes access for content.
   *
   * Formapi #process callback, that disables checkboxes for roles without
   * access to content.
   */
  public static function disableCheckboxes(&$element, FormStateInterface $form_state, &$complete_form) {
    $access_roles = content_access_get_permission_access('access content');
    $admin_roles = content_access_get_permission_access('bypass node access');

    foreach (Element::children($element) as $key) {
      if (!in_array($key, $access_roles) &&
        $key == AccountInterface::ANONYMOUS_ROLE &&
        !in_array(AccountInterface::AUTHENTICATED_ROLE, $access_roles)
      ) {
        $element[$key]['#disabled'] = TRUE;
        $element[$key]['#default_value'] = FALSE;
        $element[$key]['#prefix'] = '<span ' . new Attribute([
          'title' => t("This role is lacking the permission '@perm', so it has no access.", ['@perm' => t('access content')]),
        ]) . '>';
        $element[$key]['#suffix'] = "</span>";
      }
      elseif (in_array($key, $admin_roles) || ($key != AccountInterface::ANONYMOUS_ROLE && in_array(AccountInterface::AUTHENTICATED_ROLE, $admin_roles))) {
        // Fix the checkbox to be enabled for users with administer node
        // privileges.
        $element[$key]['#disabled'] = TRUE;
        $element[$key]['#default_value'] = TRUE;
        $element[$key]['#prefix'] = '<span ' . new Attribute([
          'title' => t("This role has '@perm' permission, so access is granted.", ['@perm' => t('bypass node access')]),
        ]) . '>';
        $element[$key]['#suffix'] = "</span>";
      }
    }

    return $element;
  }

}

<?php

namespace Drupal\Tests\content_access\Functional;

use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\user\Entity\Role;

/**
 * Helper class with auxiliary functions for content access module tests.
 */
trait ContentAccessTestHelperTrait {

  /**
   * Role ID for authenticated users.
   *
   * @var string
   */
  protected $rid = AccountInterface::AUTHENTICATED_ROLE;

  /**
   * Change access permissions for a content type.
   */
  public function changeAccessContentType($accessSettings) {
    $this->drupalGet('admin/structure/types/manage/' . $this->contentType->id() . '/access');
    $this->submitForm($accessSettings, 'Submit');
    // Both these may be printed:
    // 'Permissions have been changed' || 'No change' => 'change'.
    $this->assertSession()->pageTextContains('change');
  }

  /**
   * Access keyword for content type.
   *
   * Change access permissions for a content type by a given keyword for the
   * role of the user.
   */
  public function changeAccessContentTypeKeyword($keyword, $access = TRUE, AccountInterface $user = NULL) {
    $roles = [];

    if ($user === NULL) {
      $role = Role::load($this->rid);
      $roles[$role->id()] = $role->id();
    }
    else {
      $userRoles = $user->getRoles();
      foreach ($userRoles as $role) {
        $roles[$role] = $role;
        break;
      }
    }

    $accessSettings = [
      $keyword . '[' . key($roles) . ']' => $access,
    ];

    $this->changeAccessContentType($accessSettings);
  }

  /**
   * Change the per node access setting for a content type.
   */
  public function changeAccessPerNode($access = TRUE) {
    $accessPermissions = [
      'per_node' => $access,
    ];
    $this->changeAccessContentType($accessPermissions);
  }

  /**
   * Access keyword for node.
   *
   * Change access permissions for a node by a given keyword (view, update
   * or delete).
   */
  public function changeAccessNodeKeyword(NodeInterface $node, $keyword, $access = TRUE) {
    $user = $this->testUser;
    $userRoles = $user->getRoles();
    foreach ($userRoles as $rid) {
      $role = Role::load($rid);
      $roles[$role->id()] = $role->get('label');
    }

    $accessSettings = [
      $keyword . '[' . key($roles) . ']' => $access,
    ];

    $this->changeAccessNode($node, $accessSettings);
  }

  /**
   * Change access permission for a node.
   */
  public function changeAccessNode(NodeInterface $node, $accessSettings) {
    $this->drupalGet('node/' . $node->id() . '/access');
    $this->submitForm($accessSettings, 'Submit');
    $this->assertSession()->pageTextContains('Your changes have been saved.');
  }

  /**
   * Get the autocomplete input string that \Drupal\Core\Entity\Element\EntityAutocomplete::extractEntityIdFromAutocompleteInput expects.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity to get the autocomplete input string for.
   *
   * @return string
   *   The autocomplete input string.
   */
  protected function getAutocompleteInputString(EntityInterface $entity) {
    return $entity->label() . ' (' . $entity->id() . ')';
  }

}

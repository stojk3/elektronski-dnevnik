<?php

namespace Drupal\content_access\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class ContentAccessAdminSettingsAccessCheck.
 *
 * Determines access to routes based on permissions defined via
 * $module.permissions.yml files.
 */
class ContentAccessAdminSettingsAccessCheck implements AccessInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a ContentAccessAdminSettingsAccessCheck object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account, RouteMatchInterface $route_match) {
    $node_type_id = $route_match->getParameter('node_type');
    $node_type = $this->entityTypeManager->getStorage('node_type')->load($node_type_id);

    $permission_match = $account->hasPermission('bypass node access') && $account->hasPermission('administer content types');
    return AccessResult::allowedIf($permission_match && $node_type);
  }

}

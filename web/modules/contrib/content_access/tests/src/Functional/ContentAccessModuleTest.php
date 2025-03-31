<?php

namespace Drupal\Tests\content_access\Functional;

use Drupal\language\Entity\ConfigurableLanguage;
use Drupal\Tests\BrowserTestBase;

/**
 * Automated BrowserTest Case for content access module.
 *
 * @group Access
 */
class ContentAccessModuleTest extends BrowserTestBase {
  use ContentAccessTestHelperTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'content_access',
    'content_translation',
    'language',
  ];

  /**
   * A user with permission to non administer.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $testUser;

  /**
   * A user with permission to administer.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $adminUser;

  /**
   * Content type for test.
   *
   * @var \Drupal\node\Entity\NodeType
   */
  protected $contentType;

  /**
   * Node object to perform test.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $node1;

  /**
   * Node object to perform test.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $node2;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * English title for nodes.
   *
   * @var string
   */
  protected string $englishTitle = 'English node';

  /**
   * English title for nodes.
   *
   * @var string
   */
  protected string $frenchTitle = 'French node';

  /**
   * English title for nodes.
   *
   * @var string
   */
  protected string $spanishTitle = 'Spanish node';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    ConfigurableLanguage::createFromLangcode('fr')->save();
    ConfigurableLanguage::createFromLangcode('es')->save();

    // Create test user with separate role.
    $this->testUser = $this->drupalCreateUser();

    // Create admin user.
    $this->adminUser = $this->drupalCreateUser([
      'access content',
      'administer content types',
      'grant content access',
      'grant own content access',
      'bypass node access',
      'access administration pages',
    ]);
    $this->drupalLogin($this->adminUser);

    // Rebuild content access permissions.
    node_access_rebuild();

    // Create test content type.
    $this->contentType = $this->drupalCreateContentType();

    // Create test nodes.
    $this->node1 = $this->drupalCreateNode([
      'type' => $this->contentType->id(),
      'language' => 'en',
      'status' => 1,
      'title' => $this->englishTitle,
    ]);
    $this->node2 = $this->drupalCreateNode([
      'type' => $this->contentType->id(),
      'language' => 'en',
      'status' => 1,
      'title' => $this->englishTitle,
    ]);
  }

  /**
   * Test for viewing nodes.
   */
  public function testViewAccess() {
    // Restrict access to the content type.
    $accessPermissions = [
      'view[anonymous]' => FALSE,
      'view[authenticated]' => FALSE,
    ];
    $this->changeAccessContentType($accessPermissions);

    // Logout admin and try to access the node anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, view node, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin and grant access for viewing to the test user.
    $this->drupalLogin($this->adminUser);
    $this->changeAccessContentTypeKeyword('view');

    // Logout admin and try to access the node anonymously
    // access must be denied again.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, view node, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextNotContains('Access denied');

    // Login admin and enable per node access.
    $this->drupalLogin($this->adminUser);
    $this->changeAccessPerNode();

    // Restrict access on node2 for the test user role.
    $this->changeAccessNodeKeyword($this->node2, 'view', FALSE);

    // Logout admin and try to access both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, view node1, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextNotContains('Access denied');

    // View node2, access must be denied.
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin, swap permissions between content type and node2.
    $this->drupalLogin($this->adminUser);

    // Restrict access to content type.
    $this->changeAccessContentTypeKeyword('view', FALSE);

    // Grant access to node2.
    $this->changeAccessNodeKeyword($this->node2, 'view');

    // Logout admin and try to access both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, view node1, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // View node2, access must be granted.
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextNotContains('Access denied');
  }

  /**
   * Test for editing nodes.
   */
  public function testEditAccess() {
    // Logout admin and try to edit the node anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, edit node, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin and grant access for editing to the test user.
    $this->drupalLogin($this->adminUser);
    $this->changeAccessContentTypeKeyword('update');

    // Logout admin and try to edit the node anonymously
    // access must be denied again.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, edit node, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextNotContains('Access denied');

    // Login admin and enable per node access.
    $this->drupalLogin($this->adminUser);
    $this->changeAccessPerNode();

    // Restrict access for this content type for the test user.
    $this->changeAccessContentTypeKeyword('update', FALSE);

    // Allow access for node1 only.
    $this->changeAccessNodeKeyword($this->node1, 'update');
    $this->changeAccessNodeKeyword($this->node2, 'update', FALSE);

    // Logout admin and try to edit both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, edit node1, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextNotContains('Access denied');

    // Edit node2, access must be denied.
    $this->drupalGet('node/' . $this->node2->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin, swap permissions between node1 and node2.
    $this->drupalLogin($this->adminUser);

    // Grant edit access to node2.
    $this->changeAccessNodeKeyword($this->node2, 'update');
    // Restrict edit access to node1.
    $this->changeAccessNodeKeyword($this->node1, 'update', FALSE);

    // Logout admin and try to edit both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, edit node1, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/edit');
    $this->assertSession()->pageTextContains('Access denied');

    // Edit node2, access must be granted.
    $this->drupalGet('node/' . $this->node2->id() . '/edit');
    $this->assertSession()->pageTextNotContains('Access denied');
  }

  /**
   * Test for deleting nodes.
   */
  public function testDeleteAccess() {
    // Logout admin and try to delete the node anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, delete node, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin and grant access for deleting to the test user.
    $this->drupalLogin($this->adminUser);

    $this->changeAccessContentTypeKeyword('delete');

    // Logout admin and try to edit the node anonymously
    // access must be denied again.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, delete node, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->submitForm([], 'Delete');

    // Check that the test node was deleted successfully by testUser.
    $title = $this->node1->getTitle();
    $this->assertSession()->pageTextContains("$title has been deleted");

    // Login admin and recreate test node1.
    $this->drupalLogin($this->adminUser);
    $this->node1 = $this->drupalCreateNode(
      ['type' => $this->contentType->id()]
    );

    // Enable per node access.
    $this->changeAccessPerNode();

    // Restrict access for this content type for the test user.
    $this->changeAccessContentTypeKeyword('delete', FALSE);

    // Allow access for node1 only.
    $this->changeAccessNodeKeyword($this->node1, 'delete');
    $this->changeAccessNodeKeyword($this->node2, 'delete', FALSE);

    // Logout admin and try to delete both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, delete node1, access must be granted.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextNotContains('Access denied');

    // Delete node2, access must be denied.
    $this->drupalGet('node/' . $this->node2->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login admin, swap permissions between node1 and node2.
    $this->drupalLogin($this->adminUser);

    // Grant delete access to node2.
    $this->changeAccessNodeKeyword($this->node2, 'delete');
    // Restrict delete access to node1.
    $this->changeAccessNodeKeyword($this->node1, 'delete', FALSE);

    // Logout admin and try to delete both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user, delete node1, access must be denied.
    $this->drupalLogin($this->testUser);
    $this->drupalGet('node/' . $this->node1->id() . '/delete');
    $this->assertSession()->pageTextContains('Access denied');

    // Delete node2, access must be granted.
    $this->drupalGet('node/' . $this->node2->id() . '/delete');
    $this->assertSession()->pageTextNotContains('Access denied');
  }

  /**
   * Test own view access.
   */
  public function testOwnViewAccess() {
    // Setup 2 test users.
    $testUser1 = $this->testUser;
    $testUser2 = $this->drupalCreateUser();

    // Change ownership of test nodes to test users.
    $this->node1->setOwner($testUser1);
    $this->node1->save();

    $this->node2->setOwner($testUser2);
    $this->node2->save();

    // Remove all view permissions for this content type.
    $accessPermissions = [
      'view[anonymous]' => FALSE,
      'view[authenticated]' => FALSE,
      'view_own[anonymous]' => FALSE,
      'view_own[authenticated]' => FALSE,
    ];
    $this->changeAccessContentType($accessPermissions);

    // Allow view own content for test user 1 and 2 roles.
    $this->changeAccessContentTypeKeyword('view_own', TRUE, $testUser1);
    $this->changeAccessContentTypeKeyword('view_own', TRUE, $testUser2);

    // Logout admin and try to access both nodes anonymously.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user 1, view node1, access must be granted.
    $this->drupalLogin($testUser1);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextNotContains('Access denied');

    // View node2, access must be denied.
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Login test user 2, view node1, access must be denied.
    $this->drupalLogin($testUser2);
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // View node2, access must be granted.
    $this->drupalGet('node/' . $this->node2->id());
    $this->assertSession()->pageTextNotContains('Access denied');
  }

  /**
   * Test translations view access.
   */
  public function testTranslationsViewAccess() {
    // Check access to the English node.
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains($this->englishTitle);

    // Create an unpublished French translation.
    $this->drupalLogin($this->adminUser);
    $nodeFr = $this->node1->addTranslation('fr');
    $nodeFr->setTitle($this->frenchTitle);
    $nodeFr->set('status', 0);
    $nodeFr->save();

    // Check access for admin.
    $this->drupalGet('fr/node/' . $this->node1->id());
    $this->assertSession()->pageTextContains($this->frenchTitle);

    // Log out and check that anonymous can't access the node.
    $this->drupalLogout();
    $this->drupalGet('fr/node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');

    // Check that English translation is still visible.
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains($this->englishTitle);

    // Create a published Spanish translation.
    $this->drupalLogin($this->adminUser);
    $nodeEs = $this->node1->addTranslation('es');
    $nodeEs->setTitle($this->spanishTitle);
    $nodeEs->set('status', 1);
    $nodeEs->save();

    // Now anonymous should only get to the EN and ES translations.
    $this->drupalLogout();
    $this->drupalGet('node/' . $this->node1->id());
    $this->assertSession()->pageTextContains($this->englishTitle);
    $this->drupalGet('es/node/' . $this->node1->id());
    $this->assertSession()->pageTextContains($this->spanishTitle);
    $this->drupalGet('fr/node/' . $this->node1->id());
    $this->assertSession()->pageTextContains('Access denied');
  }

}

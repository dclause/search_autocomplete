<?php

/**
 * @file
 * Contains \Drupal\search_autocomplete\Tests\Views\CallbackViewsTest.
 * Test case for testing the Autocompletion Callback view.
 *
 * Sponsored by: www.drupal-addict.com
 */

namespace Drupal\search_autocomplete\Tests\Views;

use Drupal\views\Tests\ViewTestBase;
use Drupal\views\Views;
use Drupal\node\Entity\Node;
use Drupal\Component\Utility\String;

/**
 * Test callback view configurations.
 *
 * @group Search Autocomplete
 *
 * @ingroup seach_auocomplete
 */
class CallbackViewsTest extends ViewTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('node', 'views_ui', 'search_autocomplete');

  /**
   * The admin user
   * @var \Drupal\user\Entity\User
   */
  public $adminUser;

  /**
   * The entity storage for nodes.
   *
   * @var \Drupal\node\NodeStorage
   */
  protected $nodeStorage;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Callback view configurationt tests.',
      'description' => 'Tests the callback view display.',
      'group' => 'Search Autocomplete',
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Log with admin permissions.
    $this->adminUser = $this->drupalCreateUser(array('access content', 'administer views', 'administer search autocomplete'));
    $this->drupalLogin($this->adminUser);

    // Get the node manager.
    $this->nodeStorage = $this->container->get('entity.manager')
    ->getStorage('node');
  }

  /**
   * Basic checks : default view is inserted.
   */
  public function testDefaultView() {
    $view = Views::getView('autocompletion_callbacks');

    // Find the view in the view list page.
    $this->drupalGet("admin/structure/views");
    $this->assertRaw(t('Autocompletion Callbacks'));
    $this->assertRaw(t('autocompletion_callbacks'));
  }

  /**
   * Default view content checks.
   */
  public function testDefaultViewContent() {

    // Retrieve node default view.
    $actual_json = $this->drupalGet("callback/nodes");
    $expected = array();
    $this->assertIdentical($actual_json, json_encode($expected), 'The expected JSON output was found.');

    // Create some published nodes of type article and page.
    $this->createNodes(5, "article", $expected);
    $this->createNodes(5, "page", $expected);

    // Get the view page.
    $actual_json = $this->drupalGet("callback/nodes");

    // Check the view result using serializer service.
    $serializer = $this->container->get('serializer');
    $expected_string = $serializer->serialize($expected, 'json');
    $this->assertIdentical($actual_json, $expected_string);

    // Log out user.
    $this->drupalLogout();

    // Re-test as anonymous user.
    $actual_json = $this->drupalGet("callback/nodes");
    $this->assertIdentical($actual_json, $expected_string);
  }

  /**
   * Helper methods: creates a given number of nodes of a give type.
   *
   * @param integer $number
   *   number of nodes to create.
   * @param string $type
   *   the type machine name of nodes to create.
   *
   * @return array
   *   the array of node results as it should be in the view result.
   */
  protected function createNodes($number, $type, &$expected) {
    $type = $this->drupalCreateContentType(['type' => $type, 'name' => $type]);
    for ($i = 1; $i < $number; $i++) {
      $settings = array(
        'body'      => array(array(
          'value' => $this->randomMachineName(32),
          'format' => filter_default_format(),
          ),
        ),
        'type'    => $type->id(),
        'created' => 123456789,
        'title'   => $type->id() . ' ' . $i,
        'status'  => TRUE,
        'promote' => rand(0, 1) == 1,
        'sticky'  => rand(0, 1) == 1,
        'uid'       => \Drupal::currentUser()->id(),
      );
      $node = entity_create('node', $settings);
      $status = $node->save();
      $this->assertEqual($status, SAVED_NEW, String::format('Created node %title.', array('%title' => $node->label())));

      $result = array(
        'value' => $type->id() . ' ' . $i,
        'fields'  => array(
          'title'   => $type->id() . ' ' . $i,
          'created' => 'by ' . $this->adminUser->getUsername() . ' | Thu, 11/29/1973 - 21:33',
        ),
        'link'  => $node->url('canonical', array('absolute' => TRUE)),
      );
      if ($i == 1) {
        $result += array(
          'group' => array(
            'group_id' => $type->id(),
            'group_name' => $type->label() . "s",
          ),
        );
      }
      $expected[] = $result;
    }
    return $expected;
  }

}

<?php

/**
 * @file
 * Test case for testing the Config Entity Example module.
 */

namespace Drupal\search_autocomplete\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Test the Config Entity Example module.
 *
 * @group search_autocomplete
 * @group examples
 *
 * @ingroup search_autocomplete
 */
class SearchAutocompleteTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('search_autocomplete');

  /**
   * The installation profile to use with this test.
   *
   * We need the 'minimal' profile in order to make sure the Tool block is
   * available.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Search Autocomplete functional test',
      'description' => 'Test the Search Autocomplete settings configuration.',
      'group' => 'Examples',
    );
  }

  /**
   * Various functional test of the Config Entity Example module.
   *
   * 1) Verify that the Marvin entity was created when the module was installed.
   *
   * 2) Verify that permissions are applied to the various defined paths.
   *
   * 3) Verify that we can manage entities through the user interface.
   *
   * 4) Verify that the entity we add can be re-edited.
   */
  public function testSearchAutocomplete() {
    // 1) Verify that the Marvin entity was created when the module was
    // installed.
    $entity = entity_load('autocompletion_configuration', 'marvin');
    $this->assertNotNull($entity, 'Marvin was created during installation.');

    // 2) Verify that permissions are applied to the various defined paths.
    // Define some paths. Since the Marvin entity is defined, we can use it
    // in our management paths.
    $forbidden_paths = array(
      '/admin/config/search/search_autocomplete',
      '/admin/config/search/search_autocomplete/add',
      '/admin/config/search/search_autocomplete/manage/marvin',
      '/admin/config/search/search_autocomplete/manage/marvin/delete',
    );
    // Check each of the paths to make sure we don't have access. At this point
    // we haven't logged in any users, so the client is anonymous.
    foreach ($forbidden_paths as $path) {
      $this->drupalGet($path);
      $this->assertResponse(403, "Access denied to anonymous for path: $path");
    }

    // Create a user with no permissions.
    $noperms_user = $this->drupalCreateUser();
    $this->drupalLogin($noperms_user);
    // Should be the same result for forbidden paths, since the user needs
    // special permissions for these paths.
    foreach ($forbidden_paths as $path) {
      $this->drupalGet($path);
      $this->assertResponse(403, "Access denied to generic user for path: $path");
    }

    // Create a user who can administer search autocomplete.
    $admin_user = $this->drupalCreateUser(array('administer search autocomplete'));
    $this->drupalLogin($admin_user);
    // Forbidden paths aren't forbidden any more.
    foreach ($forbidden_paths as $unforbidden) {
      $this->drupalGet($unforbidden);
      $this->assertResponse(200, "Access granted to admin user for path: $unforbidden");
    }

    // Now that we have the admin user logged in, check the menu links.
    $this->drupalGet('/');
    $this->assertLinkByHref('/admin/config/search/search_autocomplete');

    // 3) Verify that we can manage entities through the user interface.
    // We still have the admin user logged in, so we'll create, update, and
    // delete an entity.
    // Go to the list page.
    $this->drupalGet('/admin/config/search/search_autocomplete');
    $this->clickLink('Add autocompletion_configuration');
    $robot_machine_name = 'roboname';
    $this->drupalPostForm(
      NULL,
      array(
        'label' => $robot_machine_name,
        'id' => $robot_machine_name,
        'floopy' => TRUE,
      ),
      t('Create Robot')
    );

    // 4) Verify that our autocompletion_configuration appears when we edit it.
    $this->drupalGet('/admin/config/search/search_autocomplete/manage/' . $robot_machine_name);
    $this->assertField('label');
    $this->assertFieldChecked('edit-floopy');
  }

}

<?php

/**
 * @file
 * Test case for testing the Config Entity Example module.
 */

namespace Drupal\search_autocomplete\Tests\Entity;

use Drupal\simpletest\WebTestBase;

/**
 * Test proper module installation.
 *
 * @group Search Autocomplete
 *
 * @ingroup seach_auocomplete
 */
class ManageConfigEntityTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('search_autocomplete');

  /**
   * The installation profile to use with this test.
   *
   * We need the 'minimal' profile in order to make sure the Search module is
   * available.
   *
   * @var string
   */
  //protected $profile = 'minimal';

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Manage Autocompletion Configuration test.',
      'description' => 'Test is autocompletion configurations can be added/edited/deleted.',
      'group' => 'Search Autocomplete',
    );
  }

  protected function setUp() {
    parent::setUp();
    $admin_user = $this->drupalCreateUser(array('administer search autocomplete'));
    $this->drupalLogin($admin_user);
  }


  /**
   * Check that autocompletion configurations can be added/edited/deleted.
   *
   * 1) Verify that we can add new configuration through admin UI.
   *
   * 2) Verify that we can edit the configuration through admin UI.
   */
  public function testManageConfigEntity() {

    // ----------------------------------------------------------------------
    // 1) Verify that we can add new configuration through admin UI.
    // We  have the admin user logged in (through test setup), so we'll create
    // a new configuration.

    // Open admin UI
    $this->drupalGet('/admin/config/search/search_autocomplete');
    // click Add new button
    $this->clickLink('Add new Autocompletion Configuration');

    $config_name = 'configname';
    $selector = '#edit-keys';
    $this->drupalPostForm(
      NULL,
      array(
        'label' => $config_name,
        'id' => $config_name,
        'selector' => $selector
      ),
      t('Create Autocompletion Configuration')
    );

    // ----------------------------------------------------------------------
    // 2) Verify that we can edit the configuration through admin UI.

    // Open edit admin UI.
    $this->drupalGet('/admin/config/search/search_autocomplete/manage/' . $config_name);
    // Check fields value
    $this->assertField('label', $config_name);
    $this->assertField('selector', $selector);
  }

}

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
class BasicCRUDConfigEntityTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('search_autocomplete');

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

  /**
   * {@inheritdoc}
   */
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
   * 2) Verify that add redirect to edit page.
   *
   * 3) Verify that default add configuration values are inserted.
   *
   * 4) Verify that user is redirected to listing page.
   *
   * 5) Verify that we can edit the configuration through admin UI.
   */
  public function testManageConfigEntity() {

    // ----------------------------------------------------------------------
    // 1) Verify that we can add new configuration through admin UI.
    // We  have the admin user logged in (through test setup), so we'll create
    // a new configuration.

    // Open admin UI.
    $this->drupalGet('/admin/config/search/search_autocomplete');
    // Click Add new button.
    $this->clickLink('Add new Autocompletion Configuration');

    // Build a configuration data.
    $config_name = 'testing_config';
    $config = array(
      'label'         => 'Unit testing configuration.',
      'selector'      => '#test-key',
      'minChar'       => 3,
      'maxSuggestion' => 10,
      'noResultLabel' => t('No results found for [search-phrase]. Click to perform full search.'),
      'noResultValue' => '[search-phrase]',
      'noResultLink'  => '',
      'moreResultsLabel' => t('View all results for [search-phrase].'),
      'moreResultsValue' => '[search-phrase]',
      'moreResultsLink'  => '',
    );

    $this->drupalPostForm(
      NULL,
      array(
        'label' => $config['label'],
        'id' => $config_name,
        'selector' => $config['selector'],
      ),
      t('Create Autocompletion Configuration')
    );

    // ----------------------------------------------------------------------
    // 2) Verify that add redirect to edit page.
    $this->assertUrl('/admin/config/search/search_autocomplete/manage/' . $config_name);

    // ----------------------------------------------------------------------
    // 3) Verify that default add configuration values are inserted.
    $this->assertField('label', $config['label']);
    $this->assertField('selector', $config['selector']);
    $this->assertField('minChar', $config['minChar']);
    $this->assertField('maxSuggestion', $config['maxSuggestion']);
    $this->assertField('noResultLabel', $config['noResultLabel']);
    $this->assertField('noResultValue', $config['noResultValue']);
    $this->assertField('noResultLink', $config['noResultLink']);
    $this->assertField('moreResultsLabel', $config['moreResultsLabel']);
    $this->assertField('moreResultsValue', $config['moreResultsValue']);
    $this->assertField('moreResultsLink', $config['moreResultsLink']);

    // Change default values.
    $config['minChar'] = 1;
    $config['noResultLabel'] = 'No result test label';
    $config['moreResultsLink'] = 'http://google.com';

    $this->drupalPostForm(
      NULL,
      $config,
      t('Update')
    );

    // ----------------------------------------------------------------------
    // 4) Verify that user is redirected to listing page.
    $this->assertUrl('/admin/config/search/search_autocomplete');

    // ----------------------------------------------------------------------
    // 5) Verify that we can edit the configuration through admin UI.
    $this->drupalGet('/admin/config/search/search_autocomplete/manage/' . $config_name);
    $this->assertField('label', $config['label']);
    $this->assertField('selector', $config['selector']);
    $this->assertField('minChar', $config['minChar']);
    $this->assertField('maxSuggestion', $config['maxSuggestion']);
    $this->assertField('noResultLabel', $config['noResultLabel']);
    $this->assertField('noResultValue', $config['noResultValue']);
    $this->assertField('noResultLink', $config['noResultLink']);
    $this->assertField('moreResultsLabel', $config['moreResultsLabel']);
    $this->assertField('moreResultsValue', $config['moreResultsValue']);
    $this->assertField('moreResultsLink', $config['moreResultsLink']);

  }

}

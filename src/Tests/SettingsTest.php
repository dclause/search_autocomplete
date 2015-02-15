<?php

/**
 * @file
 * Test case for testing the Config Entity Example module.
 */

namespace Drupal\search_autocomplete\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Test proper module installation.
 *
 * @group Search Autocomplete
 *
 * @ingroup seach_auocomplete
 */
class SettingsTest extends WebTestBase {

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
      'name' => 'Search Autocomplete settings test.',
      'description' => 'Test the Search Autocomplete settings page.',
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
   * Check that Search Autocomplete module installs properly.
   *
   * 1) Check the default settings value : configs are activated,
   *    translite is TRUE and admin_helper is FALSE
   *
   * 2) Desactivate all available configurations and reverse settings.
   *
   * 3) Check that all default configurations are desactivate,
   *    and settings are toogled.
   *
   */
  public function testInstallModule() {

    // Open admin UI.
    $this->drupalGet('/admin/config/search/search_autocomplete');

    // ----------------------------------------------------------------------
    // 1) Check the default settings value : configs are activated,
    // translite is TRUE and admin_helper is FALSE.
    $this->assertFieldChecked('edit-configs-search-block-enabled');
    $this->assertFieldChecked('edit-translite');
    $this->assertNoFieldChecked('edit-admin-helper');

    // ----------------------------------------------------------------------
    // 2) Desactivate all available configurations and reverse settings.
    $edit = array(
      'configs[search_block][enabled]' => FALSE,
      'translite' => FALSE,
      'admin_helper' => TRUE,
    );
    $this->drupalPostForm(NULL, $edit, t('Save changes'));

    // 3) Check that all default configurations are desactivate,
    // and settings are toogled.
    $this->assertNoFieldChecked('edit-translite');
    $this->assertFieldChecked('edit-admin-helper');
    $this->assertNoFieldChecked('edit-configs-search-block-enabled');

  }

}

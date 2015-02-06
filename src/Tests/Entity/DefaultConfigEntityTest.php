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
class DefaultConfigEntityTest extends WebTestBase {

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
      'name' => 'Default Entity inclusion tests.',
      'description' => 'Test the inclusion of default configurations.',
      'group' => 'Search Autocomplete',
    );
  }

  /**
   * Check that default entities are properly included.
   *
   * 1) check for search_block default configuration.
   */
  public function testDefaultConfigEntityInclusion() {

    // ----------------------------------------------------------------------
    // 1) Verify that the search_block default config is properly added.
    $entity = entity_load('autocompletion_configuration', 'search_block');
    $this->assertNotNull($entity, 'Default configuration search_block created during installation process.');

  }

}

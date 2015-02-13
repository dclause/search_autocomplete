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

    // Build a configuration data.
    $config = array(
      'id'            => 'search_block',
      'label'         => 'Search Block',
      'selector'      => '#edit-keys',
      'status'        => TRUE,
      'minChar'       => 3,
      'maxSuggestion' => 10,
      'noResultLabel' => t('No results found for [search-phrase]. Click to perform full search.'),
      'noResultValue' => '[search-phrase]',
      'noResultLink'  => '',
      'moreResultsLabel' => t('View all results for [search-phrase].'),
      'moreResultsValue' => '[search-phrase]',
      'moreResultsLink'  => '',
    );

    // ----------------------------------------------------------------------
    // 1) Verify that the search_block default config is properly added.
    $entity = entity_load('autocompletion_configuration', $config['id']);
    $this->assertNotNull($entity, 'Default configuration search_block created during installation process.');

    $this->assertEqual($entity->id(), $config['id']);
    $this->assertEqual($entity->label(), $config['label']);
    $this->assertEqual($entity->getStatus(), $config['status']);
    $this->assertEqual($entity->getSelector(), $config['selector']);
    $this->assertEqual($entity->getMinChar(), $config['minChar']);
    $this->assertEqual($entity->getMaxSuggestion(), $config['maxSuggestion']);
    $this->assertEqual($entity->getNoResultLabel(), $config['noResultLabel']);
    $this->assertEqual($entity->getNoResultValue(), $config['noResultValue']);
    $this->assertEqual($entity->getNoResultLink(), $config['noResultLink']);
    $this->assertEqual($entity->getMoreResultsLabel(), $config['moreResultsLabel']);
    $this->assertEqual($entity->getMoreResultsValue(), $config['moreResultsValue']);
    $this->assertEqual($entity->getMoreResultsLink(), $config['moreResultsLink']);

  }

}

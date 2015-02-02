<?php

/**
 * @file
 * Contains Drupal\search_autocomplete\SuggestionGroup.
 */

namespace Drupal\search_autocomplete;

/**
 * Define what a suggestion group is.
 *
 * Suggestions can be grouped by whatever field, for instance all suggestions
 * referencing Content, or suggestions referencing Users, etc..
 */
class SuggestionGroup {

  /**
   * The suggestion group_id.
   * This will be used as a classname when displayed.
   *
   * @var string
   */
  private $id;


  // ---------  GETTERS  ---------

  public function getId() {
    return $this->id;
  }

  // ---------  SETTERS  ---------

  public function setId($id) {
    $this->id = $id;
  }

}

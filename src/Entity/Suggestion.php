<?php

/**
 * @file
 * Contains Drupal\search_autocomplete\Entity\Suggestion.
 */

namespace Drupal\search_autocomplete\Entity;

/**
 * Define what a suggestion is.
 *
 * It helps to create some extra suggestions to be inserted such as "no_result"
 * of "more_results" suggestions.
 *
 * @ConfigEntityType(
 *   id = "suggestion",
 *   label = @Translation("Autocompletion Suggestion"),
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   }
 * )
 *
 */
class Suggestion {

  /**
   * The suggestion displayed label.
   *
   * @var string
   */
  protected $label;

  /**
   * The suggestion input value: this is the value inserted in autocompleted
   * field when the suggestion is choosen.
   *
   * @var string
   */
  protected $value;

  /**
   * When auto_redirect is activated, this is the link where the user is
   * redirected when choosing the suggestion.
   *
   * @var string
   */
  protected $link;

  /**
   * Defines the SuggestionGroup the suggestion belongs to.
   *
   * @var \Drupal\search_autocomplete\SuggestionGroup
   */
  protected $group;

//   function __construct(array $values) {
//     $this->label = $values['label'];
//     $this->value = $values['value'];
//     $this->link = $values['link'];
//     $this->group = new SuggestionGroup($values['group']);
//   }

  function __construct() {
  }

  // ---------  GETTERS  ---------

  public function getLabel() {
    return $this->label;
  }
  public function getValue() {
    return $this->value;
  }
  public function getLink() {
    return $this->link;
  }
  public function getGroup() {
    return $this->group;
  }

  // ---------  SETTERS  ---------

  public function setLabel($label) {
    $this->label = $label;
  }
  public function setValue($value) {
    $this->value = $value;
  }
  public function setLink($link) {
    $this->link = $link;
  }
  public function setGroup($group) {
    $this->group = $group;
  }

}

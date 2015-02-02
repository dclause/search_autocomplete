<?php

/**
 * @file
 * Contains \Drupal\search_autocomplete\AutocompletionConfigurationInterface.
 */

namespace Drupal\search_autocomplete;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an autocompletion configuration entity.
 */
interface AutocompletionConfigurationInterface extends ConfigEntityInterface {

  // -----------------------------
  // ---------  GETTERS  ---------

  /**
   * Returns the field selector to apply the autocompletion on.
   *
   * @return string
   *   The field selector to apply the autocompletion on.
   */
  public function getSelector();

  /**
   * Returns the configuration status.
   *
   * @return boolean
   *    TRUE/FALSE depending if the configuration is set active.
  */
  public function getStatus();

  /**
   * Define how much characters needs to be entered in the field before
   * autocompletion occurs.
   *
   * @var int
  */
  public function getMinChar();

  /**
   * Returns how many suggestions should be displayed among matching suggestions
   * available.
   *
   * @return int
   *    The maximum number of suggestions to be displayed.
  */
  public function getMaxSuggestion();

  /**
   * Returns a default suggestion displayed when no results are available.
   *
   * @return \Drupal\search_autocomplete\Suggestion
   *    The default suggestion displaye when no results are available.
  */
  public function getNoResultSuggestion();

  /**
   * Returns a default suggestion displayed when more results then displayed
   * are available.
   *
   * @return \Drupal\search_autocomplete\Suggestion
   *    The default suggestion displaye when more results are available.
  */
  public function getMoreResultsSuggestion();

  // -----------------------------
  // ---------  SETTERS  ---------

  /**
   * Sets the field selector to apply the autocompletion on.
   *
   * @param string
   *   The field selector to apply the autocompletion on.
   */
  public function setSelector($selector);

  /**
   * Sets the configuration status : wheter it is active or not.
   *
   * @param boolean
   *    TRUE/FALSE depending if the configuration is set active.
  */
  public function setStatus($status);

  /**
   * Sets how many characters needs to be entered in the field before
   * autocompletion occurs.
   *
   * @param int
   *    The number of characters to enter before autocompletion starts.
  */
  public function setMinChar($minChar);

  /**
   * Sets how many suggestions should be displayed among matching suggestions
   * available.
   *
   * @param int
   *    The maximum number of suggestions to be displayed.
  */
  public function setMaxSuggestion($maxSuggestion);

  /**
   * Sets a default suggestion displayed when no results are available.
   *
   * @param \Drupal\search_autocomplete\Suggestion
   *    The default suggestion displaye when no results are available.
  */
  public function setNoResultSuggestion($noResultSuggestion);

  /**
   * Sets a default suggestion displayed when more results then displayed
   * are available.
   *
   * @param \Drupal\search_autocomplete\Suggestion
   *    The default suggestion displaye when more results are available.
  */
  public function setMoreResultsSuggestion($moreResultsSuggestion);

}

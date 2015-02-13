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
   * Returns a suggestion label displayed when no results are available.
   *
   * @return string
   *    The suggestion label displayed when no results are available.
   */
  public function getNoResultLabel();

  /**
   * Returns a suggestion value entered when "no results" is choosen.
   *
   * @return string
   *    The suggestion value entered when "no results" is choosen.
   */
  public function getNoResultValue();

  /**
   * Returns a suggestion link redirection for when no results is selected.
   *
   * @return string
   *    The link user is redirected to, when "no results" is choosen.
   */
  public function getNoResultLink();

  /**
   * Returns a suggestion label displayed when more results are available.
   *
   * @return string
   *    The suggestion label displayed when more results are available.
   */
  public function getMoreResultsLabel();

  /**
   * Returns a suggestion value entered when "more results" is choosen.
   *
   * @return string
   *    The suggestion value entered when "more results" is choosen.
   */
  public function getMoreResultsValue();

  /**
   * Returns a suggestion link redirection for when "no results" is selected.
   *
   * @return string
   *    The link user is redirected to, when "more results" is selected.
   */
  public function getMoreResultsLink();

  // -----------------------------
  // ---------  SETTERS  ---------

  /**
   * Sets the field selector to apply the autocompletion on.
   *
   * @param string $selector
   *   The field selector to apply the autocompletion on.
   */
  public function setSelector($selector);

  /**
   * Sets the configuration status : wheter it is active or not.
   *
   * @param boolean $status
   *    TRUE/FALSE depending if the configuration is set active.
   */
  public function setStatus($status);

  /**
   * Sets how many characters needs to be entered in the field before
   * autocompletion occurs.
   *
   * @param int $minChar
   *    The number of characters to enter before autocompletion starts.
   */
  public function setMinChar($minChar);

  /**
   * Sets how many suggestions should be displayed among matching suggestions
   * available.
   *
   * @param int $maxSuggestion
   *    The maximum number of suggestions to be displayed.
   */
  public function setMaxSuggestion($maxSuggestion);

  /**
   * Sets a label when no result are available.
   *
   * @param string $noResultLabel
   *    The label for "no result available" custom suggestion.
   */
  public function setNoResultLabel($noResultLabel);

  /**
   * Sets a value when no result are available.
   *
   * @param string $noResultValue
   *    The value for "no result available" custom suggestion.
   */
  public function setNoResultValue($noResultValue);

  /**
   * Sets a link when no result are available.
   *
   * @param string $noResultLink
   *    The link for "no result available" custom suggestion.
   */
  public function setNoResultLink($noResultLink);

  /**
   * Sets a label when more result are available.
   *
   * @param string $moreResultsLabel
   *    The label for "more result available" custom suggestion.
   */
  public function setMoreResultsLabel($moreResultsLabel);

  /**
   * Sets a value when more result are available.
   *
   * @param string $moreResultsValue
   *    The value for "more result available" custom suggestion.
   */
  public function setMoreResultsValue($moreResultsValue);

  /**
   * Sets a link when more result are available.
   *
   * @param string $moreResultsLink
   *    The link for "more result available" custom suggestion.
   */
  public function setMoreResultsLink($moreResultsLink);
}

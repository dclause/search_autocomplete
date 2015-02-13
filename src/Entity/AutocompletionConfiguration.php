<?php

/**
 * @file
 * Contains Drupal\search_autocomplete\Entity\AutocompletionConfiguration.
 *
 * This contains our Autocompletion Configuration config entity class. This
 * entity represents a configuration to enable autocompletion on a field.
 */

namespace Drupal\search_autocomplete\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\search_autocomplete\AutocompletionConfigurationInterface;
use Drupal\search_autocomplete\Suggestion;
use Drupal\search_autocomplete\SuggestionGroup;

/**
 * Defines the autocompletion_configuration entity.
 *
 * The lines below, starting with '@ConfigEntityType,' are a plugin annotation.
 * These define the entity type to the entity type manager.
 *
 * The properties in the annotation are as follows:
 *  - id: The machine name of the entity type.
 *  - label: The human-readable label of the entity type. We pass this through
 *    the "@Translation" wrapper so that the multilingual system may
 *    translate it in the user interface.
 *  - controllers: An array specifying controller classes that handle various
 *    aspects of the entity type's functionality. Below, we've specified
 *    controllers which can list, add, edit, and delete our autocompletion_configuration entity, and
 *    which control user access to these capabilities.
 *  - config_prefix: This tells the config system the prefix to use for
 *    filenames when storing entities. Because we don't specify, it will be
 *    the module's name. This means that the default entity we include in our
 *    module has the filename
 *    'search_autocomplete.autocompletion_configuration.xxx.yml'.
 *  - entity_keys: Specifies the class properties in which unique keys are
 *    stored for this entity type. Unique keys are properties which you know
 *    will be unique, and which the entity manager can use as unique in database
 *    queries.
 *
 * @see annotation
 * @see Drupal\Core\Annotation\Translation
 *
 * @ingroup search_autocomplete
 *
 * @ConfigEntityType(
 *   id = "autocompletion_configuration",
 *   label = @Translation("Autocompletion Configuration"),
 *   admin_permission = "administer search autocomplete",
 *   handlers = {
 *     "access" = "Drupal\search_autocomplete\AutocompletionConfigurationAccessControlHandler",
 *     "list_builder" = "Drupal\search_autocomplete\Controller\AutocompletionConfigurationListBuilder",
 *     "form" = {
 *       "add" = "Drupal\search_autocomplete\Form\AutocompletionConfigurationAddForm",
 *       "edit" = "Drupal\search_autocomplete\Form\AutocompletionConfigurationEditForm",
 *       "delete" = "Drupal\search_autocomplete\Form\AutocompletionConfigurationDeleteForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "selector" = "selector"
 *   },
 *   links = {
 *     "edit-form" = "/examples/search_autocomplete/manage/{autocompletion_configuration}",
 *     "delete-form" = "/examples/search_autocomplete/manage/{autocompletion_configuration}/delete"
 *   }
 * )
 */
class AutocompletionConfiguration extends ConfigEntityBase implements AutocompletionConfigurationInterface {

  /**
   * The autocompletion_configuration ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The autocompletion_configuration UUID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The autocompletion_configuration label.
   *
   * @var string
   */
  protected $label;

  /**
   * The field selector to apply the autocompletion on.
   *
   * @var string
   */
  protected $selector;

  /**
   * Define if the configuration is enabled, ie if the autocompletion will occur.
   *
   * @var bool
   */
  protected $status;

  /**
   * Define how much characters needs to be entered in the field before
   * autocompletion occurs.
   *
   * @var int
   */
  protected $minChar;

  /**
   * Define how much suggestions should be displayed among matching suggestions
   * available.
   *
   * @var int
   */
  protected $maxSuggestion;

  /**
   * Define a label that should be displayed when no results are available.
   *
   * @var \Drupal\search_autocomplete\Suggestion
   */
  protected $noResultLabel;
  protected $noResultValue;
  protected $noResultLink;


  /**
   * Define a label that should be displayed when more results then what can
   * be displayed are available.
   *
   * @var \Drupal\search_autocomplete\Suggestion
   */
  protected $moreResultsLabel;
  protected $moreResultsValue;
  protected $moreResultsLink;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $values, $entity_type_id = 'autocompletion_configuration') {
    parent::__construct($values, $entity_type_id);
  }


  // -----------------------------
  // ---------  GETTERS  ---------

  /**
   * {@inheritdoc}
   */
  public function getSelector() {
    return $this->selector;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function getMinChar() {
    return $this->minChar;
  }

  /**
   * {@inheritdoc}
   */
  public function getMaxSuggestion() {
    return $this->maxSuggestion;
  }

  /**
   * {@inheritdoc}
   */
  public function getNoResultLabel() {
    return $this->noResultLabel;
  }

  /**
   * {@inheritdoc}
   */
  public function getNoResultValue() {
    return $this->noResultValue;
  }

  /**
   * {@inheritdoc}
   */
  public function getNoResultLink() {
    return $this->noResultLink;
  }

  /**
   * {@inheritdoc}
   */
  public function getMoreResultsLabel() {
    return $this->moreResultsLabel;
  }

  /**
   * {@inheritdoc}
   */
  public function getMoreResultsValue() {
    return $this->moreResultsValue;
  }

  /**
   * {@inheritdoc}
   */
  public function getMoreResultsLink() {
    return $this->moreResultsLink;
  }

  // -----------------------------
  // ---------  SETTERS  ---------

  /**
   * {@inheritdoc}
   */
  public function setSelector($selector) {
    $this->selector = $selector;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->status = $status;
  }

  /**
   * {@inheritdoc}
   */
  public function setMinChar($minChar) {
    $this->minChar = $minChar;
  }

  /**
   * {@inheritdoc}
   */
  public function setMaxSuggestion($maxSuggestion) {
    $this->maxSuggestion = $maxSuggestion;
  }

  /**
   * {@inheritdoc}
   */
  public function setNoResultLabel($noResultLabel) {
    $this->noResultLabel = $noResultLabel;
  }

  /**
   * {@inheritdoc}
   */
  public function setNoResultValue($noResultValue) {
    $this->noResultValue = $noResultValue;
  }

  /**
   * {@inheritdoc}
   */
  public function setNoResultLink($noResultLink) {
    $this->noResultLink = $noResultLink;
  }

  /**
   * {@inheritdoc}
   */
  public function setMoreResultsLabel($moreResultsLabel) {
    $this->moreResultsLabel = $moreResultsLabel;
  }

  /**
   * {@inheritdoc}
   */
  public function setMoreResultsValue($moreResultsValue) {
    $this->moreResultsValue = $moreResultsValue;
  }

  /**
   * {@inheritdoc}
   */
  public function setMoreResultsLink($moreResultsLink) {
    $this->moreResultsLink = $moreResultsLink;
  }
}

<?php

/**
 * @file
 * Contains Drupal\search_autocomplete\Form\AutocompletionConfigurationEditForm.
 */

namespace Drupal\search_autocomplete\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\search_autocomplete\Suggestion;

/**
 * Class AutocompletionConfigurationEditForm
 *
 * Provides the edit form for our AutocompletionConfiguration entity.
 *
 * @package Drupal\search_autocomplete\Form
 *
 * @ingroup search_autocomplete
 */
class AutocompletionConfigurationEditForm extends AutocompletionConfigurationFormBase {

  /**
   * Returns the actions provided by this form.
   *
   * For the edit form, we only need to change the text of the submit button.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   An associative array containing the current state of the form.
   *
   * @return array
   *   An array of supported actions for the current entity form.
   */
  public function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = t('Update');
    return $actions;
  }

  /**
   * Overrides Drupal\Core\Entity\EntityFormController::form() and
   * Drupal\search_autocomplete\Form\AutocompletionConfigurationFormBase::form()
   *
   * Builds the entity add form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param array $form_state
   *   An associative array containing the current state of the form.
   *
   * @return array
   *   An associative array containing the autocompletion_configuration
   *   add/edit form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Get anything we need from the base class.
    $form = parent::buildForm($form, $form_state);

    // ------------------------------------------------------------------.
    // HOW - How to display Search Autocomplete suggestions.
    $form['search_autocomplete_how'] = array(
      '#type'           => 'details',
      '#title'          => t('HOW - How to display Search Autocomplete suggestions?'),
      '#collapsible'    => TRUE,
      '#collapsed'      => TRUE,
    );
    // Minimum characters to set autocompletion on.
    $form['search_autocomplete_how']['minChar'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Minimum keyword size that uncouple autocomplete search'),
      '#description'    => t('Please enter the minimum number of character a user must input before autocompletion starts.'),
      '#default_value'  => $this->entity->getMinChar(),
      '#maxlength'      => 2,
      '#required'       => TRUE,
    );
    // Number of suggestions to display.
    $form['search_autocomplete_how']['maxSuggestion'] = array(
      '#type'           => 'textfield',
      '#title'          => t('Limit of the autocomplete search result'),
      '#description'    => t('Please enter the maximum number of suggestion to display.'),
      '#default_value'  => $this->entity->getMaxSuggestion(),
      '#maxlength'      => 2,
      '#required'       => TRUE,
    );

    // Check if form should be auto submitted.
//     $form['search_autocomplete_how']['auto_submit'] = array(
//       '#type'           => 'checkbox',
//       '#title'          => t('Auto Submit'),
//       '#description'    => t('If enabled, the form will be submitted automatically as soon as your user choose a suggestion in the popup list.'),
//       '#default_value'  => $item->auto_submit,
//     );
    // Check if form should be auto redirected.
//     $form['search_autocomplete_how']['auto_redirect'] = array(
//       '#type'           => 'checkbox',
//       '#title'          => t('Auto Redirect'),
//       '#description'    => t('If enabled, the user will be directly routed to the suggestion he chooses instead of performing form validation process. Only works if "link" attribute is existing and if "Auto Submit" is enabled.'),
//       '#default_value'  => $item->auto_redirect,
//     );

    // ###
    // "View all results" custom configurations
    $form['search_autocomplete_how']['view_all_results'] = array(
        '#type'           => 'details',
        '#title'          => t('Custom behaviour when some suggestions are available'),
        '#collapsible'    => TRUE,
        '#collapsed'      => TRUE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['view_all_results']['all_results_label'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "view all results" message label'),
        '#description'    => t('This message is going to be displayed at the end of suggestion list when suggestions are found. Leave empty to disable this functionality. You can use HTML tags as well as the token [search-phrase] to replace user input.'),
//         '#default_value'  => $this->entity->getMoreResultsSuggestion() != null ? $this->t($this->entity->getMoreResultsSuggestion()->getLabel()) : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['view_all_results']['all_results_value'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "view all results" message value'),
        '#description'    => t('If a label is filled above, this is the value that will be picked when the message is selected. Leave empty if you don\'t want the message to be selectable. You can use the token [search-phrase] to replace user input.'),
//         '#default_value'  => $this->entity->getMoreResultsSuggestion() != null ? $this->entity->getMoreResultsSuggestion()->getValue() : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['view_all_results']['all_results_link'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "view all results" URL redirection'),
        '#description'    => t('If "Auto redirect" is checked and a label is given for this configuration, the user will be redirected to this URL when the message is selected. Leave empty if you rather like a standard Drupal search to be performed on the "value" given above.'),
//         '#default_value'  => $this->entity->getMoreResultsSuggestion() != null ? $this->entity->getMoreResultsSuggestion()->getLink() : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );

    // ###
    // "No resuls" custom configurations
    $form['search_autocomplete_how']['no_results'] = array(
        '#type'           => 'details',
        '#title'          => t('Custom behaviour when no suggestions are found'),
        '#collapsible'    => TRUE,
        '#collapsed'      => TRUE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['no_results']['no_results_label'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "no result" message label'),
        '#description'    => t('This message is going to be displayed when no suggestions can be found. Leave empty to disable this functionality. You can use HTML tags as well as the token [search-phrase] to replace user input.'),
//         '#default_value'  => $this->entity->getNoResultSuggestion() != null ? $this->t($this->entity->getMoreResultsSuggestion()->getLabel()) : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['no_results']['no_results_value'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "no result" message value'),
        '#description'    => t('If a label is filled above, this is the value that will be picked when the message is selected. Leave empty if you don\'t want the message to be selectable. You can use the token [search-phrase] to replace user input.'),
//         '#default_value'  => $this->entity->getNoResultSuggestion() != null ? $this->entity->getNoResultSuggestion()->getValue() : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );
    // Check if form should be auto submitted.
    $form['search_autocomplete_how']['no_results']['no_results_link'] = array(
        '#type'           => 'textfield',
        '#title'          => t('Custom "no result" URL redirection'),
        '#description'    => t('If "Auto redirect" is checked and a label is given for this configuration, the user will be redirected to this URL when the message is selected. Leave empty if you rather like a standard Drupal search to be performed on the "value" given above.'),
//         '#default_value'  => $this->entity->getNoResultSuggestion() != null ? $this->entity->getNoResultSuggestion()->getLink() : NULL,
        '#maxlength'      => 255,
        '#required'       => FALSE,
    );

    // ------------------------------------------------------------------.
    // WHAT - What to display in Search Autocomplete suggestions.
    $form['search_autocomplete_what'] = array(
      '#type'           => 'details',
      '#title'          => t('WHAT - What to display in Search Autocomplete suggestions?'),
      '#description'    => t('Choose which data should be added to autocompletion suggestions.'),
      '#collapsible'    => TRUE,
      '#collapsed'      => FALSE,
    );
    $form['search_autocomplete_what']['suggestions'] = array(
      '#type'           => 'item',
      '#title'          => t('Suggestion source'),
      '#description'    => t('Choose the source of suggestions to display in this form'),
    );

    // Use a callback.
    $form['search_autocomplete_what']['suggestions']['callback'] = array();
    $form['search_autocomplete_what']['callback']['callback_option'] = array(
      '#type'           => 'radio',
      '#title'          => t('Callback URL:'),
      '#return_value'   => 'callback',
//       '#default_value'  => $item->data_source,
      '#prefix'         => '<div class="form-radios">',
      '#parents'        => array('suggestions'),
    );
    $descr = t('Enter the url where to retrieve suggestions. It can be internal (absolute or relative) or external.');
    $form['search_autocomplete_what']['callback']['callback_textfield'] = array(
      '#type'           => 'textfield',
      '#description'    => $descr,
//       '#default_value'  => $item->data_source == 'callback' ? $item->data_callback : '',
      // The default size is a bit large...
      '#size'           => 80,
      // End of the "form-radios" style.
      '#suffix'        => '',
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=1]").attr("checked", true);'),
    );

    // Use static resources.
    $form['search_autocomplete_what']['suggestions']['staticresource'] = array();
    $form['search_autocomplete_what']['staticresource']['staticresource_option'] = array(
      '#type'           => 'radio',
      '#title'          => t('Static resource :'),
      '#return_value'   => 'static',
//       '#default_value'  => $item->data_source,
      '#parents'        => array('suggestions'),
    );
    $form['search_autocomplete_what']['staticresource']['staticresource_textfield'] = array(
      '#type'           => 'textarea',
      '#description'    => t('Please enter one suggestion per line. You can use the syntax: "foo => http://bar" per line if you wish to add a jumping to URL for the suggestion. Please refer to <a href="http://drupal-addict.com/nos-projets/search-autocomplete">documentation</a>.'),
//       '#default_value'  => $item->data_static,
      '#size'           => 20,
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=2]").attr("checked", true);'),
    );

    // Use a view.
    $form['search_autocomplete_what']['suggestions']['view'] = array();
    $form['search_autocomplete_what']['view']['view_option'] = array(
      '#type'           => 'radio',
      '#title'          => t('Use an existing view:'),
      '#return_value'   => 'view',
//       '#default_value'  => $item->data_source,
      '#suffix'         => '</div>',
      '#parents'        => array('suggestions'),
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=3]").attr("checked", true);'),
    );
    $form['search_autocomplete_what']['view']['view_textfield'] = array(
      '#type'           => 'textfield',
      '#description'    => t('Use autocompletion to match an eligible view.'),
//       '#default_value'  => $item->data_view,
      '#autocomplete_path' => 'views/autocomplete',
      // The default size is a bit large...
      '#size'           => 80,
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=3]").attr("checked", true);'),
    );

    // Template to use.
    $themes = array();
    $files = file_scan_directory(drupal_get_path('module', 'search_autocomplete') . '/css/themes', '/.*\.css\z/', array('recurse' => FALSE));
    foreach ($files as $file) {
      if ($file->name != 'jquery.autocomplete') {
        $themes[$file->filename] = $file->name;
      }
    }
    $form['search_autocomplete_what']['theme'] = array(
      '#type'           => 'select',
      '#title'          => t('Select a theme for your suggestions'),
      '#options'        => $themes,
//       '#default_value'  => $item->theme,
      '#description'    => t('Choose the theme to use for autocompletion dropdown popup. Read <a href="http://drupal-addict.com/nos-projets/search-autocomplete">documentation</a> to learn how to make your own.'),
    );

    // ------------------------------------------------------------------.
    // ADVANCED - Advanced options.
    $form['search_autocomplete_advanced'] = array(
      '#type'             => 'details',
      '#title'            => t('ADVANCED - Advanced options'),
      '#collapsible'      => TRUE,
      '#collapsed'        => TRUE,
    );
    $form['search_autocomplete_advanced']['selector'] = array(
      '#type'             => 'textfield',
      '#title'            => t('ID selector for this form'),
      '#description'      => t('Please change only if you know what you do, read <a href="http://drupal-addict.com/nos-projets/search-autocomplete">documentation</a> first.'),
      '#default_value'    => $this->entity->getSelector(),
      '#maxlength'        => 255,
      '#size'             => 35,
    );

    // Return the form.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $noResultSuggestion = new Suggestion();
    $noResultSuggestion->setLabel($form_state->getValue('no_results_label'));

    $this->entity->setNoResultSuggestion($noResultSuggestion);

    parent::save($form, $form_state);

  }








}

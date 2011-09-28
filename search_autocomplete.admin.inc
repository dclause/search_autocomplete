<?php

/**
 * @file
 * Search Autocomplete
 * Sets the admin part of the module: permissions, hooks, callbacks, etc...
 *
 * @authors
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 *
 * Sponsored by:
 * www.axiomcafe.fr
 */


/**
 * Implementation of hook_perm().
 * Valid permissions for this module
 * @return
 *   An array of valid permissions for the autocomplete module
 */
function search_autocomplete_perm() {
  return array(t('administer Search Autocomplete'), t('search with autocomplete'));
} // function search_autocomplete_perm()


/**
 * Implementation of hook_theme().
 * Define the function to render our forms
 */
function search_autocomplete_theme($existing, $type, $theme, $path) {
  return array(
    'search_autocomplete_treelist_form' => array(                    // register theme function for draggable treelist search forms
      'arguments' => array('form' => NULL),
    ),
    'search_autocomplete_suggestions_settings_fieldset' => array(      // register theme function for suggestions list
      'arguments' => array('form' => NULL),
    ),
  );
} // function search_autocomplete_theme($existing, $type, $theme, $path)

/**
 * Implementation of hook_menu().
 * Create an administration page to access admin form
 */
function search_autocomplete_menu() {

  // create the admin setting page: list of forms
  $items['admin/build/search_autocomplete'] = array(
    'title' => 'Search Autocomplete',
    'description' => 'Choose settings and suggestion items for autocompletion',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('search_autocomplete_treelist_form'),
    'access arguments' => array(t('administer Search Autocomplete')),
    'file' => 'search_autocomplete.form_treelist.inc',
  );
  // create the admin setting page: configure a form
  $items['admin/build/search_autocomplete/%/configure'] = array(
    'title' => 'Search Autocomplete - Configuration',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('search_autocomplete_suggestions_settings'),
    'access arguments' => array(t('administer Search Autocomplete')),
    'file' => 'search_autocomplete.suggestions_settings.inc',
    'type' => MENU_LOCAL_TASK,
  );
  // create a callback page for JSON suggestions
    $items['search_autocomplete/%/autocomplete'] = array(
    'page callback' => 'search_autocomplete_autocomplete',
    'access arguments' => array('search with autocomplete'),
    'type' => MENU_CALLBACK,
  );
  return $items;
} // function search_autocomplete_menu()
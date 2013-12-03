<?php

/**
 * @file
 * Search Autocomplete
 * Add a new form to Search Autocomplete form list.
 *
 * @author
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 *
 * Sponsored by:
 * www.axiomcafe.fr
 */

/**
 * MENU CALLBACK:
 * Define the page to add a form.
 * @return  A rendered form
 */
function search_autocomplete_form_add() {
  $form = array();
  /* ------------------------------------------------------------------ */
  $form['title'] = array(
    '#title' => t('Title'),
    '#description' => 'Please enter a title for this form',
    '#type' => 'textfield',
    '#default_value' => '',
    '#maxlength' => 255,
    '#required' => TRUE,
  );
  $descr = t('Enter a valid query selector for the form. This should be an id or a class surrounding the input box.') . '<br/>'  . t('Do not include input. In case of a doubt, refer to the <a href="http://projects.axiomcafe.fr/search-autocomplete">documentation</a>');
  $form['selector'] = array(
    '#title' => t('Selector'),
    '#description' => $descr,
    '#type' => 'textfield',
    '#default_value' => '',
    '#maxlength' => 255,
    '#required' => TRUE,
  );
  // submit buton
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );
  return $form;
}

// -------------------------------------------------------------------------------------
/**
 * Implementation of hook_submit().
 * Save the new form in database
 */
function search_autocomplete_form_add_submit($form, &$form_state) {
  $ok_query = TRUE;  // so far so good!

  // Get the form values
  $values = $form_state['values'];

  // Check if aready existing records
  $ret = db_query('SELECT * FROM {search_autocomplete_forms} WHERE title="%s" OR selector="%s"', $values['title'], $values['selector']);
  if (db_fetch_array($ret)) {
    drupal_set_message(t("The title or the selector already exists. Please choose another one."), 'error');
    return;
  }

  // Insert the new form in database
  $ok_query &= db_query('INSERT {search_autocomplete_forms} SET title = "%s", selector = "%s"', $values['title'], $values['selector']);
  $fid = db_last_insert_id('search_autocomplete_forms', 'fid');

  // redirect to configuration page
  $form_state['redirect'] = 'admin/settings/search_autocomplete/' . $fid . '/configure';

  // Give a return to the user
  $ok_query ? drupal_set_message(t('The form has been created successfully !') . '<br/>' . t('Please check its configuration.')) : drupal_set_message(t("An error has occured while creating the form. Please, double check your settings!"), 'error');
}
<?php

/**
 * @file
 * Search Autocomplete
 * Helper functions to retrive forms from database
 *
 * @author
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 *
 * Sponsored by:
 * www.axiomcafe.fr
 */

/**
 * MENU CALLBACK:
 * Define the form to configure the suggestions.
 * @return  A rendered form
 */
function search_autocomplete_form_configure() {
  $form = array();
  $base = "admin/settings/search_autocomplete";  // base URL for this module configurations
  // get data from database
  $fid = arg(3);
  $result_forms   = db_query('SELECT * FROM {search_autocomplete_forms} WHERE fid = ' . $fid);
  $item           = db_fetch_array($result_forms);

  $form['fid'] = array(
    '#type' => 'hidden',
    '#value' => $fid,
  );
  // ------------------------------------------------------------------.
  // HOW - How to display Search Autocomplete suggestions.
  $form['search_autocomplete_how'] = array(
    '#type'           => 'fieldset',
    '#title'          => t('HOW - How to display Search Autocomplete suggestions?'),
    '#collapsible'    => TRUE,
    '#collapsed'      => TRUE,
  );
  // Minimum characters to set autocompletion on.
  $form['search_autocomplete_how']['min_char'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Minimum keyword size that uncouple autocomplete search'),
    '#description'    => t('Please enter the minimum number of character a user must input before autocompletion starts.'),
    '#default_value'  => $item['min_char'],
    '#maxlength'      => 2,
    '#required'       => TRUE,
  );
  // Number of suggestions to display.
  $form['search_autocomplete_how']['max_sug'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Limit of the autocomplete search result'),
    '#description'    => t('Please enter the maximim number of suggestion to display.'),
    '#default_value'  => $item['max_sug'],
    '#maxlength'      => 2,
    '#required'       => TRUE,
  );
  // Check if form should be autosubmitted.
  $form['search_autocomplete_how']['no_results'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Behaviour when no suggestions are found'),
    '#description'    => t('Enter a message to display when no results are found. Leave empty for no message.'),
    '#default_value'  => $item['no_results'],
    '#maxlength'      => 50,
    '#required'       => FALSE,
  );
  // Check if form should be autosubmitted.
  $form['search_autocomplete_how']['auto_submit'] = array(
    '#type'           => 'checkbox',
    '#title'          => t('Auto Submit'),
    '#description'    => t('If enabled, the form will be submitted automatically as soon as your user choose a suggestion in the popup list.'),
    '#default_value'  => $item['auto_submit'],
  );
  // Check if form should be autoredirected.
  $form['search_autocomplete_how']['auto_redirect'] = array(
    '#type'           => 'checkbox',
    '#title'          => t('Auto Redirect'),
    '#description'    => t('If enabled, the user will be directly routed to the suggestion he choosed instead of performing form validation process. Only works if "link" attribute is existing and if "Auto Submit" is enabled.'),
    '#default_value'  => $item['auto_redirect'],
  );

  // ------------------------------------------------------------------.
  // WHAT - What to display in Search Autocomplete suggestions.
  $form['search_autocomplete_what'] = array(
    '#type'           => 'fieldset',
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
    '#return_value'   => 1,
    '#default_value'  => $item['data_source'] < 2 ? 1 : $item['data_source'],
    '#prefix'         => '<div class="form-radios">',
    '#parents'        => array('suggestions'),
  );
  $descr = t('Enter the url where to retrieve suggestions. It can be internal (absolute or relative) or external.') . '<br/>' .
           t('To make an easy internal suggestion url, create a view using "Autocompletion JSON" view style ! (<a href="http://projects.axiomcafe.fr/search-autocomplete/advanced-configuration/add-suggestion-type-version-3x">see documentation</a>)') . '<br/>' .
  $form['search_autocomplete_what']['callback']['callback_textfield'] = array(
    '#type'           => 'textfield',
    '#description'    => $descr,
    '#default_value'  => $item['data_callback'],
    // The default size is a bit large...
    '#size'           => 80,
    // End of the "form-radios" style.
     '#suffix'        => '',
    '#attributes'     => array('onClick' => '$("input[name=suggestions][value=1]").attr("checked", true);'),
  );

   // Use static resources
  $form['search_autocomplete_what']['suggestions']['staticresource'] = array();
  $form['search_autocomplete_what']['staticresource']['staticresource_option'] = array(
    '#type'           => 'radio',
    '#title'          => t('Static resource :'),
    '#return_value'   => 2,
    '#default_value'  => $item['data_source'] < 2 ? 1 : $item['data_source'],
    '#parents'        => array('suggestions'),
  );
  $form['search_autocomplete_what']['staticresource']['staticresource_textfield'] = array(
    '#type'           => 'textarea',
    '#description'    => t('Please enter one suggestion per line. You can use the syntax: "foo => http://bar" per line if you wish to add a jumping to URL for the suggestion. Please refer to <a href="http://projects.axiomcafe.fr/search-autocomplete">documentation</a>.'),
    '#default_value'  => $item['data_static'],
    '#size'           => 20,
    '#attributes'     => array('onClick' => '$("input[name=suggestions][value=2]").attr("checked", true);'),
  );

  // Use a view.
  $form['search_autocomplete_what']['suggestions']['view'] = array();
  $form['search_autocomplete_what']['view']['view_option'] = array(
      '#type'           => 'radio',
      '#title'          => t('Use an existing view:'),
      '#return_value'   => 3,
      '#default_value'  => $item['data_source'] < 2 ? 1 : $item['data_source'],
      '#suffix'         => '</div>',
      '#parents'        => array('suggestions'),
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=3]").attr("checked", true);'),
  );
  $form['search_autocomplete_what']['view']['view_textfield'] = array(
      '#type'           => 'textfield',
      '#description'    => t('Use autocompletion to match an eligible view.'),
      '#default_value'  => $item['data_view'],
      '#autocomplete_path' => 'views/autocomplete',
      // The default size is a bit large...
      '#size'           => 80,
      '#attributes'     => array('onClick' => '$("input[name=suggestions][value=3]").attr("checked", true);'),
  );
      
  // Template to use.
  $themes = array();
  $files = file_scan_directory(drupal_get_path('module', 'search_autocomplete') . '/css/custom_styles', '.css');
  foreach ($files as $file) {
    $themes[$file->name] = $file->name;
  }
  $form['search_autocomplete_what']['theme'] = array(
    '#type'           => 'select',
    '#title'          => t('Select a theme for your suggestions'),
    '#options'        => $themes,
    '#default_value'  => $item['theme'],
    '#description'    => t('Choose the theme to use for autocompletion dropdown popup. Read <a href="http://projects.axiomcafe.fr/search-autocomplete">documentation</a> to learn how to make your own.'),
  );

  // ------------------------------------------------------------------.
  // ADVANCED - Advanced options.
  $form['search_autocomplete_advanced'] = array(
    '#type'             => 'fieldset',
    '#title'            => t('ADVANCED - Advanced options'),
    '#collapsible'      => TRUE,
    '#collapsed'        => TRUE,
  );
  $form['search_autocomplete_advanced']['selector'] = array(
    '#type'             => 'textfield',
    '#title'            => t('ID selector for this form'),
    '#description'      => t('Please change only if you know what you do, read <a href="http://projects.axiomcafe.fr/search-autocomplete">documentation</a> first.'),
    '#default_value'    => $item['selector'],
    '#maxlength'        => 255,
    '#size'             => 35,
  );
  // Add button validation.
  $form['submit'] = array(
    '#type'             => 'submit',
    '#value'            => t('Save configuration'),
  );

  return $form;
}

// --------------------------------------------------------------------------.
/**
 * Implements hook_validate().
 *
 * Save the changes in the database.
 */
function search_autocomplete_form_configure_validate($form, &$form_state) {

  $values = $form_state['values'];
  if ($values['suggestions'] == 1) {
    $new_url = preg_replace('/\?[^=]*=[^&]*/', '', $values['callback_textfield']);
    $item = array('link_path' => $new_url);
    if (!menu_valid_path($item)) {
      form_set_error('url', t('callback url is not valid: @new_url', array('@new_url' => $new_url)));
    }
  }
}

// -------------------------------------------------------------------------------------
/**
 * Implementation of hook_submit().
 * Save the changes in the database
 */
function search_autocomplete_form_configure_submit($form, &$form_state) {
  global $base_url;

  $ok_query = TRUE;
  // Get form submission values.
  $values = $form_state['values'];

  // Analyse incoming callback.
  $callback = $values['callback_textfield'];
  // Static resource => type = 2.
  $data_type = $values['suggestions'];
  if ($data_type == 1 && $callback != '') {
    // If path is absolute:
    if (menu_path_is_external($callback)) {
      // If path is internal:
      if (strcmp(substr($callback, 0, strlen($base_url)), $base_url) === 0) {
        // Get it relative.
        $callback = str_replace($base_url . "/", "", $callback);
        $data_type = 1;
      }
      // If external: type = 0.
      else {
        $data_type = 0;
      }
    }
    // If path is not absolute:
    else {
      $data_type = 1;
    }
  }
  if ($data_type = 3) {
    $callback = 'search_autocomplete/autocomplete/' . $values['fid'] . '/';
  }

  // ###.
  // UPDATE THE FORM.
  // -> update form.
  db_query('UPDATE {search_autocomplete_forms} SET min_char=%d, max_sug=%d, auto_submit=%d, auto_redirect=%d, no_results="%s", selector="%s", data_source=%d, data_callback="%s", data_static="%s", data_view="%s", theme="%s" WHERE fid=%d',
            array($values['min_char'], $values['max_sug'], $values['auto_submit'], $values['auto_redirect'], $values['no_results'], $values['selector'], $data_type, $callback, $values['staticresource_textfield'], $values['view_textfield'], $values['theme'], $values['fid']));
  
  // ###
  // UPDATE CHILD LIST BUT NOT THE ADVANCED OPTIONS.
  $fids = _search_autocomplete_get_all_children($values['fid']);
  // Update the settings for this form + every children form.
  foreach ($fids as $fid) {
    // -> update form.
    
    db_query('UPDATE {search_autocomplete_forms} SET min_char=%d, max_sug=%d, auto_submit=%d, auto_redirect=%d, no_results="%s", theme="%s" WHERE fid=%d',
               array($values['min_char'], $values['max_sug'], $values['auto_submit'], $values['auto_redirect'], $values['no_results'], $values['theme'], $fid));
    
  }
  // ###.
  drupal_clear_css_cache();
  $form_state['redirect'] = 'admin/settings/search_autocomplete';
  $ok_query ? drupal_set_message(t("Configuration success !")) : drupal_set_message(t("An error has occured while saving the settings. Please, double check your settings!"), 'error');
}


/////////////////////////////////////////////////////////////////////////////////////////
////                             HELPER FUNCTIONS                                    ////

// -------------------------------------------------------------------------------------
/**
 * Helper function: get the array of fids every of his children of the caller but not
 * caller fid.
 */
function _search_autocomplete_get_all_children($fid, &$items = array(), $depth = 0) {
  if ($depth)
    $items[] = $fid;
  $result = db_query('SELECT * FROM {search_autocomplete_forms} WHERE parent_fid = ' . $fid);
  while ($item = db_fetch_array($result)) {
    $depth++;
    _search_autocomplete_get_all_children($item['fid'], $items, $depth);
  }
  return $items;
}
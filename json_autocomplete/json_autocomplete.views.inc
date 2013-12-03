<?php

/**
 * @file
 * Views style plugin to render view in the JSON data format adapted to Search Autocomplete.
 *
 * @see views_plugin_style_json.inc
 * @ingroup views_plugins
 * 
 * @author
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 */


/**
 * Implementation of hook_views_plugin().
 */
function json_autocomplete_views_plugins() {
  $path = drupal_get_path('module', 'json_autocomplete');
	return array(
    'module'  => 'json_autocomplete',
      'style'   => array(                 // Declare the json_autocomplete style plugin.
        'json_autocomplete'      => array(
          'title'         => ('JSON Autocomplete'),
	        'path'          => $path.'/plugin',
	        'help'          => ('Displays nodes in the JSON data format.'), 
          'handler'         => 'views_plugin_style_json',
		      'theme'           => 'views_json_autocomplete_style',
	        'theme file'      => 'views_json_autocomplete.theme.inc',
	        'theme path'      => $path.'/theme',
	        'uses row plugin' => FALSE,
          'uses fields'     => TRUE,
          'uses options'    => TRUE,
          'type'            => 'normal',
	        'help_topic'      => 'style-json',
	        'even empty'      => TRUE
      ),
    ),
  );
}
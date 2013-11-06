<?php

/**
 * @file
 * Views theme to render view fields as JSON.
 *
 * - $view: The view in use.
 * - $rows: Array of row objects as rendered by
 * _search_autocomplete_render_fields
 * - $options: The options for the style passed in from the UI.
 *
 * @ingroup views_templates
 * @see search_autocomplete.views.inc
 */
 

function template_preprocess_views_search_autocomplete_style(&$vars) {
  global $base_root;

  $view = $vars['view'];
  $rows = $vars['rows'];
  $style_options = $vars['options'];
  
  $arg = '';
  if (array_key_exists(0, $view->args)) {
    $arg = $view->args[0] ? $view->args[0] : '';
  }

  $objects = array();

  $vars['bitmask'] = NULL;

  $should_translite = search_autocomplete_get_translite();
    
  foreach ($rows as $row) {
    
    $object = array();   
    
    /* ----------------
     * Build the link...
     * ----------------  */
     
    // Extract the URL...
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
    if (preg_match("/$regexp/siU", htmlspecialchars_decode($row[$style_options['input_link']]->content, ENT_QUOTES), $matches)) {
      $link = $base_root . $matches[2];
      // And build the link object.
      $object['link'] = $link;
    }
    
    /* ----------------
     * Build the value...
     * ----------------  */
    $object['value'] = $row[$style_options['input_value']]->raw;
    
    /* ----------------
     * Build the array of output fields...
     * ----------------  */
    $object['fields'] = array();
    foreach ($style_options['output_fields'] as $field_name) {
      // Add the field if the value is not null.
      if (array_key_exists($field_name, $row) && $row[$field_name] && $row[$field_name]->content) {
        $object['fields'][$field_name] = $row[$field_name]->label . ' ' . $row[$field_name]->content;
      }
    }
    
    $objects[] = $object;
  }

  // Check if user wants nested arrays.
  $vars["rows"] = $objects;
}

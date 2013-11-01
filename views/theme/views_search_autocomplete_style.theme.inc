<?php

/**
 * @file
 * Views theme to render view fields as JSON.
 *
 * - $view: The view in use.
 * - $rows: Array of row objects as rendered by
 * _search_autocomplete_render_fields
 * - $attachment: Not used currently
 *
 * @ingroup views_templates
 * @see search_autocomplete.views.inc
 */
 

function template_preprocess_views_search_autocomplete_style(&$vars) {
  global $base_root;

  $view = $vars['view'];
  $rows = $vars['rows'];
  $style_options = $view->style_options;
  
  //dpm($view);
  dpm($style_options);
  
  $arg = '';
  if (array_key_exists(0, $view->args)) {
    $arg = $view->args[0] ? $view->args[0] : '';
  }

  $objects = array();

  $vars['bitmask'] = NULL;

  $should_translite = search_autocomplete_get_translite();

   dpm('rows:');
   dpm($rows);
    
  foreach ($rows as $row) {
  
    dpm('row:');
    dpm($row);
    
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
    $object['output_fields'] = array();
    foreach ($style_options['output_fields'] as $field_name) {
      $object['output_fields'][] = $row[$field_name]->content;
    }
    
    
    $object['label'] = "truc";
      // $value = $field->raw;
      // // Hack to romanize accents, this needs module transliteration enabled.
      // if (function_exists('transliteration_get') && $should_translite) {
        // $romanised = transliteration_get($value, '?', language_default('language'));
      // }
      // else {
        // $romanised = $value;
      // }
      
      // // Compare both $value and $romanised.
      // if ($arg == '' || mb_stripos($value, $arg, 0, 'UTF-8')  !== FALSE || mb_stripos( $romanised, $arg, 0, 'UTF-8')  !== FALSE ) {

        // $label = "";
        // if ($field->label) {
          // $label = strip_tags($field->label);
        // }

        // $object['link']  = $link;
        // $object['label'] = $label . $value;
        
        // $object['value'] = $romanised;

        // $objects[] = $object;

      // }
    $objects[] = $object;
  }

  // Check if user wants nested arrays.
  $vars["rows"] = $objects;
}

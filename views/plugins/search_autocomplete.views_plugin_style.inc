<?php
/**
 * @file
 * Implements views_plugin_style for search_autocomplete
 */

/**
 * Implements views_plugin_style
 */
class search_autocomplete_views_plugin_style extends views_plugin_style {
  /**
   * Implements views_plugin_style::option_definition
   */
  function option_definition() {
    $options = parent::option_definition();
    $options['input_label'] = array('default' => 'field-name');
    $options['input_link'] = array('default' => 'field-name');
    return $options;
  }

  /**
   * Provide a form for setting options.
   */
  function options_form(&$form, &$form_state) {

    $this->view->init_handlers();

    // Get the all views fields.
    $field_label_options = $this->display->handler->get_field_labels();
    $form['input_value'] = array(
      '#title'          => t('Input Value'),
      '#type'           => 'select',
      '#description'    => (empty($field_label_options) ? '<b>' . t('Warning') . ': </b> ' . 'Requires at least one field in the view.' . '<br/>' : '')
                            . t('Select the autocompletion input value. If the autocompletion settings are set to auto-submit, this value will be submitted as the suggestion is selected.'),
      '#default_value'  => $this->options['input_value'],
      '#disabled'       => empty($field_label_options),
      '#required'       => TRUE,
      '#options'        => $field_label_options,
    );

    // Get all views fields with "link to its node" option to true
    $fields = $this->view->display['default']->display_options['fields'];
    $field_link_options = $this->search_autocomplete_parse_fields($fields, 'link_to_node');
    $form['input_link'] = array(
      '#title'          => t('Input Link'),
      '#type'           => 'select',
      '#description'    => (empty($field_link_options) ? '<b>' . t('Warning') . ': </b> ' . 'Requires at least one field to be linked to its piece of content.' . '<br/>' : '')
                            . t('Select the autocompletion input link. If the autocompletion settings are set to auto-redirect, this link is where the user will be redirected as the suggestion is selected.'),
      '#default_value'  => $this->options['input_link'],
      '#disabled'       => empty($field_link_options),
      '#required'       => TRUE,
      '#options'        => $field_link_options,
    );
  }

  /**
   * Implements view_style_plugin::theme_functions(). Returns an array of theme functions to use
   * for the current style plugin
   * @return array
   */
  function theme_functions() {
    $hook = 'views_search_autocomplete_style';
    return views_theme_functions($hook, $this->view, $this->display);
  }

  /**
   * Implements views_style_plugin::additional_theme_functions(). Returns empty array.
   * @return array
   */
  function additional_theme_functions() {
    return array();
  }

  /**
   * Implements view_style_plugin::render()
   */
  function render() {
    $view = $this->view;
    $options = $this->options;

    $rows = array();
    foreach ($view->result as $count => $row) {
      $view->row_index = $count;
      $rows[] = _search_autocomplete_render_fields($view, $row);
    }
    unset($view->row_index);

    return theme($this->theme_functions(), array('view' => $view, 'options' => $options, 'rows' => $rows));
  }


  // ADDITIONNAL HELPER FUNCTIONS

  /**
   * This function parse a field definition to look for a particular
   * option within.
   * @param fields  an array of the fields
   * @property the property to look for
   * @value     the value to restrict to
   */
  function search_autocomplete_parse_fields($fields, $property, $value = TRUE) {
    // get all fields label
    $labels = $this->display->handler->get_field_labels();
    $parsed_fields = array();

    foreach ($fields as $id => $field) {      // for each fields
      if (isset($field[$property]) && $field[$property] == $value) {        // if we find the property value we need..
        $parsed_fields[$id] = $labels[$id];       // we take that particular field
      }
    }
    return $parsed_fields;
  }
}

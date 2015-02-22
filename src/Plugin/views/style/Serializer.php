<?php

/**
 * @file
 * Contains \Drupal\search_autocomplete\Plugin\views\style\Serializer.
 */

namespace Drupal\search_autocomplete\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\ViewExecutable;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Drupal\Component\Utility\String;

/**
 * The style plugin for serialized output formats.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "serializer",
 *   title = @Translation("Serializer"),
 *   help = @Translation("Serializes views row data using the Serializer component."),
 *   display_types = {"callback"}
 * )
 */
class Serializer extends StylePluginBase {

  /**
   * Overrides \Drupal\views\Plugin\views\style\StylePluginBase::$usesRowPlugin.
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Overrides Drupal\views\Plugin\views\style\StylePluginBase::$usesFields.
   */
  protected $usesGrouping = TRUE;

  /**
   * The serializer which serializes the views result.
   *
   * @var \Symfony\Component\Serializer\Serializer
   */
  protected $serializer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('serializer'),
      $container->getParameter('serializer.formats')
    );
  }

  /**
   * Constructs a Plugin object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, SerializerInterface $serializer, array $serializer_formats) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->definition = $plugin_definition + $configuration;
    $this->serializer = $serializer;
    $this->formats = $serializer_formats;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    // Unset unecessary configurations
    unset($form['grouping']['0']['rendered']);
    unset($form['grouping']['0']['rendered_strip']);
    unset($form['grouping']['0']['rendered_strip']);
    unset($form['grouping']['1']);

    // Add custom options.
    $field_labels = $this->displayHandler->getFieldLabels(TRUE);

    // Build the input field option.
    $input_label_descr = (empty($field_labels) ? '<b>' . t('Warning') . ': </b> ' . t('Requires at least one field in the view.') . '<br/>' : '') . t('Select the autocompletion input value. If the autocompletion settings are set to auto-submit, this value will be submitted as the suggestion is selected.');
    $form['input_label'] = array(
        '#title'          => t('Input Label'),
        '#type'           => 'select',
        '#description'    => String::checkPlain($input_label_descr),
        '#default_value'  => $this->options['input_label'],
        '#disabled'       => empty($field_labels),
        '#required'       => TRUE,
        '#options'        => $field_labels,
    );

    // Build the link field option.
    $input_link_descr = (empty($field_labels) ? '<b>' . t('Warning') . ': </b> ' . t('Requires at least one field in the view.') . '<br/>' : '') . t('Select the autocompletion input link. If the autocompletion settings are set to auto-redirect, this link is where the user will be redirected as the suggestion is selected.');
    $form['input_link'] = array(
        '#title'          => t('Input Link'),
        '#type'           => 'select',
        '#description'    => String::checkPlain($input_link_descr),
        '#default_value'  => $this->options['input_link'],
        '#disabled'       => empty($field_labels),
        '#required'       => TRUE,
        '#options'        => $field_labels,
    );

    // Build the link option.
//     $output_field_descr = (empty($field_labels) ? '<b>' . t('Warning') . ': </b> ' . t('Requires at least one field in the view.') . '<br/>' : '') . t("Select the autocompletion output values. Thoses fields are the one that will show in the autocompletion popup suggestion list. This may be, the username and picture for instance, or the node title and it's author.");
//     $form['output_fields'] = array(
//         '#title'          => t('Output Fields'),
//         '#type'           => 'select',
//         '#description'    => String::checkPlain($output_field_descr),
//         '#default_value'  => $this->options['output_fields'],
//         '#disabled'       => empty($field_labels),
//         '#required'       => TRUE,
//         '#multiple'       => TRUE,
//         '#options'        => $field_labels,
//     );
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    // Group the rows according to the grouping instructions, if specified.
    $groups = $this->renderGrouping(
        $this->view->result,
        $this->options['grouping'],
        TRUE
    );

    return $this->serializer->serialize($groups, 'json');
  }

  /**
   * {@inheritdoc}
   */
  public function renderGrouping($records, $groupings = array(), $group_rendered = NULL) {

    $rows = array();
    $groups = array();

    // Iterate through all records for transformation.
    foreach ($records as $index => $row) {

      // Render the row according to our custom needs.
      $rendered_row = $this->view->rowPlugin->render($row);

      // Case when it takes grouping.
      if ($groupings) {

        // Iterate through configured grouping field.
        // Currently only one level of grouping allowed.
        foreach ($groupings as $info) {

          $field_type = $info['field'];
          $group_id = '';
          $group_content = '';

          // Extract group data if available.
          if (isset($this->view->field[$field_type])) {
            // Extract group_id and transform it to machine name
            $group_id = strtolower(str_replace(' ', '-', $this->getField($index, $field_type)));
            // Extract group displayed value.
            $group_content = $rendered_row[$field_type];
          }

          // Create the group if it does not exist yet.
          if (empty($groups[$group_id])) {
            $groups[$group_id]['group'] = $group_content;
            $groups[$group_id]['rows'] = array();
          }

          // Move the set reference into the row set of the group we just determined.
          $rows = &$groups[$group_id]['rows'];
        }
      } else {
        // Create the group if it does not exist yet.
        if (empty($groups[''])) {
          $groups['']['group'] = '';
          $groups['']['rows'] = array();
        }
        $rows = &$groups['']['rows'];
      }
      // Add the row to the hierarchically positioned row set we just determined.
      $rows[] = $rendered_row;
    }

    // If this parameter isn't explicitely set modify the output to be fully
    // backward compatible to code before Views 7.x-3.0-rc2.
    // @TODO Remove this as soon as possible e.g. October 2020
    if ($group_rendered === NULL) {
      $old_style_groups = array();
      foreach ($groups as $group) {
        $old_style_groups[$group['group']] = $group['rows'];
      }
      $groups = $old_style_groups;
    }

    return $groups;
  }

}

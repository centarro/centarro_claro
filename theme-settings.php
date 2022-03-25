<?php

/**
 * @file
 * Functions to support Centarro Claro theme settings.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for system_theme_settings.
 */
function centarro_claro_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
  $form['centarro_claro']['centarro_claro_utilities'] = [
    '#type' => 'fieldset',
    '#title' => t('Centarro Claro Utilities'),
  ];
  $form['centarro_claro']['centarro_claro_utilities']['theme_size'] = [
    '#type' => 'select',
    '#title' => t('Theme size:'),
    '#options' => [
      'default' => t('Default (Claro)'),
      'medium' => t('Medium'),
      'compact' => t('Compact'),
    ],
    '#description' => ('This changes the root font size and resizes all theme elements.'),
    '#default_value' => theme_get_setting('theme_size'),
  ];
}

<?php

/**
 * @file
 * Functions to support Centarro Claro theme settings.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for system_theme_settings.
 */
function centarro_claro_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL)
{

  $form['#attached']['library'][] = 'centarro_claro/color-picker';

  // @TODO: Replace this
  // \Drupal::service('theme.manager')->getActiveTheme()

  $colors = [
    'centarro_claro_primary_color' => 'Primary color',
    'centarro_claro_focus_color' => 'Focus color',
  ];

  $color_themes = [
    'default' => [
      'label' => 'Centarro Purple',
      'colors' => [
        'centarro_claro_primary_color' => '#4b4e9f',
        'centarro_claro_focus_color' => '#ffa827',
      ],
    ],
    'b&w' => [
      'label' => 'Black and White',
      'colors' => [
        'centarro_claro_primary_color' => '#000000',
        'centarro_claro_focus_color' => '#000000',
      ],
    ],
  ];

  $form['#attached']['drupalSettings']['centarroClaro']['colorSchemes'] = $color_themes;

  // General "alters" use a form id. Settings should not be set here. The only
  // thing useful about this is if you need to alter the form for the running
  // theme and *not* the theme setting.
  // @see http://drupal.org/node/943212
  if (isset($form_id)) {
    return;
  }

  // Change collapsible fieldsets (now details) to default #open => FALSE.
  $form['theme_settings']['#open'] = FALSE;
  $form['logo']['#open'] = FALSE;
  $form['favicon']['#open'] = FALSE;

  // Utilitie details wrapper
  $form['centarro_claro_utilities'] = [
    '#type' => 'details',
    '#title' => t('Centarro Claro Utilities'),
    '#weight' => -10,
    '#collapsible' => TRUE,
    '#open' => TRUE,
  ];

  // Colors
  $form['centarro_claro_utilities']['centarro_claro_enable_color'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable color Scheme'),
    '#default_value' => theme_get_setting('centarro_claro_enable_color'),
    '#ajax' => [
      'callback' => 'colorCallback',
      'wrapper' => 'color_container',
    ],
  ];

  $form['centarro_claro_utilities']['color_container'] = [
    '#type' => 'container',
    '#attributes' => [
      'id' => 'color_container'
    ],
  ];

  if ($form_state->getValue('centarro_claro_enable_color', theme_get_setting('centarro_claro_enable_color'))) {
    $form['centarro_claro_utilities']['color_container']['centarro_claro_color_scheme'] = [
      '#type' => 'select',
      '#title' => t('Default Color Scheme'),
      '#empty_option' => t('Custom'),
      '#empty_value' => '',
      '#options' => [
        'default' => t('Default'),
        'b&w' => t('Black and White'),
      ],
      '#input' => FALSE,
      '#wrapper_attributes' => [
        'style' => 'display:none;',
      ],
    ];

    foreach ($colors as $key => $title) {
      $form['centarro_claro_utilities']['color_container'][$key] = [
        '#type' => 'textfield',
        '#maxlength' => 7,
        '#size' => 10,
        '#title' => t($title),
        '#description' => t('Enter color in full hexadecimal format (#abc123).') . '<br/>' . t('Derivatives will be formed from this color.'),
        '#default_value' => theme_get_setting($key),
        '#attributes' => [
          'pattern' => '^#[a-fA-F0-9]{6}',
        ],
        '#wrapper_attributes' => [
          'data-drupal-selector' => 'centarro-claro-color-picker',
        ],
      ];
    }
  }


  // Fonts/theme size
  $form['centarro_claro_utilities']['theme_size'] = [
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

  // Other.
}

/**
 * @param $form
 * @param FormStateInterface $form_state
 * @return mixed
 */
function colorCallback($form, FormStateInterface $form_state) {
  return $form['centarro_claro_utilities']['color_container'];
}

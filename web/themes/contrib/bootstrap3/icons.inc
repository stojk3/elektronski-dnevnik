<?php

/**
 * @file
 * Icon API support to provide Bootstrap Framework glyphicons.
 */

use Drupal\bootstrap3\Bootstrap;

/**
 * Implements hook_icon_providers().
 */
function bootstrap3_icon_providers() {
  $providers['bootstrap3'] = [
    'title' => t('Bootstrap 3'),
    'url' => 'https://getbootstrap.com/docs/3.4/components/#glyphicons',
  ];
  return $providers;
}

/**
 * Implements hook_icon_bundles().
 */
function bootstrap3_icon_bundles() {
  $bundles = [];
  if (Bootstrap::getTheme()->hasGlyphicons()) {
    $bundles['bootstrap3'] = [
      'render' => 'sprite',
      'provider' => 'bootstrap3',
      'title' => t('Bootstrap 3'),
      'version' => t('Icons by Glyphicons'),
      'variations' => [
        'icon-white' => t('White'),
      ],
      'settings' => [
        'tag' => 'span',
      ],
      'icons' => Bootstrap::glyphicons(),
    ];
  }
  return $bundles;
}

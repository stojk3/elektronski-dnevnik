/**
 * @file
 * Bootstrap behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.bootstrapBootstrapPreInit = {
    attach (context, settings) {
      if (jQuery === 'undefined')
        jQuery = $;
    }
  };

} (Drupal));

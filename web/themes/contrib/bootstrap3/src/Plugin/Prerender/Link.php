<?php

namespace Drupal\bootstrap3\Plugin\Prerender;

use Drupal\bootstrap3\Bootstrap;
use Drupal\bootstrap3\Utility\Element;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Pre-render callback for the "link" element type.
 *
 * @ingroup plugins_prerender
 *
 * @BootstrapPrerender("link",
 *   action = @BootstrapConstant(
 *     "\Drupal\bootstrap3\Bootstrap::CALLBACK_PREPEND"
 *   )
 * )
 *
 * @see \Drupal\Core\Render\Element\Link::preRenderLink()
 */
class Link extends PrerenderBase {

  /**
   * {@inheritdoc}
   */
  public static function preRenderElement(Element $element) {
    // Injects the icon into the title (the only way this is possible).
    if ($icon = &$element->getProperty('icon')) {
      $title = $element->getProperty('title');

      // Handle #icon_only.
      if ($element->getProperty('icon_only')) {
        if ($attribute_title = $element->getAttribute('title', '')) {
          $title .= ' - ' . $attribute_title;
        }
        $element
          ->setAttribute('title', $title)
          ->addClass('icon-only')
          ->setProperty('title', $icon);
        if (Bootstrap::getTheme()->getSetting('tooltip_enabled')) {
          $element->setAttribute('data-toggle', 'tooltip');
        }
        return;
      }

      // Handle #icon_position.
      $position = $element->getProperty('icon_position', 'before');

      // Render #icon and trim it (so it doesn't add underlines in whitespace).
      $rendered_icon = trim(Element::create($icon)->renderPlain());

      // Default position is before.
      $markup = "$rendered_icon@title";
      if ($position === 'after') {
        $markup = "@title$rendered_icon";
      }

      // Replace the title and set an icon position class.
      $element
        ->setProperty('title', new FormattableMarkup($markup, ['@title' => $title]))
        ->addClass("icon-$position");
    }
  }

}

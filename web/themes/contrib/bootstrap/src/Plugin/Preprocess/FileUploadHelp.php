<?php

namespace Drupal\bootstrap\Plugin\Preprocess;

use Drupal\bootstrap\Bootstrap;
use Drupal\bootstrap\Utility\Variables;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldFilteredMarkup;
use Drupal\Core\Url;

/**
 * Pre-processes variables for the "file_upload_help" theme hook.
 *
 * @ingroup plugins_preprocess
 *
 * @BootstrapPreprocess("file_upload_help",
 *   replace = "template_preprocess_file_upload_help"
 * )
 */
class FileUploadHelp extends PreprocessBase implements PreprocessInterface {

  /**
   * {@inheritdoc}
   */
  public function preprocessVariables(Variables $variables) {
    if (!empty($variables['description'])) {
      $variables['description'] = FieldFilteredMarkup::create($variables['description']);
    }

    $descriptions = [];

    $cardinality = $variables['cardinality'];
    if (isset($cardinality)) {
      if ($cardinality == -1) {
        $descriptions[] = t('Unlimited number of files can be uploaded to this field.');
      }
      else {
        $descriptions[] = \Drupal::translation()->formatPlural($cardinality, 'One file only.', 'Maximum @count files.');
      }
    }

    $upload_validators = $variables['upload_validators'];
    $unformatted_size = NULL;
    if (isset($upload_validators['FileSizeLimit'])) {
      $unformatted_size = $upload_validators['FileSizeLimit']['fileLimit'];
    }
    // @todo The following condition maintains backward compatibility for
    // versions of Drupal Core older than 10.2.0. Remove it when 10.1.x becomes
    // unsupported.
    elseif (isset($upload_validators['file_validate_size'])) {
      $unformatted_size = $upload_validators['file_validate_size'][0];
    }
    if ($unformatted_size) {
      $descriptions[] = t('@size limit.', [
        '@size' => \Drupal\Component\Utility\DeprecationHelper::backwardsCompatibleCall(\Drupal::VERSION, '10.2.0', fn() => \Drupal\Core\StringTranslation\ByteSizeMarkup::create($unformatted_size), fn() => format_size($unformatted_size)),
      ]);
    }
    $unformatted_extensions = NULL;
    if (isset($upload_validators['FileExtension'])) {
      $unformatted_extensions = $upload_validators['FileExtension']['extensions'];
    }
    if ($unformatted_extensions) {
      $extensions = new FormattableMarkup('<code>@extensions</code>', [
        '@extensions' => implode(', ', explode(' ', $unformatted_extensions)),
      ]);
      $descriptions[] = t('Allowed types: @extensions.', [
        '@extensions' => $extensions,
      ]);
    }

    $max = NULL;
    $min = NULL;
    if (isset($upload_validators['FileImageDimensions'])) {
      $max = $upload_validators['FileImageDimensions']['maxDimensions'];
      $min = $upload_validators['FileImageDimensions']['minDimensions'];
    }
    if ($max || $min) {
      if ($min && $max && $min == $max) {
        $descriptions[] = t('Images must be exactly <strong>@size</strong> pixels.', ['@size' => $max]);
      }
      elseif ($min && $max) {
        $descriptions[] = t('Images must be larger than <strong>@min</strong> pixels. Images larger than <strong>@max</strong> pixels will be resized.', ['@min' => $min, '@max' => $max]);
      }
      elseif ($min) {
        $descriptions[] = t('Images must be larger than <strong>@min</strong> pixels.', ['@min' => $min]);
      }
      elseif ($max) {
        $descriptions[] = t('Images larger than <strong>@max</strong> pixels will be resized.', ['@max' => $max]);
      }
    }

    $variables['descriptions'] = $descriptions;

    if ($descriptions && $this->theme->getSetting('popover_enabled')) {
      $build = [];
      $id = Html::getUniqueId('upload-instructions');
      $build['toggle'] = [
        '#type' => 'link',
        '#title' => t('Upload requirements'),
        '#url' => Url::fromUserInput("#$id"),
        '#icon' => Bootstrap::glyphicon('question-sign'),
        '#attributes' => [
          'class' => ['icon-before'],
          'data-toggle' => 'popover',
          'data-html' => 'true',
          'data-placement' => 'bottom',
          'data-title' => t('Upload requirements'),
        ],
      ];
      $build['requirements'] = [
        '#type' => 'container',
        '#theme_wrappers' => ['container__file_upload_help'],
        '#attributes' => [
          'id' => $id,
          'class' => ['hidden', 'help-block'],
          'aria-hidden' => 'true',
        ],
      ];
      $build['requirements']['descriptions'] = [
        '#theme' => 'item_list__file_upload_help',
        '#items' => $descriptions,
      ];
      $variables['popover'] = $build;
    }
  }

}

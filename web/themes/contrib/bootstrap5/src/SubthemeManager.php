<?php

namespace Drupal\bootstrap5;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Bootstrap5 subtheme manager.
 */
class SubthemeManager {

  use StringTranslationTrait;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The theme extension list.
   *
   * @var \Drupal\Core\Extension\ThemeExtensionList
   */
  protected $themeExtensionList;

  /**
   * SubthemeManager constructor.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   * @param \Drupal\Core\Extension\ThemeExtensionList $them_extension_list
   *   The theme extension list.
   */
  public function __construct(FileSystemInterface $file_system, MessengerInterface $messenger, ThemeExtensionList $them_extension_list) {
    $this->fileSystem = $file_system;
    $this->messenger = $messenger;
    $this->themeExtensionList = $them_extension_list;
  }

  /**
   * Validate the subtheme's main values.
   *
   * @param string|null $subtheme_folder
   *   The subtheme folder.
   * @param string|null $subtheme_machine_name
   *   The subtheme machine name.
   *
   * @return array|null
   *   The error message.
   */
  public function validateSubtheme(?string $subtheme_folder, ?string $subtheme_machine_name): ?array {
    // Check for empty values.
    if (!$subtheme_folder) {
      return [
        'subtheme_folder',
        $this->t('Subtheme folder is empty.'),
      ];
    }
    if (!$subtheme_machine_name) {
      return [
        'subtheme_machine_name',
        $this->t('Subtheme machine name is empty.'),
      ];
    }

    // Check for path trailing slash.
    if (strrev(trim($subtheme_folder))[0] === '/') {
      return [
        'subtheme_folder',
        $this->t('Subtheme folder should be without trailing slash.'),
      ];
    }
    // Check for name validity.
    if (!$subtheme_machine_name) {
      return [
        'subtheme_machine_name',
        $this->t('Subtheme name format is incorrect.'),
      ];
    }

    // Check for writable path.
    $directory = DRUPAL_ROOT . '/' . $subtheme_folder;
    if ($this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS) === FALSE) {
      return [
        'subtheme_folder',
        $this->t('Subtheme cannot be created. Check permissions.'),
      ];
    }
    // Check for common theme names.
    if (in_array($subtheme_machine_name, [
      'bootstrap', 'bootstrap4', 'bootstrap5', 'claro', 'bartik', 'seven',
    ])) {
      return [
        'subtheme_machine_name',
        $this->t('Subtheme name should not match existing themes.'),
      ];
    }

    // Check for reserved terms.
    if (in_array($subtheme_machine_name, [
      'src', 'lib', 'vendor', 'assets', 'css', 'files', 'images', 'js', 'misc', 'templates', 'includes', 'fixtures', 'Drupal',
    ])) {
      return [
        'subtheme_machine_name',
        $this->t('Subtheme name should not match reserved terms.'),
      ];
    }
    // Validate machine name to ensure correct format.
    if (!preg_match("/^[a-z]+[0-9a-z_]+$/", $subtheme_machine_name)) {
      return [
        'subtheme_machine_name',
        $this->t('Subtheme machine name format is incorrect.'),
      ];
    }
    // Check machine name is not longer than 50 characters.
    if (strlen($subtheme_machine_name) > 50) {
      return [
        'subtheme_folder',
        $this->t('Subtheme machine name must not be longer than 50 characters.'),
      ];
    }

    // Check for writable path.
    $themePath = $directory . '/' . $subtheme_machine_name;
    if (file_exists($themePath)) {
      return [
        'subtheme_machine_name',
        $this->t('Folder already exists.'),
      ];
    }

    return NULL;
  }

  /**
   * Create a bootstrap 5 subtheme.
   *
   * @param string $subtheme_machine_name
   *   The subtheme machine name.
   * @param string $subtheme_folder
   *   The subtheme folder.
   * @param string $subtheme_name
   *   The subtheme name.
   */
  public function createSubtheme(string $subtheme_machine_name, string $subtheme_folder, string $subtheme_name): void {
    $fs = $this->fileSystem;

    $themePath = DRUPAL_ROOT . DIRECTORY_SEPARATOR . $subtheme_folder . DIRECTORY_SEPARATOR . $subtheme_machine_name;
    if (!is_dir($themePath)) {
      // Copy CSS file replace empty one.
      $subfolders = ['css'];
      foreach ($subfolders as $subfolder) {
        $directory = $themePath . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR;
        $fs->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);

        $files = $fs->scanDirectory(
          $this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR, '/.*css/', [
            'recurse' => FALSE,
          ]);
        foreach ($files as $file) {
          $fileName = $file->filename;
          $fs->copy(
            $this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR . $fileName,
            $themePath . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR . $fileName, TRUE);
        }
      }

      // Copy image files.
      $files = [
        'favicon.ico',
        'logo.svg',
        'screenshot.png',
      ];
      foreach ($files as $fileName) {
        $fs->copy($this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . $fileName,
          $themePath . DIRECTORY_SEPARATOR . $fileName, TRUE);
      }

      // Copy files and rename content (array of lines of copy existing).
      $files = [
        'bootstrap5.breakpoints.yml' => -1,
        'bootstrap5.libraries.yml' => [
          'global-styling:',
          '  css:',
          '    theme:',
          '      css/style.css: {}',
          '',
        ],
        'bootstrap5.theme' => [
          '<?php',
          '',
          '/**',
          ' * @file',
          ' * ' . $subtheme_name . ' theme file.',
          ' */',
          '',
        ],
        'README.md' => [
          '# ' . $subtheme_name . ' theme',
          '',
          '[Bootstrap 5](https://www.drupal.org/project/bootstrap5) subtheme.',
          '',
          '## Development.',
          '',
          '### CSS compilation.',
          '',
          'Prerequisites: install [sass](https://sass-lang.com/install).',
          '',
          'To compile, run from subtheme directory: `sass scss/style.scss css/style.css && sass scss/ck5style.scss css/ck5style.css`',
          '',
        ],
      ];

      foreach ($files as $fileName => $lines) {
        // Get file content.
        $content = str_replace('bootstrap5', $subtheme_machine_name, file_get_contents($this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . $fileName));
        if (is_array($lines)) {
          $content = implode(PHP_EOL, $lines);
        }
        file_put_contents($themePath . DIRECTORY_SEPARATOR . str_replace('bootstrap5', $subtheme_machine_name, $fileName),
          $content);
      }

      // Info yml file generation.
      $infoYml = Yaml::decode(file_get_contents($this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . 'bootstrap5.info.yml'));
      $infoYml['name'] = $subtheme_name;
      $infoYml['description'] = $subtheme_name . ' subtheme based on Bootstrap 5 theme.';
      $infoYml['base theme'] = 'bootstrap5';

      $infoYml['libraries'] = [];
      $infoYml['libraries'][] = $subtheme_machine_name . '/global-styling';
      $infoYml['libraries-override'] = [
        'bootstrap5/global-styling' => FALSE,
      ];

      foreach ([
        'version',
        'project',
        'datestamp',
        'starterkit',
        'generator',
        'libraries-extend',
      ] as $value) {
        if (isset($infoYml[$value])) {
          unset($infoYml[$value]);
        }
      }

      file_put_contents($themePath . DIRECTORY_SEPARATOR . $subtheme_machine_name . '.info.yml',
        Yaml::encode($infoYml));

      // SCSS files generation.
      $scssPath = $themePath . DIRECTORY_SEPARATOR . 'scss';
      $b5ScssPath = $this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . 'scss' . DIRECTORY_SEPARATOR;
      $fs->prepareDirectory($scssPath, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);

      $files = [
        'style.scss' => [
          "// Sub theme styling.",
          "@import 'variables_drupal';",
          '',
          "// Bootstrap overridden variables.",
          "// @see https://getbootstrap.com/docs/5.2/customize/sass/#variable-defaults.",
          "@import 'variables_bootstrap';",
          '',
          "// Include bootstrap.",
          "@import '" .
          str_repeat('../', count(explode(DIRECTORY_SEPARATOR, $subtheme_folder)) + 2) .
          $this->themeExtensionList->getPath('bootstrap5') . "/scss/style';",
          '',
        ],
        'ck5style.scss' => $b5ScssPath . 'ck5style.scss',
        '_variables_drupal.scss' => $b5ScssPath . '_variables_drupal.scss',
        '_variables_bootstrap.scss' => $b5ScssPath . '_variables_bootstrap.scss',
      ];

      foreach ($files as $fileName => $lines) {
        // Get file content.
        if (is_array($lines)) {
          $content = implode(PHP_EOL, $lines);
          file_put_contents($scssPath . DIRECTORY_SEPARATOR . $fileName, $content);
        }
        elseif (is_string($lines)) {
          $fs->copy($lines, $scssPath . DIRECTORY_SEPARATOR . $fileName, TRUE);
        }
      }

      // Add block config to subtheme.
      $orig_config_path = $this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . 'config/optional';
      $config_path = $themePath . DIRECTORY_SEPARATOR . 'config/optional';
      $files = scandir($orig_config_path);
      $fs->prepareDirectory($config_path, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);
      foreach ($files as $filename) {
        if (substr($filename, 0, 5) === 'block') {
          $confYml = Yaml::decode(file_get_contents($orig_config_path . DIRECTORY_SEPARATOR . $filename));
          $confYml['dependencies']['theme'] = [];
          $confYml['dependencies']['theme'][] = $subtheme_machine_name;
          $confYml['id'] = str_replace('bootstrap5', $subtheme_machine_name, $confYml['id']);
          $confYml['theme'] = $subtheme_machine_name;
          $file_name = str_replace('bootstrap5', $subtheme_machine_name, $filename);
          file_put_contents($config_path . DIRECTORY_SEPARATOR . $file_name,
            Yaml::encode($confYml));
        }
      }

      // Add install config to subtheme.
      $orig_config_path = $this->themeExtensionList->getPath('bootstrap5') . DIRECTORY_SEPARATOR . 'config/install';
      $config_path = $themePath . DIRECTORY_SEPARATOR . 'config/install';
      $files = scandir($orig_config_path);
      $fs->prepareDirectory($config_path, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);
      foreach ($files as $filename) {
        if (substr($filename, 0, 10) === 'bootstrap5') {
          $confYml = Yaml::decode(file_get_contents($orig_config_path . DIRECTORY_SEPARATOR . $filename));
          $file_name = str_replace('bootstrap5', $subtheme_machine_name, $filename);
          file_put_contents($config_path . DIRECTORY_SEPARATOR . $file_name,
            Yaml::encode($confYml));
        }
      }

      $this->messenger->addStatus(t('Subtheme created at %subtheme', [
        '%subtheme' => $themePath,
      ]));
    }
    else {
      $this->messenger->addError(t('Folder already exists at %subtheme', [
        '%subtheme' => $themePath,
      ]));
    }
  }

}

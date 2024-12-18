<?php

namespace Drush\Commands;

use Consolidation\AnnotatedCommand\CommandError;
use Drupal\bootstrap5\SubthemeManager;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drush\Attributes as CLI;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 */
final class Bootstrap5Commands extends DrushCommands {

  /**
   * Constructs a Subtheme Commands object.
   *
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   *   The file system service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger interface.
   * @param \Drupal\Core\Extension\ThemeExtensionList $themeExtensionList
   *   The theme extension list.
   */
  public function __construct(
    protected FileSystemInterface $fileSystem,
    protected MessengerInterface $messenger,
    protected ThemeExtensionList $themeExtensionList,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system'),
      $container->get('messenger'),
      $container->get('extension.list.theme'),
    );
  }

  /**
   * Generate a Bootstrap 5 subtheme.
   */
  #[CLI\Command(name: 'bootstrap5:generate-subtheme', aliases: ['b5gs'])]
  #[CLI\Argument(name: 'machine_name', description: 'Sub-theme machine name.')]
  #[CLI\Option(name: 'subtheme-name', description: 'Sub-theme human-readable name.')]
  #[CLI\Option(name: 'subtheme-folder', description: 'Sub-theme folder.')]
  #[CLI\Usage(name: 'bootstrap5:subtheme machine_name', description: 'Create machine_name subtheme')]
  #[CLI\Usage(name: 'bootstrap5:subtheme machine_name --subtheme-name="B5 subtheme"', description: 'Create machine_name subtheme with name <B5 subtheme>')]
  public function generateSubtheme(
    string $machine_name = 'b5subtheme',
    array $options = [
      'subtheme-name' => 'B5 subtheme',
      'subtheme-folder' => 'themes/custom',
    ],
  ) {
    $subthemeManager = new SubthemeManager($this->fileSystem, $this->messenger, $this->themeExtensionList);
    $result = $subthemeManager->validateSubtheme($options['subtheme-folder'], $machine_name);

    if (is_array($result)) {
      return new CommandError((string) $result[1]);
    }

    $subthemeManager->createSubtheme($machine_name, $options['subtheme-folder'], $options['subtheme-name']);
  }

}

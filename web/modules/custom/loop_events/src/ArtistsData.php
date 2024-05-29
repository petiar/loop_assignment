<?php

declare(strict_types=1);

namespace Drupal\loop_events;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Service class for getting data from the JSON file.
 */
final class ArtistsData {
  const JSON_FILE = __DIR__ . '/../artists.json';

  /**
   * Constructs an ArtistsData object.
   */
  public function __construct(
    private readonly ConfigFactory $configFactory,
    private readonly CacheBackendInterface $cache,
  ) {}

  /**
   * @return Artist[]
   */
  private function getRawData(): array {
    $json = $this->getFileContents();
    $data = json_decode($json);
    $artists = [];
    foreach ($data as $record) {
      $artist = new Artist($record);
      $artists[$artist->getId()] = $artist;
    }
    return $artists;
  }

  public function getAllForDropdown(): array {
    $data = $this->getRawData();
    foreach ($data as $artist) {
      $dropdown[$artist->getId()] = $artist->getName();
    }
    return $dropdown;
  }

  public function getAll(): array {
    return $this->getRawData();
  }

  public function getById(string $id): Artist|null {
    $artist = $this->getRawData()[$id];
    if ($artist) {
      return $artist;
    }
    return null;
  }

  /**
   * This method provides JSON data either from cache or the file, if
   * this was updated recently.
   *
   * @return bool|string
   */
  private function getFileContents(): bool|string {
    $config = $this->configFactory->get('loop_events.config');
    $timestamp = $config->get('datafile_timestamp');
    $cache = $this->cache->get('loop_events_datafile_timestamp');
    // If the file was not updated and we have data in cache, let provide them.
    if (($timestamp === filemtime(self::JSON_FILE)) && $cache) {
      $data = $cache->data;
    }
    else {
      $config = $this->configFactory->getEditable('loop_events.config');
      $config->set('datafile_timestamp', filemtime(self::JSON_FILE));
      $config->save();
      $data = file_get_contents(self::JSON_FILE);
      $this->cache->set('loop_events_datafile_timestamp', $data);
    }
    return $data;
  }
}

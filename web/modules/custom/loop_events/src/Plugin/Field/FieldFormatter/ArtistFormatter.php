<?php

declare(strict_types=1);

namespace Drupal\loop_events\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\loop_events\Artist;

/**
 * Plugin implementation of the 'Artist' formatter.
 *
 * @FieldFormatter(
 *   id = "artist",
 *   label = @Translation("Artist"),
 *   field_types = {"artist"},
 * )
 */
final class ArtistFormatter extends FormatterBase implements ContainerFactoryPluginInterface {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    /**
     * @var \Drupal\loop_events\ArtistsData $artistData
     */
    $artistData = \Drupal::service('loop_events.artists_data');
    foreach ($items as $delta => $item) {
      $artist = $artistData->getById($item->value);
      if ($artist instanceof Artist) {
        $element[$delta] = [
          '#markup' => $artistData->getById($item->value)->getName(),
        ];
      }
    }
    return $element;
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [];
  }
}

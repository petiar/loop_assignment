<?php

declare(strict_types=1);

namespace Drupal\loop_events\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\NumericItemBase;
use Drupal\Core\Field\Plugin\Field\FieldType\StringItemBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'loop_events_artist' field type.
 *
 * @FieldType(
 *   id = "artist",
 *   label = @Translation("Artist"),
 *   description = @Translation("Artist field."),
 *   default_widget = "artist",
 *   default_formatter = "artist",
 * )
 */
final class ArtistItem extends NumericItemBase {
  public static function defaultFieldSettings() {
    return [];
  }

  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return match ($this->get('value')->getValue()) {
      NULL, '', '0' => TRUE,
      default => FALSE,
    };
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Artists ID from the JSON file'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'value' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Artists ID from the JSON file.',
        'length' => 255,
      ],
    ];

    $schema = [
      'columns' => $columns,
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {
    /**
     * @var \Drupal\loop_events\ArtistsData $artistData
     */
    $artistData = \Drupal::service('loop_events.artists_data');
    $artists = $artistData->getAll();
    $keys = array_keys($artists);
    $values['value'] = $artists[$keys[rand(0, count($keys) - 1)]]->getId();
    return $values;
  }
}

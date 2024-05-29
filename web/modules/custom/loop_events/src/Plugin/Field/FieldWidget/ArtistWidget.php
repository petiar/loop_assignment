<?php

declare(strict_types=1);

namespace Drupal\loop_events\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\loop_events\ArtistsData;

/**
 * Defines the 'loop_events_artist' field widget.
 *
 * @FieldWidget(
 *   id = "artist",
 *   label = @Translation("Artist"),
 *   field_types = {"artist"},
 * )
 */
final class ArtistWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    array $third_party_settings,
    protected ArtistsData $artistsData
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->fieldDefinition = $field_definition;
    $this->settings = $settings;
    $this->thirdPartySettings = $third_party_settings;
  }

  public static function create(
    $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('loop_events.artists_data')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $options = $this->artistsData->getAllForDropdown();
    $element['value'] = $element + [
      '#type' => 'select',
      '#default_value' => $items[$delta]->value ?? NULL,
      '#options' => $options,
    ];
    return $element;
  }
}

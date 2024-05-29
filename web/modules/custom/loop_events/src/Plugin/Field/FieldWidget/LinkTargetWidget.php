<?php

namespace Drupal\loop_events\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;

/**
 * @FieldWidget(
 *   id = "link_target_widget",
 *   label = @Translation("Link with target"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class LinkTargetWidget extends LinkWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $targets = [
      '_self' => t('Opens the linked document in the same frame as it was clicked (this is default)'),
      '_blank' => t('Opens the linked document in a new window'),
      '_parent' => t('Opens the linked document in the parent frameset'),
      '_top' => t('Opens the linked document in the full body of the window'),
    ];

    $default_value = !empty($options['attributes']['target']) ? $options['attributes']['target'] : '_self';
    $element['options']['attributes']['target'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select a target'),
      '#options' => [] + $targets,
      '#default_value' => $default_value,
      '#description' => $this->t('Where do you want the link to be opened?'),
    ];
    return $element;
  }
}

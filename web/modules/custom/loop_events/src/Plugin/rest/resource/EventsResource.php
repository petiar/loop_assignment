<?php

declare(strict_types=1);

namespace Drupal\loop_events\Plugin\rest\resource;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use Drupal\Core\KeyValueStore\KeyValueStoreInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\loop_events\ArtistsData;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Route;

/**
 * Represents Events records as resources.
 *
 * @RestResource (
 *   id = "loop_events_events",
 *   label = @Translation("Events"),
 *   uri_paths = {
 *     "canonical" = "/api/events",
 *   }
 * )
 *
 */
class EventsResource extends ResourceBase {

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    protected $logger,
    protected AccountProxyInterface $loggedUser,
    protected EntityTypeManager $entityTypeManager,
    protected ArtistsData $artistsData
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('loop_events.artists_data')
    );
  }

  /**
   * Responds to GET requests.
   */
  public function get(): ResourceResponse {
    if (!$this->loggedUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
    $events = $this->entityTypeManager->getStorage('node')->loadByProperties([
      'type' => 'event',
    ]);

    $resources = [];
    /**
     * @var \Drupal\node\Entity\Node[] $events
     */
    foreach ($events as $event) {
      $artist_ids = $event->get('field_artists')->getValue();
      $artists = [];
      foreach ($artist_ids as $artist_id) {
        $artists[] = $this->artistsData->getById($artist_id['value']);
      }
      $resources[] = [
        'id' => $event->id(),
        'title' => $event->label(),
        'description' => $event->get('field_description')->getValue()['value'],
        'date' => $event->get('field_date')->getValue(),
        'location' => $event->get('field_location')->getValue(),
        'image' => $event->get('field_image'),
        'organizer' => $event->get('field_organizer')->getValue(),
        'artists' => $artists,
        'website' => $event->get('field_event_website'),
      ];
    }

    $response = new ResourceResponse($resources);
    $response->addCacheableDependency($resources);
    return $response;
  }
}

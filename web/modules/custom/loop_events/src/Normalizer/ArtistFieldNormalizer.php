<?php

namespace Drupal\loop_events\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;
use Drupal\loop_events\Artist;

class ArtistFieldNormalizer extends NormalizerBase {
  public function normalize($object, $format = NULL, array $context = []) {
    assert($object instanceof Artist);
    return [
      'id' => $object->getId(),
      'name' => $object->getName(),
      'genre' => $object->getGenre(),
      'albmus' => $object->getAlbums(),
      'nationality' => $object->getNationality(),
      'active' => $object->isActive(),
    ];
  }

  public function supportsNormalization($data, string $format = NULL, array $context = []): bool {
    if ($data instanceof Artist) {
      return TRUE;
    }
    return FALSE;
  }
}

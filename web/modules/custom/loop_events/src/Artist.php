<?php
namespace Drupal\loop_events;

use stdClass;

class Artist {
  private int $id;
  private string $name;
  private string $genre;
  private string $nationality;
  private int $albums;
  private bool $active;

  public function __construct(stdClass $record) {
    $this->setId($record->id);
    $this->setName($record->name);
    $this->setActive($record->active);
    $this->setAlbums($record->albums);
    $this->setGenre($record->genre);
    $this->setNationality($record->nationality);
  }

  public function getId(): int {
    return $this->id;
  }

  public function setId(int $id): void {
    $this->id = $id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function setName(string $name): void {
    $this->name = $name;
  }

  public function getGenre(): string {
    return $this->genre;
  }

  public function setGenre(string $genre): void {
    $this->genre = $genre;
  }

  public function getNationality(): string {
    return $this->nationality;
  }

  public function setNationality(string $nationality): void {
    $this->nationality = $nationality;
  }

  public function getAlbums(): int {
    return $this->albums;
  }

  public function setAlbums(int $albums): void {
    $this->albums = $albums;
  }

  public function isActive(): bool {
    return $this->active;
  }

  public function setActive(bool $active): void {
    $this->active = $active;
  }
}

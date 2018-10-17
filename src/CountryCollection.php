<?php

namespace Drupal\iso3166;

use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines a CountryCollection.
 */
class CountryCollection implements CountryCollectionInterface {

  /**
   * The collection name.
   *
   * @var \Drupal\Core\StringTranslation\TranslatableMarkup
   */
  protected $name;

  /**
   * The collection countries.
   *
   * @var \Drupal\iso3166\CountryInterface[]
   */
  protected $countries;

  /**
   * Creates an CountryCollection object.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $name
   *   The continent name.
   * @param \Drupal\iso3166\CountryInterface[] $countries
   *   The countries.
   */
  public function __construct(TranslatableMarkup $name, array $countries) {
    $this->name = $name;
    $this->countries = $countries;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    return $this->countries;
  }

}

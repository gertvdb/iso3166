<?php

namespace Drupal\iso3166;

/**
 * Defines an interface for Country collections.
 */
interface CountryCollectionInterface {

  /**
   * Get the collection name.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   A collection name.
   */
  public function getName();

  /**
   * The countries in the collection.
   *
   * @return \Drupal\iso3166\CountryInterface[]
   *   An array of countries in the collection.
   */
  public function getCountries();

}

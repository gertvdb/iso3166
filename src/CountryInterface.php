<?php

namespace Drupal\iso3166;

/**
 * Defines an interface for Countries.
 */
interface CountryInterface {

  /**
   * Get the name.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   A country name.
   */
  public function getName();

  /**
   * The alpha2 country code.
   *
   * @return string
   *   A 2 letter code representing the country.
   */
  public function getAlpha2();

  /**
   * The alpha3 country code.
   *
   * @return string
   *   A 3 letter code representing the country.
   */
  public function getAlpha3();

  /**
   * The numeric country code.
   *
   * @return string
   *   A numeric code representing the country.
   */
  public function getNumeric();

  /**
   * The continent object.
   *
   * @return \Drupal\iso3166\ContinentInterface|null
   *   The continent object or NULL.
   */
  public function getContinent();

  /**
   * Get the object data as an array.
   *
   * @return array
   *   The object data as an array.
   */
  public function toArray();

}

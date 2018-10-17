<?php

namespace Drupal\iso3166\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;

/**
 * Interface CountryFieldItemInterface.
 *
 * @package Drupal\iso3166\Plugin\Field\FieldType
 */
interface Iso3166FieldItemInterface extends FieldItemInterface {

  /**
   * Get a country object.
   *
   * @return \Drupal\iso3166\CountryInterface|null
   *   The country object.
   */
  public function toCountry();

}

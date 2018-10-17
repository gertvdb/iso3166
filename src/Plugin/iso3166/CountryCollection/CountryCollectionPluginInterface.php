<?php

namespace Drupal\iso3166\Plugin\Iso3166\CountryCollection;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Country Collection plugins.
 */
interface CountryCollectionPluginInterface extends PluginInspectionInterface {

  /**
   * Get the label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The country collection label.
   */
  public function getLabel();

  /**
   * Get the countries in the collection.
   *
   * @return array
   *   An array of alpha2 country codes.
   */
  public function getCountries();

}

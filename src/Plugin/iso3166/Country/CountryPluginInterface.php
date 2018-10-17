<?php

namespace Drupal\iso3166\Plugin\Iso3166\Country;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Country plugins.
 */
interface CountryPluginInterface extends PluginInspectionInterface {

  /**
   * The country label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The country label.
   */
  public function getLabel();

  /**
   * The alpha2 country code.
   *
   * @return string
   *   The alpha2 country code.
   */
  public function getAlpha2();

  /**
   * The alpha3 country code.
   *
   * @return string
   *   The alpha3 country code.
   */
  public function getAlpha3();

  /**
   * The numeric country code.
   *
   * @return string
   *   The numeric country code.
   */
  public function getNumeric();

  /**
   * The continent code of the country.
   *
   * @return string
   *   The continent code of the country.
   */
  public function getContinent();

  /**
   * The country object.
   *
   * @return \Drupal\iso3166\CountryInterface
   *   A country object.
   */
  public function toCountry();

}

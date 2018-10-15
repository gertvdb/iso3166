<?php

namespace Drupal\iso3166;

/**
 * Defines an interface for Continent plugins.
 */
interface ContinentInterface {

  /**
   * Get the name.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   A continent name.
   */
  public function getName();

  /**
   * The alpha2 country code.
   *
   * @return string
   *   A 2 letter code representing the country.
   */
  public function getAlpha2();

}

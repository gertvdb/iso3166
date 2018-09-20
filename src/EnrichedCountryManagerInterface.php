<?php

namespace Drupal\iso3166;

use Drupal\Core\Locale\CountryManagerInterface;

/**
 * Defines an interface for an ISO3166 country manager.
 */
interface EnrichedCountryManagerInterface extends CountryManagerInterface {

  const ORIGINAL_VALUE_KEY = 'name';

  /**
   * Enrich the default country list.
   *
   * Enrich the standard provided list with extra data.
   * The value of the current list will be moved to the
   * 'ORIGINAL_VALUE_KEY' key of the enriched array.
   *
   * @return array
   *   A enriched country array.
   */
  public function getEnrichedList();

  /**
   * Search the enriched list for values.
   *
   * @param string $key
   *   The key to check.
   * @param string $value
   *   The value to match.
   *
   * @return array
   *   An result array containing all country data.
   */
  public function searchEnrichedList($key, $value);

}

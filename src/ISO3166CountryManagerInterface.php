<?php

namespace Drupal\iso3166;

use Drupal\Core\Locale\CountryManagerInterface;

/**
 * Defines an interface for an ISO3166 country manager.
 */
interface ISO3166CountryManagerInterface extends CountryManagerInterface {

  /**
   * Enrich the default country list.
   *
   * Enrich the standard provided list with extra data.
   * The value of the current list will be moved to the
   * 'original_value' key of the enriched array.
   *
   * @param string $originalValueKey
   *   The array key to place the original value in.
   *
   * @return array
   *   A enriched country array.
   */
  public function getEnrichedList($originalValueKey = 'original_value');

}

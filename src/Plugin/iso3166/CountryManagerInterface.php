<?php

namespace Drupal\iso3166\Plugin\Iso3166;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the CountryManagerInterface.
 */
interface CountryManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

  /**
   * Create an instance by alpha2 code.
   *
   * @param string $alpha2
   *   The alpha2 code.
   *
   * @return \Drupal\iso3166\Plugin\Iso3166\Country\CountryPluginInterface|null
   *   A plugin instance.
   */
  public function createInstanceByAlpha2($alpha2);

  /**
   * Create list of all countries.
   *
   * @return \Drupal\iso3166\CountryInterface[]
   *   An array of country objects.
   */
  public function getCountries();

  /**
   * Get country by alpha2 code.
   *
   * @param string $alpha2
   *   An alpha2 code.
   *
   * @return \Drupal\iso3166\CountryInterface|null
   *   A country object.
   */
  public function getCountry($alpha2);

}

<?php

namespace Drupal\iso3166\Plugin\Iso3166;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the CountryCollectionManagerInterface.
 */
interface CountryCollectionManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

  /**
   * Create list of all country collections.
   *
   * @return \Drupal\iso3166\CountryCollectionInterface[]
   *   An array of country collection objects.
   */
  public function getCountryCollections();

}

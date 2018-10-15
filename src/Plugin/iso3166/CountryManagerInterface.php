<?php

namespace Drupal\iso3166\Plugin\iso3166;

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
   * @return \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface|null
   *   A plugin instance.
   */
  public function createInstanceByAlpha2($alpha2);

}

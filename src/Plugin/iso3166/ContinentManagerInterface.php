<?php

namespace Drupal\iso3166\Plugin\Iso3166;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the ContinentManagerInterface.
 */
interface ContinentManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

  /**
   * Create an instance by alpha2 code.
   *
   * @param string $alpha2
   *   The alpha2 code.
   *
   * @return \Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface|null
   *   A plugin instance.
   */
  public function createInstanceByAlpha2($alpha2);

  /**
   * Create list of all continents.
   *
   * @return \Drupal\iso3166\ContinentInterface[]
   *   An array of continent objects.
   */
  public function getContinents();

  /**
   * Get continent by alpha2 code.
   *
   * @param string $alpha2
   *   An alpha2 code.
   *
   * @return \Drupal\iso3166\ContinentInterface|null
   *   A continent object.
   */
  public function getContinent($alpha2);

}

<?php

namespace Drupal\iso3166\Plugin\iso3166;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Continent plugin manager.
 */
class ContinentManager extends DefaultPluginManager implements ContinentManagerInterface {

  /**
   * Constructs a new ContinentManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cacheBackend, ModuleHandlerInterface $moduleHandler) {
    parent::__construct('Plugin/iso3166/Continent', $namespaces, $moduleHandler, 'Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface', 'Drupal\iso3166\Annotation\Continent');

    $this->alterInfo('iso3166_continent_info');
    $this->setCacheBackend($cacheBackend, 'iso3166_continent_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getContinent($alpha2) {
    /** @var \Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface $continentInstance */
    $continentInstance = $this->createInstanceByAlpha2($alpha2);
    return $continentInstance ? $continentInstance->toContinent() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinents() {
    $continents = [];
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface $continentInstance */
      $continentInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $continentInstance->toContinent();

      $continents[] = $continent;
    }

    return $continents;
  }

  /**
   * {@inheritdoc}
   */
  protected function createInstanceByAlpha2($alpha2) {
    $instance = NULL;
    $continentDefinitions = $this->getDefinitions();
    foreach ($continentDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface $continentInstance */
      $continentInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $continentInstance->toContinent();

      if ($continent->getAlpha2() === $alpha2) {
        return $continentInstance;
      }
    }

    return $instance;
  }

}

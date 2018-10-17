<?php

namespace Drupal\iso3166\Plugin\Iso3166;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Country Collection plugin manager.
 */
class CountryCollectionManager extends DefaultPluginManager implements CountryCollectionManagerInterface {

  /**
   * Constructs a new CountryCollectionManager object.
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
    parent::__construct('Plugin/iso3166/CountryCollection', $namespaces, $moduleHandler, 'Drupal\iso3166\Plugin\Iso3166\CountryCollection\CountryCollectionPluginInterface', 'Drupal\iso3166\Annotation\CountryCollection');

    $this->alterInfo('iso3166_country_collection_info');
    $this->setCacheBackend($cacheBackend, 'iso3166_country_collection_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getCountryCollections() {
    $countryCollections = [];
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\Iso3166\CountryCollection\CountryCollectionPluginInterface $countryInstance */
      $collectionInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\CountryCollectionInterface $collection */
      $collection = $collectionInstance->toCollection();

      $countryCollections[] = $collection;
    }

    return $countryCollections;
  }

}

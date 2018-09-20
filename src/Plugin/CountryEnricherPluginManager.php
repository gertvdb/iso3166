<?php

namespace Drupal\iso3166\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Country enricher plugin plugin manager.
 */
class CountryEnricherPluginManager extends DefaultPluginManager {


  /**
   * Constructs a new CountryEnricherPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/CountryEnricherPlugin', $namespaces, $module_handler, 'Drupal\iso3166\Plugin\CountryEnricherPluginInterface', 'Drupal\iso3166\Annotation\CountryEnricherPlugin');

    $this->alterInfo('iso3166_country_enricher_plugin_info');
    $this->setCacheBackend($cache_backend, 'iso3166_country_enricher_plugin_plugins');
  }

}

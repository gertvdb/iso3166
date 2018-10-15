<?php

namespace Drupal\iso3166\Plugin\iso3166;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Country plugin manager.
 */
class CountryManager extends DefaultPluginManager implements CountryManagerInterface {

  /**
   * Constructs a new CountryManager object.
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
    parent::__construct('Plugin/iso3166/Country', $namespaces, $moduleHandler, 'Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface', 'Drupal\iso3166\Annotation\Country');

    $this->alterInfo('iso3166_country_info');
    $this->setCacheBackend($cacheBackend, 'iso3166_country_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getCountry($alpha2) {
    /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
    $countryInstance = $this->createInstanceByAlpha2($alpha2);
    return $countryInstance ? $countryInstance->toCountry() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    $countries = [];
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Country $country */
      $country = $countryInstance->toCountry();

      $countries[] = $country;
    }

    return $countries;
  }

  /**
   * {@inheritdoc}
   */
  protected function createInstanceByAlpha2($alpha2) {
    $instance = NULL;
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Country $country */
      $country = $countryInstance->toCountry();

      if ($country->getAlpha2() === $alpha2) {
        return $countryInstance;
      }
    }

    return $instance;
  }

}

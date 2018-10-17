<?php

namespace Drupal\iso3166\Plugin\Iso3166;

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
    parent::__construct('Plugin/iso3166/Continent', $namespaces, $moduleHandler, 'Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface', 'Drupal\iso3166\Annotation\Continent');

    $this->alterInfo('iso3166_continent_info');
    $this->setCacheBackend($cacheBackend, 'iso3166_continent_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $alpha2Codes = [];
    $definitions = parent::getDefinitions();

    foreach ($definitions as $definition) {

      // Guard against invalid alpha2 codes.
      $this->guardAgainstInvalidAlpha2($definition['alpha2']);
      $this->guardAgainstDuplicateAlpha2($definition['alpha2'], $alpha2Codes);

      $alpha2Codes[] = $definition['alpha2'];
    }

    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstInvalidAlpha2($alpha2) {
    if (!is_string($alpha2) || strlen($alpha2) !== 2) {
      throw new \LogicException(sprintf(
        'Expected $alpha2 to be a 2 character string, got : "%s"',
        $alpha2
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstDuplicateAlpha2($alpha2, $alpha2List) {
    if (in_array($alpha2, $alpha2List)) {
      throw new \LogicException(sprintf(
        'Expected $alpha2 to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_iso3166_country_info_alter.',
        $alpha2
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function createInstanceByAlpha2($alpha2) {
    $continentDefinitions = $this->getDefinitions();
    foreach ($continentDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface $continentInstance */
      $continentInstance = $this->createInstance($pluginId, $pluginConfig);

      if ($continentInstance->getAlpha2() === $alpha2) {
        return $continentInstance;
      }
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinent($alpha2) {
    /** @var \Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface $continentInstance */
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

      /** @var \Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface $continentInstance */
      $continentInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $continentInstance->toContinent();

      $continents[] = $continent;
    }

    return $continents;
  }

}

<?php

namespace Drupal\iso3166\Plugin\Iso3166;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use LogicException;

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
    parent::__construct('Plugin/iso3166/Country', $namespaces, $moduleHandler, 'Drupal\iso3166\Plugin\Iso3166\Country\CountryPluginInterface', 'Drupal\iso3166\Annotation\Country');

    $this->alterInfo('iso3166_country_info');
    $this->setCacheBackend($cacheBackend, 'iso3166_country_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {

    // Get empty defaults.
    $alpha2Codes = [];
    $alpha3Codes = [];
    $numericCodes = [];

    // Get definitions.
    $definitions = parent::getDefinitions();

    if (!empty($definitions)) {
      foreach ($definitions as $definition) {

        // Guard against invalid alpha2 codes.
        $this->guardAgainstInvalidAlpha2($definition['alpha2']);
        $this->guardAgainstDuplicateAlpha2($definition['alpha2'], $alpha2Codes);

        // Guard against invalid alpha3 codes.
        $this->guardAgainstInvalidAlpha3($definition['alpha3']);
        $this->guardAgainstDuplicateAlpha3($definition['alpha3'], $alpha3Codes);

        // Guard against invalid numeric codes.
        $this->guardAgainstInvalidNumeric($definition['numeric']);
        $this->guardAgainstDuplicateNumeric($definition['numeric'], $numericCodes);

        $alpha2Codes[] = $definition['alpha2'];
        $alpha3Codes[] = $definition['alpha3'];
        $numericCodes[] = $definition['numeric'];
      }
    }

    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstInvalidAlpha2($alpha2) {
    if (!is_string($alpha2) || strlen($alpha2) !== 2) {
      throw new LogicException(sprintf(
        'Expected $alpha2 to be a 2 character string, got : "%s"',
        $alpha2
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstInvalidAlpha3($alpha3) {
    if (!is_string($alpha3) || strlen($alpha3) !== 3) {
      throw new LogicException(sprintf(
        'Expected $alpha3 to be a 3 character string, got : "%s"',
        $alpha3
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstInvalidNumeric($numeric) {
    if (!is_numeric($numeric) || strlen($numeric) !== 3) {
      throw new LogicException(sprintf(
        'Expected $numeric to be a 3 character numeric string, got : "%s"',
        $numeric
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstDuplicateAlpha2($alpha2, $alpha2List) {
    if (in_array($alpha2, $alpha2List)) {
      throw new LogicException(sprintf(
        'Expected $alpha2 to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_iso3166_country_info_alter.',
        $alpha2
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstDuplicateAlpha3($alpha3, $alpha3List) {
    if (in_array($alpha3, $alpha3List)) {
      throw new LogicException(sprintf(
        'Expected $alpha3 to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_iso3166_country_info_alter.',
        $alpha3
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstDuplicateNumeric($numeric, $numericList) {
    if (in_array($numeric, $numericList)) {
      throw new LogicException(sprintf(
        'Expected $numeric to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_iso3166_country_info_alter.',
        $numeric
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function createInstanceByAlpha2($alpha2) {
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\Iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->createInstance($pluginId, $pluginConfig);

      if ($countryInstance->getAlpha2() === $alpha2) {
        return $countryInstance;
      }
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountry($alpha2) {
    /** @var \Drupal\iso3166\Plugin\Iso3166\Country\CountryPluginInterface $countryInstance */
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

      /** @var \Drupal\iso3166\Plugin\Iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Country $country */
      $country = $countryInstance->toCountry();

      $countries[] = $country;
    }

    return $countries;
  }

}

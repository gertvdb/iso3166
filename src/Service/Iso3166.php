<?php

namespace Drupal\iso3166\Service;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\iso3166\Plugin\iso3166\ContinentManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Plugin\iso3166\CountryManager;

/**
 * Class Iso3611.
 *
 * @package Drupal\iso3611
 */
class Iso3166 implements ContainerInjectionInterface {

  /**
   * The country manager.
   *
   * @var \Drupal\iso3166\Plugin\iso3166\CountryManager
   */
  protected $countryManager;

  /**
   * The continent manager.
   *
   * @var \Drupal\iso3166\Plugin\iso3166\ContinentManager
   */
  protected $continentManager;

  /**
   * Creates an Iso3166Countries service.
   *
   * @param \Drupal\iso3166\Plugin\iso3166\CountryManager $countryManager
   *   The country manager.
   * @param \Drupal\iso3166\Plugin\iso3166\ContinentManager $continentManager
   *   The continent manager.
   */
  public function __construct(CountryManager $countryManager, ContinentManager $continentManager) {
    $this->countryManager = $countryManager;
    $this->continentManager = $continentManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.country'),
      $container->get('plugin.manager.continent')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCountry($alpha2) {
    /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
    $countryInstance = $this->countryManager->createInstanceByAlpha2($alpha2);
    return $countryInstance ? $countryInstance->toCountry() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinent($alpha2) {
    /** @var \Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface $continentInstance */
    $continentInstance = $this->continentManager->createInstanceByAlpha2($alpha2);
    return $continentInstance ? $continentInstance->toContinent() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    $countries = [];
    $countryDefinitions = $this->countryManager->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->countryManager->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Country $country */
      $country = $countryInstance->toCountry();

      $countries[] = $country;
    }

    return $countries;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinents() {
    $continents = [];
    $countryDefinitions = $this->continentManager->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Continent\ContinentPluginInterface $continentInstance */
      $continentInstance = $this->continentManager->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $continentInstance->toContinent();

      $continents[] = $continent;
    }

    return $continents;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountriesByContinent($alpha2) {
    $countries = [];
    $countryDefinitions = $this->countryManager->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {

      /** @var \Drupal\iso3166\Plugin\iso3166\Country\CountryPluginInterface $countryInstance */
      $countryInstance = $this->countryManager->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Country $country */
      $country = $countryInstance->toCountry();

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $country->getContinent();

      if ($continent && $continent->getAlpha2() === $alpha2) {
        $countries[] = $country;
      }
    }

    return $countries;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinentByCountry($alpha2) {
    /** @var \Drupal\iso3166\Country $country */
    $country = $this->getCountry($alpha2);
    return $country ? $country->getContinent() : NULL;
  }

}

<?php

namespace Drupal\iso3166\Service;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\iso3166\Factory\CountryFactory;
use Drupal\iso3166\Plugin\Iso3166\ContinentManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Plugin\Iso3166\CountryManager;

/**
 * Class Iso3611.
 *
 * @package Drupal\iso3611
 */
class Iso3166 implements ContainerInjectionInterface {

  /**
   * The country manager.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\CountryManager
   */
  protected $countryManager;

  /**
   * The country manager.
   *
   * @var \Drupal\iso3166\Factory\CountryFactory
   */
  protected $countryFactory;

  /**
   * Creates an Iso3166Countries service.
   *
   * @param \Drupal\iso3166\Plugin\Iso3166\CountryManager $countryManager
   *   The country manager.
   */
  public function __construct(CountryManager $countryManager, CountryFactory $countryFactory) {
    $this->countryManager = $countryManager;
    $this->countryFactory = $countryFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    /** @var CountryManager $countryManager */
    $countryManager = $container->get('plugin.manager.country');

    /** @var \Drupal\iso3166\Factory\CountryFactory $countryFactory */
    $countryFactory = $container->get('iso3166.country_factory');

    return new static(
      $countryManager,
      $countryFactory
    );
  }

  /**
   * Get a country.
   *
   * @param string $alpha2
   *   The country alpha2 key.
   *
   * @return \Drupal\iso3166\CountryInterface|null
   *   The Country object or NULL.
   */
  public function getCountry($alpha2) {
    return $this->countryFactory->createCountry($alpha2);
  }

  /**
   * Get a continent.
   *
   * @param string $alpha2
   *   The continent alpha2 key.
   *
   * @return \Drupal\iso3166\ContinentInterface|null
   *   The Continent object or NULL.
   */
  public function getContinent($alpha2) {
    return $this->countryFactory->createCountry($alpha2);
  }

  /**
   * Get the countries of a continent.
   *
   * @param string $alpha2
   *   The continent alpha2 key.
   *
   * @return \Drupal\iso3166\CountryInterface[]
   *   An array of Country objects.
   */
  public function getCountriesByContinent($alpha2) {
    $continentCountries = [];
    $countries = $this->countryManager->getCountries();

    /** @var \Drupal\iso3166\CountryInterface $country */
    foreach ($countries as $country) {

      /** @var \Drupal\iso3166\ContinentInterface $continent */
      $continent = $country->getContinent();

      if ($continent && $continent->getAlpha2() === $alpha2) {
        $continentCountries[] = $country;
      }
    }

    return $continentCountries;
  }

}

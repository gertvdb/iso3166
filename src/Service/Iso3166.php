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
   * Creates an Iso3166Countries service.
   *
   * @param \Drupal\iso3166\Plugin\iso3166\CountryManager $countryManager
   *   The country manager.
   */
  public function __construct(CountryManager $countryManager) {
    $this->countryManager = $countryManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.country')
    );
  }

  /**
   * {@inheritdoc}
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

  /**
   * {@inheritdoc}
   */
  public function getContinentByCountry($alpha2) {
    /** @var \Drupal\iso3166\Country $country */
    $country = $this->countryManager->getCountry($alpha2);
    return $country ? $country->getContinent() : NULL;
  }

}

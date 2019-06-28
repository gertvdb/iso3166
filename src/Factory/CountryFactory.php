<?php

namespace Drupal\iso3166\Factory;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Country;
use Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface;

/**
 * Defines an factory for creating a country.
 */
class CountryFactory implements ContainerInjectionInterface {

  /**
   * The continent factory.
   *
   * @var \Drupal\iso3166\Factory\ContinentFactory
   */
  protected $continentFactory;

  /**
   * The country plugin manager.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface
   */
  protected $countryManager;

  /**
   * Creates an CountryDerivative object.
   *
   * @param \Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface $countryManager
   *   The continent plugin manager.
   * @param \Drupal\iso3166\Factory\ContinentFactory $continentFactory
   *   The continent plugin manager.
   */
  public function __construct(CountryManagerInterface $countryManager, ContinentFactory $continentFactory) {
    $this->countryManager = $countryManager;
    $this->continentFactory = $continentFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.country'),
      $container->get('iso3166.continent_factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createCountry($alpha2) {
    try {
      $countryInstance = $this->countryManager->createInstanceByAlpha2($alpha2);
      if (!$countryInstance) {
        return NULL;
      }

      $continent = $this->continentFactory->createContinent($countryInstance->getContinent());

      return new Country(
        $countryInstance->getLabel(),
        $countryInstance->getAlpha2(),
        $countryInstance->getAlpha3(),
        $countryInstance->getNumeric(),
        $continent
      );
    }
    catch (\Exception $e) {
      return NULL;
    }
  }

}

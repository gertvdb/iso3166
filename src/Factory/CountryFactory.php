<?php

namespace Drupal\iso3166\Factory;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Country;
use Drupal\iso3166\Plugin\iso3166\ContinentManager;

/**
 * Defines an factory for creating a country.
 */
class CountryFactory implements ContainerInjectionInterface {

  /**
   * The continent plugin manager.
   *
   * @var \Drupal\iso3166\Plugin\iso3166\ContinentManager
   */
  protected $continentManager;

  /**
   * Creates an CountryDerivative object.
   *
   * @var \Drupal\iso3166\Plugin\iso3166\ContinentManager $continentManager
   *   The continent plugin manager.
   */
  public function __construct(ContinentManager $continentManager) {
    $this->continentManager = $continentManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.continent')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createCountry($name, $alpha2, $alpha3, $numeric, $continent) {
    try {
      $continentInstance = $this->continentManager->createInstanceByAlpha2($continent);
      $continent = $continentInstance ? $continentInstance->toContinent() : NULL;
      return new Country($name, $alpha2, $alpha3, $numeric, $continent);
    }
    catch (\Exception $e) {
      return NULL;
    }
  }

}

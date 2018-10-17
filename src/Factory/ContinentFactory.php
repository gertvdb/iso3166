<?php

namespace Drupal\iso3166\Factory;

use Drupal\iso3166\Continent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Plugin\Iso3166\ContinentManager;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

/**
 * Defines an factory for creating a continent.
 */
class ContinentFactory implements ContainerInjectionInterface {

  /**
   * The continent plugin manager.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\ContinentManager
   */
  protected $continentManager;

  /**
   * Creates an CountryDerivative object.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\ContinentManager $continentManager
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
  public function createContinent($alpha2) {
    $continent = $this->continentManager->createInstanceByAlpha2($alpha2);
    return new Continent($continent->getLabel(), $continent->getAlpha2());
  }

}

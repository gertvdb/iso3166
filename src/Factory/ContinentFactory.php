<?php

namespace Drupal\iso3166\Factory;

use Drupal\iso3166\Continent;
use Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface;
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
   * @var \Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface $continentManager
   *   The continent plugin manager.
   */
  public function __construct(ContinentManagerInterface $continentManager) {
    $this->continentManager = $continentManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /** @var \Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface $continentManager */
    $continentManager = $container->get('plugin.manager.continent');

    return new static(
      $continentManager
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

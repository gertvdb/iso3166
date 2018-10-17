<?php

namespace Drupal\iso3166\Plugin\Iso3166\CountryCollection\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Service\Iso3166;

/**
 * Provides country collection plugins for ISO3166.
 */
class CountryCollectionContinentDerivative extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The iso3611 service.
   *
   * @var \Drupal\iso3166\Service\Iso3166
   */
  protected $iso3611;

  /**
   * The continent manager.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface
   */
  protected $continentManager;

  /**
   * Creates a CountryCollectionDerivative.
   *
   * @param \Drupal\iso3166\Service\Iso3166 $iso3611
   *   The iso3611 service.
   * @param \Drupal\iso3166\Plugin\Iso3166\ContinentManagerInterface $continentManager
   *   The continent manager.
   */
  public function __construct(Iso3166 $iso3611, ContinentManagerInterface $continentManager) {
    $this->continentManager = $continentManager;
    $this->iso3611 = $iso3611;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $basePluginId) {
    return new static(
      $container->get('iso3166'),
      $container->get('plugin.manager.continent')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($basePluginDefinition) {

    // Get the continent data for the provider.
    $dataList = $this->continentManager->getContinents();

    // Loop continents.
    if (!empty($dataList)) {
      foreach ($dataList as $continentItem) {

        $key = $continentItem->getAlpha2();
        $this->derivatives[$key] = $basePluginDefinition;
        $this->derivatives[$key]['id'] = $key;
        $this->derivatives[$key]['label'] = $continentItem->getName();

        $continentCountries = $this->iso3611->getCountriesByContinent($key);
        $countries = [];

        // Loop countries in continent.
        if (!empty($continentCountries)) {
          foreach ($continentCountries as $continentCountry) {
            $countries[] = $continentCountry->getAlpha2();
          }
        }

        $this->derivatives[$key]['countries'] = $countries;

      }
    }

    return $this->derivatives;
  }

}

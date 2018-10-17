<?php

namespace Drupal\iso3166\Plugin\Iso3166\Country\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\iso3166\Service\DataProvider;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides country plugins for ISO3166.
 */
class CountryDerivative extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The data provider.
   *
   * @var \Drupal\iso3166\Service\DataProvider
   */
  protected $dataProvider;

  /**
   * Creates a CountryDerivative.
   *
   * @param \Drupal\iso3166\Service\DataProvider $dataProvider
   *   The data provider.
   */
  public function __construct(DataProvider $dataProvider) {
    $this->dataProvider = $dataProvider;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $basePluginId) {
    return new static(
      $container->get('iso3166.data_provider')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($basePluginDefinition) {

    // Get the continent data for the provider.
    $dataList = $this->dataProvider->getList();

    // Loop continents.
    if (!empty($dataList)) {
      foreach ($dataList as $continentItem) {

        // Get the country data for the continent.
        $countries = $continentItem['countries'];

        // Loop countries in continent.
        if (!empty($countries)) {
          foreach ($countries as $country) {

            // Create derived plugins.
            $key = $country['alpha2'];
            $this->derivatives[$key] = $basePluginDefinition;
            $this->derivatives[$key]['id'] = $key;
            $this->derivatives[$key]['label'] = $country['name'];
            $this->derivatives[$key]['alpha2'] = $country['alpha2'];
            $this->derivatives[$key]['alpha3'] = $country['alpha3'];
            $this->derivatives[$key]['numeric'] = $country['numeric'];
            $this->derivatives[$key]['continent'] = $continentItem['alpha2'];

          }
        }
      }
    }

    return $this->derivatives;
  }

}

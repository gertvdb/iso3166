<?php

namespace Drupal\iso3166\Plugin\Iso3166\Continent\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\iso3166\Service\DataProvider;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides continent plugins for ISO3166.
 */
class ContinentDerivative extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The data provider.
   *
   * @var \Drupal\iso3166\Service\DataProvider
   */
  protected $dataProvider;

  /**
   * Creates a ContinentDerivate.
   *
   * @param \Drupal\iso3166\Service\DataProvider $dataProvider
   *   The iso3166 service.
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

        // Create derived plugins.
        $key = $continentItem['alpha2'];
        $this->derivatives[$key] = $basePluginDefinition;
        $this->derivatives[$key]['id'] = $key;
        $this->derivatives[$key]['label'] = $continentItem['label'];
        $this->derivatives[$key]['alpha2'] = $continentItem['alpha2'];
      }
    }

    return $this->derivatives;
  }

}

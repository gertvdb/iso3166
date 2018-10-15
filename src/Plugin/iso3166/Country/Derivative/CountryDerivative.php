<?php

namespace Drupal\iso3166\Plugin\iso3166\Country\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\iso3166\Service\Iso3166Provider;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides country plugins for ISO3166.
 */
class CountryDerivative extends DeriverBase implements ContainerDeriverInterface {

  /**
   * The iso3166 service.
   *
   * @var \Drupal\iso3166\Service\Iso3166Provider
   */
  protected $iso3166;

  /**
   * Creates an CountryDerivative object.
   *
   * @param \Drupal\iso3166\Service\Iso3166Provider $iso3166
   *   The iso3166 service.
   */
  public function __construct(Iso3166Provider $iso3166) {
    $this->iso3166 = $iso3166;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('iso3166.data_provider')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($basePluginDefinition) {

    foreach ($this->iso3166->getList() as $continent) {
      $countries = $continent['countries'];
      foreach ($countries as $country) {
        $key = $country['alpha2'];

        $this->derivatives[$key] = $basePluginDefinition;
        $this->derivatives[$key]['id'] = $key;
        $this->derivatives[$key]['label'] = $country['name'];
        $this->derivatives[$key]['alpha2'] = $key;
        $this->derivatives[$key]['alpha3'] = $country['alpha3'];
        $this->derivatives[$key]['numeric'] = $country['numeric'];
        $this->derivatives[$key]['continent'] = $continent['code'];
      }
    }

    return $this->derivatives;
  }

}

<?php

namespace Drupal\iso3166\Plugin\iso3166\Continent\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\iso3166\Service\Iso3166Provider;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides continent plugins for ISO3166.
 */
class ContinentDerivative extends DeriverBase implements ContainerDeriverInterface {

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
      $key = $continent['code'];
      $this->derivatives[$key] = $basePluginDefinition;
      $this->derivatives[$key]['id'] = $key;
      $this->derivatives[$key]['label'] = $continent['label'];
      $this->derivatives[$key]['alpha2'] = $key;
    }

    return $this->derivatives;
  }

}

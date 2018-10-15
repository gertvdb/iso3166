<?php

namespace Drupal\iso3166\Plugin\iso3166\Country;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\iso3166\Factory\CountryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Country plugins.
 */
abstract class CountryPluginBase extends PluginBase implements CountryPluginInterface, ContainerFactoryPluginInterface {

  /**
   * The country factory.
   *
   * @var \Drupal\iso3166\Factory\CountryFactory
   */
  protected $countryFactory;

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $pluginId
   *   The plugin id for the plugin instance.
   * @param mixed $pluginDefinition
   *   The plugin implementation definition.
   * @param \Drupal\iso3166\Factory\CountryFactory $countryFactory
   *   The country factory.
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, CountryFactory $countryFactory) {
    parent::__construct($configuration, $pluginId, $pluginDefinition, $countryFactory);
    $this->countryFactory = $countryFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $container->get('iso3166.country_factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function toCountry() {
    return $this->countryFactory->createCountry(
      $this->getPluginDefinition()['label'],
      $this->getPluginDefinition()['alpha2'],
      $this->getPluginDefinition()['alpha3'],
      $this->getPluginDefinition()['numeric'],
      $this->getPluginDefinition()['continent']
    );
  }

}

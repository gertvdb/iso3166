<?php

namespace Drupal\iso3166\Plugin\Iso3166\CountryCollection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface;
use Drupal\iso3166\Factory\CountryCollectionFactory;

/**
 * Provides a collection for all countries in the world.
 *
 * @CountryCollection(
 *   id = "world",
 *   label = @Translation("World"),
 *   countries = {}
 * )
 */
class CountryCollectionWorld extends CountryCollectionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The country manager.
   *
   * @var \Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface
   */
  protected $countryManager;

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $pluginId
   *   The plugin id for the plugin instance.
   * @param mixed $pluginDefinition
   *   The plugin implementation definition.
   * @param \Drupal\iso3166\Factory\CountryCollectionFactory $collectionFactory
   *   The country collection factory.
   * @param \Drupal\iso3166\Plugin\Iso3166\CountryManagerInterface $countryManager
   *   The country manager.
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, CountryCollectionFactory $collectionFactory, CountryManagerInterface $countryManager) {
    parent::__construct($configuration, $pluginId, $pluginDefinition, $collectionFactory);
    $this->countryManager = $countryManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $container->get('iso3166.country_collection_factory'),
      $container->get('plugin.manager.country')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    $countries = [];
    $allCountries = $this->countryManager->getCountries();
    foreach ($allCountries as $country) {
      $countries[] = $country->getAlpha2();
    }

    return $countries;
  }

}

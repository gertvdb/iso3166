<?php

namespace Drupal\iso3166\Plugin\Iso3166\CountryCollection;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\Factory\CountryCollectionFactory;

/**
 * Base class for Country Collection plugins.
 */
abstract class CountryCollectionPluginBase extends PluginBase implements CountryCollectionPluginInterface, ContainerFactoryPluginInterface {

  /**
   * The country collection factory.
   *
   * @var \Drupal\iso3166\Factory\CountryCollectionFactory
   */
  protected $collectionFactory;

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
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, CountryCollectionFactory $collectionFactory) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->collectionFactory = $collectionFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $container->get('iso3166.country_collection_factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->getPluginDefinition()['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCountries() {
    return $this->getPluginDefinition()['countries'];
  }

  /**
   * {@inheritdoc}
   */
  public function toCollection() {
    return $this->collectionFactory->createCountryCollection(
      $this->getLabel(),
      $this->getCountries()
    );
  }

}

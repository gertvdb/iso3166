<?php

namespace Drupal\iso3166\Plugin\Iso3166\Continent;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\iso3166\Factory\ContinentFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Continent plugins.
 */
abstract class ContinentPluginBase extends PluginBase implements ContinentPluginInterface, ContainerFactoryPluginInterface {

  /**
   * The continent factory.
   *
   * @var \Drupal\iso3166\Factory\ContinentFactory
   */
  protected $continentFactory;

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $pluginId
   *   The plugin id for the plugin instance.
   * @param mixed $pluginDefinition
   *   The plugin implementation definition.
   * @param \Drupal\iso3166\Factory\ContinentFactory $continentFactory
   *   The continent factory.
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, ContinentFactory $continentFactory) {
    parent::__construct($configuration, $pluginId, $pluginDefinition, $continentFactory);
    $this->continentFactory = $continentFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $container->get('iso3166.continent_factory')
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
  public function getAlpha2() {
    return $this->getPluginDefinition()['alpha2'];
  }

  /**
   * {@inheritdoc}
   */
  public function toContinent() {
    return $this->continentFactory->createContinent(
      $this->getPluginDefinition()['alpha2']
    );
  }

}

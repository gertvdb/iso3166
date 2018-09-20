<?php

namespace Drupal\iso3166;

use Drupal\Core\Locale\CountryManager;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\iso3166\Plugin\CountryManagerEnrichPluginManager;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ISO316CountryManager.
 *
 * @package Drupal\iso3166
 */
class EnrichedCountryManager extends CountryManager implements EnrichedCountryManagerInterface, ContainerInjectionInterface {

  /**
   * The original country manager.
   *
   * @var \Drupal\Core\Locale\CountryManagerInterface
   */
  protected $countryManager;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The plugin manager for enrich country manager plugins.
   *
   * @var \Drupal\iso3166\Plugin\CountryManagerEnrichPluginManager
   */
  protected $countryManagerEnricher;

  /**
   * ISO3166CountryManager constructor.
   *
   * @param \Drupal\Core\Locale\CountryManagerInterface $countryManager
   *   The original country manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\iso3166\Plugin\CountryManagerEnrichPluginManager $countryManagerEnricher
   *   The module handler.
   */
  public function __construct(CountryManagerInterface $countryManager, ModuleHandlerInterface $module_handler, CountryManagerEnrichPluginManager $countryManagerEnricher) {
    $this->countryManager = $countryManager;
    $this->countryManagerEnricher = $countryManagerEnricher;
    parent::__construct($module_handler);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('iso3166.country_manager.inner'),
      $container->get('module_handler'),
      $container->get('plugin.manager.country_enricher_plugin')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getEnrichedList($originalValueKey = 'name') {
    $enrichedList = [];
    $enrichmentPlugins = $this->countryManagerEnricher->getDefinitions();

    foreach ($enrichmentPlugins as $pluginId => $pluginInfo) {

      /** @var \Drupal\iso3166\Plugin\CountryManagerEnrichPluginInterface $enrichmentInstance */
      $enrichmentInstance = $this->countryManagerEnricher->createInstance($pluginId);
      $enrichment = $enrichmentInstance->getEnrich();
      $enrichmentKey = $enrichmentInstance->getEnrichKey();

      foreach ($this->countryManager->getList() as $alpha2 => $country) {
        $enrichedList[$alpha2][$originalValueKey] = $country;
        if (isset($enrichment[$alpha2])) {
          $enrichedList[$alpha2][$enrichmentKey] = $enrichment[$alpha2];
        }
        else {
          $enrichedList[$alpha2][$enrichmentKey] = NULL;
        }
        ksort($enrichedList[$alpha2]);
      }
    }

    return $enrichedList;
  }

  /**
   * {@inheritdoc}
   */
  public function searchEnrichedList($key, $value) {
    $result = [];

    foreach ($this->getEnrichedList() as $item) {
      if (isset($item[$key]) && $item[$key] === $value) {
        $result[] = $item;
      }
    }

    return $result;
  }

}

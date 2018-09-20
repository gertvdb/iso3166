<?php

namespace Drupal\iso3166\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Country enricher plugin plugins.
 */
interface CountryEnricherPluginInterface extends PluginInspectionInterface {

  /**
   * {@inheritdoc}
   */
  public function getEnrichment();

  /**
   * {@inheritdoc}
   */
  public function getEnrichmentKey();

}

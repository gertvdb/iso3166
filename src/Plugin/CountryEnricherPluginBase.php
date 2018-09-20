<?php

namespace Drupal\iso3166\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Country enricher plugin plugins.
 */
abstract class CountryEnricherPluginBase extends PluginBase implements CountryEnricherPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getEnrichment() {
    return $this->pluginDefinition['enrichment'];

  }

  /**
   * {@inheritdoc}
   */
  public function getEnrichmentKey() {
    return $this->pluginDefinition['enrichment_key'];
  }

}

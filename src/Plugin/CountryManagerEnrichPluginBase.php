<?php

namespace Drupal\iso3166\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Country enricher plugin plugins.
 */
abstract class CountryManagerEnrichPluginBase extends PluginBase implements CountryManagerEnrichPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getEnrich() {
    return $this->pluginDefinition['enrich'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEnrichKey() {
    return $this->pluginDefinition['enrich_key'];
  }

}

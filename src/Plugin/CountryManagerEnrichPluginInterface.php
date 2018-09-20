<?php

namespace Drupal\iso3166\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Country enricher plugin plugins.
 */
interface CountryManagerEnrichPluginInterface extends PluginInspectionInterface {

  /**
   * {@inheritdoc}
   */
  public function getEnrich();

  /**
   * {@inheritdoc}
   */
  public function getEnrichKey();

}

<?php

namespace Drupal\iso3166\Plugin\iso3166\Continent;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Continent plugins.
 */
interface ContinentPluginInterface extends PluginInspectionInterface {

  /**
   * {@inheritdoc}
   */
  public function toContinent();

}

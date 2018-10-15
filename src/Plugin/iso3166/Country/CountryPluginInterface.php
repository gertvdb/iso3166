<?php

namespace Drupal\iso3166\Plugin\iso3166\Country;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Country plugins.
 */
interface CountryPluginInterface extends PluginInspectionInterface {

  /**
   * {@inheritdoc}
   */
  public function toCountry();

}

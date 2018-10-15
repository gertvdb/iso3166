<?php

namespace Drupal\iso3166\Factory;

use Drupal\iso3166\Continent;

/**
 * Defines an factory for creating a continent.
 */
class ContinentFactory {

  /**
   * {@inheritdoc}
   */
  public function createContinent($name, $alpha2) {
    return new Continent($name, $alpha2);
  }

}

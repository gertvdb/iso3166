<?php

namespace Drupal\iso3166\Plugin\Iso3166\CountryCollection;

/**
 * Provides a country collection per continent.
 *
 * @CountryCollection(
 *   id = "continent",
 *   deriver = "Drupal\iso3166\Plugin\Iso3166\CountryCollection\Derivative\CountryCollectionContinentDerivative"
 * )
 */
class CountryCollectionContinent extends CountryCollectionPluginBase {

}

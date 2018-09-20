<?php

namespace Drupal\iso3166\Plugin\CountryEnricherPlugin;

use Drupal\iso3166\Plugin\CountryEnricherPluginBase;

/**
 * Provides a generic ISO3661 enricher.
 *
 * @CountryEnricherPlugin(
 *   id = "iso3661_enricher",
 *   deriver = "Drupal\iso3166\Plugin\Derivative\ISO3166EnricherDerivative"
 * )
 */
class ISO3166Enricher extends CountryEnricherPluginBase {

}

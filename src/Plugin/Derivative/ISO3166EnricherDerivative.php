<?php

namespace Drupal\iso3166\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use League\ISO3166\ISO3166;

/**
 * Provides country enricher plugins for ISO3166.
 */
class ISO3166EnricherDerivative extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $iso = new ISO3166();
    $isoKeys = [ISO3166::KEY_ALPHA2, ISO3166::KEY_ALPHA3, ISO3166::KEY_NUMERIC];

    foreach ($isoKeys as $derivative) {
      $this->derivatives[$derivative] = $base_plugin_definition;
      $this->derivatives[$derivative]['id'] = $derivative;
      $this->derivatives[$derivative]['enrichment_key'] = $derivative;
      $this->derivatives[$derivative]['searchable'] = TRUE;

      $enrichment = [];
      foreach ($iso->all() as $key => $country) {
        $enrichment[$country[ISO3166::KEY_ALPHA2]] = $country[$derivative];
      }

      $this->derivatives[$derivative]['enrichment'] = $enrichment;
    }

    return $this->derivatives;
  }

}

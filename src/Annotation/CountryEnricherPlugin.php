<?php

namespace Drupal\iso3166\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Country enricher plugin item annotation object.
 *
 * @see \Drupal\iso3166\Plugin\CountryEnricherPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class CountryEnricherPlugin extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The enrichment array.
   *
   * @var array
   */
  public $enrichment;

  /**
   * The enrichment key.
   *
   * @var string
   */
  public $enrichmentKey;

}

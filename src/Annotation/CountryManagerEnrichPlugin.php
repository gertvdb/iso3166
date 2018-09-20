<?php

namespace Drupal\iso3166\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a CountryManagerEnrichPlugin annotation object.
 *
 * @see \Drupal\iso3166\Plugin\CountryManagerEnricherPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class CountryManagerEnrichPlugin extends Plugin {

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
   * The array of enrichment data.
   *
   * @var array
   */
  public $enrich = [];

  /**
   * The enrich array key.
   *
   * @var string|null
   */
  public $enrichKey = NULL;

}

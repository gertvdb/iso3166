<?php

namespace Drupal\iso3166\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Country Collection item annotation object.
 *
 * @see \Drupal\iso3166\Plugin\Iso3166\CountryCollectionManager
 * @see plugin_api
 *
 * @Annotation
 */
class CountryCollection extends Plugin {

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
   * The countries in the collection.
   *
   * @var array
   */
  public $countries;

}

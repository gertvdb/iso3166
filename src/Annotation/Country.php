<?php

namespace Drupal\iso3166\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Country item annotation object.
 *
 * @see \Drupal\iso3166\Plugin\CountryManager
 * @see plugin_api
 *
 * @Annotation
 */
class Country extends Plugin {

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
   * The alpha2 code of the country.
   *
   * @var string
   */
  public $alpha2;

  /**
   * The alpha3 code of the country.
   *
   * @var string
   */
  public $alpha3;

  /**
   * The numeric code of the country.
   *
   * @var string
   */
  public $numeric;

  /**
   * The continent code of the country.
   *
   * @var string
   */
  public $continent;

}

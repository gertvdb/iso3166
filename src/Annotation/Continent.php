<?php

namespace Drupal\iso3166\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Continent item annotation object.
 *
 * @see \Drupal\iso3166\Plugin\ContinentManager
 * @see plugin_api
 *
 * @Annotation
 */
class Continent extends Plugin {


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
   * The alpha2 code of the continent.
   *
   * @var string
   */
  public $alpha2;

}

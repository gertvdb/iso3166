<?php

namespace Drupal\iso3166\Plugin\Iso3166\Continent;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Continent plugins.
 */
interface ContinentPluginInterface extends PluginInspectionInterface {

  /**
   * The country label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The country label.
   */
  public function getLabel();

  /**
   * The alpha2 country code.
   *
   * @return string
   *   The alpha2 country code.
   */
  public function getAlpha2();

  /**
   * The continent object.
   *
   * @return \Drupal\iso3166\ContinentInterface
   *   A continent object.
   */
  public function toContinent();

}

<?php

namespace Drupal\iso3166;

use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines an interface for Countries.
 */
class Continent implements ContinentInterface {

  /**
   * The continent name.
   *
   * @var \Drupal\Core\StringTranslation\TranslatableMarkup
   */
  protected $name;

  /**
   * The continent alpha2 code.
   *
   * @var string
   */
  protected $alpha2;

  /**
   * Creates an CountryDerivative object.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $name
   *   The continent name.
   * @param string $alpha2
   *   The continent alpha2 code.
   */
  public function __construct(TranslatableMarkup $name, $alpha2) {
    $this->name = $name;
    $this->alpha2 = $alpha2;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getAlpha2() {
    return $this->alpha2;
  }

}

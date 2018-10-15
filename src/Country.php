<?php

namespace Drupal\iso3166;

use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines an interface for Countries.
 */
class Country implements CountryInterface {

  /**
   * The country name.
   *
   * @var \Drupal\Core\StringTranslation\TranslatableMarkup
   */
  protected $name;

  /**
   * The country alpha2 code.
   *
   * @var string
   */
  protected $alpha2;

  /**
   * The country alpha3 code.
   *
   * @var string
   */
  protected $alpha3;

  /**
   * The country numeric code.
   *
   * @var string
   */
  protected $numeric;

  /**
   * The continent.
   *
   * @var \Drupal\iso3166\ContinentInterface
   */
  protected $continent;

  /**
   * Creates an CountryDerivative object.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $name
   *   The country name.
   * @param string $alpha2
   *   The country alpha2 code.
   * @param string $alpha3
   *   The country alpha3 code.
   * @param string $numeric
   *   The country numeric code.
   * @param \Drupal\iso3166\ContinentInterface|null $continent
   *   The continent code.
   */
  public function __construct(TranslatableMarkup $name, $alpha2, $alpha3, $numeric, $continent = NULL) {
    $this->name = $name;
    $this->alpha2 = $alpha2;
    $this->alpha3 = $alpha3;
    $this->numeric = $numeric;
    $this->continent = $continent;
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

  /**
   * {@inheritdoc}
   */
  public function getAlpha3() {
    return $this->alpha3;
  }

  /**
   * {@inheritdoc}
   */
  public function getNumeric() {
    return $this->numeric;
  }

  /**
   * {@inheritdoc}
   */
  public function getContinent() {
    return $this->continent;
  }

}

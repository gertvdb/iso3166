<?php

namespace Drupal\iso3166;

use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;
use Drupal\Core\TypedData\TypedData;
use Drupal\iso3166\Plugin\Field\FieldType\Iso3166FieldItemInterface;
use InvalidArgumentException;

/**
 * A computed country.
 *
 * Required settings (below the definition's 'settings' key) are:
 *  - countryCode: The country code.
 */
class Iso3166ComputedCountry extends TypedData {

  /**
   * Cached computed country.
   *
   * @var \Drupal\iso3166\CountryInterface|null
   */
  protected $country = NULL;

  /**
   * {@inheritdoc}
   */
  public function __construct(DataDefinitionInterface $definition, $name = NULL, TypedDataInterface $parent = NULL) {
    parent::__construct($definition, $name, $parent);

    if (!$this->getParent() instanceof Iso3166FieldItemInterface) {
      throw new InvalidArgumentException("The country computer will only work on an implementation of the Iso3166FieldItemInterface");
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    if ($this->country !== NULL) {
      return $this->country;
    }

    /** @var \Drupal\iso3166\Plugin\Field\FieldType\Iso3166FieldItemInterface $iso3166FieldItem */
    $iso3166FieldItem = $this->getParent();
    return $iso3166FieldItem->toCountry();
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function setValue($value, $notify = TRUE) {
    $this->country = $value;
    // Notify the parent of any changes.
    if (isset($this->parent)) {
      $this->parent->onChange($this->name);
    }
  }

}

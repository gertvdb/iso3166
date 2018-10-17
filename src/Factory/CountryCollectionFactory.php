<?php

namespace Drupal\iso3166\Factory;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\iso3166\CountryCollection;

/**
 * Defines an factory for creating a country collection.
 */
class CountryCollectionFactory implements ContainerInjectionInterface {

  /**
   * The country factory.
   *
   * @var \Drupal\iso3166\Factory\CountryFactory
   */
  protected $countryFactory;

  /**
   * Creates an CountryCollectionFactory.
   *
   * @param \Drupal\iso3166\Factory\CountryFactory $countryFactory
   *   The country factory.
   */
  public function __construct(CountryFactory $countryFactory) {
    $this->countryFactory = $countryFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('iso3166.country_factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createCountryCollection($label, $countryList) {
    $countries = [];
    foreach ($countryList as $countryItem) {
      $countries[] = $this->countryFactory->createCountry($countryItem);
    }

    return new CountryCollection(
      $label,
      $countries
    );
  }

}

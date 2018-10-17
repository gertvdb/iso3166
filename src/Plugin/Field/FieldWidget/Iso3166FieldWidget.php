<?php

namespace Drupal\iso3166\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Default widget for country.
 *
 * @FieldWidget(
 *   id = "iso3166_default",
 *   label = @Translation("Iso3166 widget"),
 *   field_types = {
 *     "iso3166"
 *   }
 * )
 */
class Iso3166FieldWidget extends WidgetBase {

  /**
   * Get the country factory.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\iso3166\Factory\CountryFactory
   *   The country factory.
   */
  protected function getCountryFactory() {
    return \Drupal::service('iso3166.country_factory');
  }

  /**
   * Get the country manager.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\iso3166\Plugin\iso3166\CountryManagerInterface
   *   The country factory.
   */
  protected function getCountryManager() {
    return \Drupal::service('plugin.manager.country');
  }

  /**
   * Get the country collection manager.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\iso3166\Plugin\iso3166\CountryCollectionManagerInterface
   *   The country factory.
   */
  protected function getCountryCollectionManager() {
    return \Drupal::service('plugin.manager.country_collection');
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $formState) {

    /** @var \Drupal\iso3166\Plugin\Field\FieldType\Iso3166FieldItem $item */
    $item = $items[$delta];

    /** @var \Drupal\iso3166\CountryInterface|null $value */
    $value = $item->toCountry();

    // Get settings.
    $fieldDefinitions = $item->getFieldDefinition();
    $provider = $fieldDefinitions->getSetting('provider');
    $exclude = $fieldDefinitions->getSetting('exclude');
    $includedCountries = array_filter($fieldDefinitions->getSetting('included_countries'));

    // Create a collection.
    $selectedCollection = $this->getCountryCollectionManager()->createInstance($provider);

    /** @var \Drupal\iso3166\CountryCollectionInterface|null $collection */
    $collection = $selectedCollection->toCollection();

    $countryList = $collection->getCountries();
    $countryOptions = $element['#required'] ? [] : ['none' => t('-- None --')];
    foreach ($countryList as $countryItem) {
      if ($exclude && !in_array($countryItem->getAlpha2(), $includedCountries)) {
        continue;
      }

      $countryOptions[$countryItem->getAlpha2()] = $countryItem->getName();
    }

    asort($countryOptions);

    $element['value'] = [
      '#title' => $this->t('Country'),
      '#type' => 'select',
      '#default_value' => $value ? $value->getAlpha2() : array_keys($countryOptions)[0],
      '#options' => $countryOptions,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $formState) {
    $newValues = [];
    foreach ($values as $delta => $value) {
      $country = $this->getCountryFactory()->createCountry($value['value']);
      if ($country) {
        $newValues[$delta] = $country->toArray();
      }
    }
    return $newValues;
  }

}

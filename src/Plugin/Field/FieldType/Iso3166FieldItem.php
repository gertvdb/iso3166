<?php

namespace Drupal\iso3166\Plugin\Field\FieldType;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldType;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Field\FieldItemBase;
use Drupal\iso3166\CountryInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'iso3166' field type.
 *
 * @FieldType(
 *   id = "iso3166",
 *   label = @Translation("Country (Iso3166)"),
 *   description = @Translation("Create and store country information."),
 *   default_widget = "iso3166_default",
 *   default_formatter = "iso3166_default",
 * )
 */
class Iso3166FieldItem extends FieldItemBase implements Iso3166FieldItemInterface {

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
  public static function defaultStorageSettings() {
    return [
      'included_countries' => [],
      'exclude' => 0,
      'provider' => 'world',
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $formState, $hasData) {
    $element = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'storage-settings',
      ],
    ];

    $providerSettings = $this->getSetting('provider');
    $providerFormState = $formState->getValue(['settings', 'provider']);
    $provider = $providerFormState ?: $providerSettings;

    $collectionOptions = [];
    $collectionManager = $this->getCountryCollectionManager();
    $definitions = $collectionManager->getDefinitions();
    foreach ($definitions as $pluginId => $pluginConfig) {
      /* @var \Drupal\iso3166\Plugin\Iso3166\CountryCollection\CountryCollectionPluginInterface $collection */
      $collection = $collectionManager->createInstance($pluginId, $pluginConfig);
      $collectionOptions[$pluginId] = $collection->getLabel();
    }

    $element['provider'] = [
      '#type' => 'select',
      '#title' => $this->t('Provider'),
      '#description' => $this->t('Select the country collection provider to use for the field.'),
      '#required' => TRUE,
      '#multiple' => FALSE,
      '#options' => $collectionOptions,
      '#disabled' => $hasData ? 'disabled' : FALSE,
      '#field_name' => $this->getFieldDefinition()->getName(),
      '#default_value' => $provider,
      '#submit' => [$this, 'submitCallback'],
      '#ajax' => [
        'callback' => [$this, 'refreshCallback'],
        'wrapper' => 'storage-settings',
      ],
    ];

    $excludeFromSettings = $this->getSetting('exclude');
    $excludeFromFormState = $formState->getValue(['settings', 'exclude']);
    $exclude = ($excludeFromFormState === 0 || $excludeFromFormState === 1) ? $excludeFromFormState : $excludeFromSettings;

    $element['exclude'] = [
      '#type' => 'checkbox',
      '#return_value' => 1,
      '#title' => $this->t('Customize countries that are included'),
      '#field_name' => $this->getFieldDefinition()->getName(),
      '#default_value' => $exclude,
      '#submit' => [$this, 'submitCallback'],
      '#ajax' => [
        'callback' => [$this, 'refreshCallback'],
        'wrapper' => 'storage-settings',
      ],
    ];

    $element['included_countries'] = [
      '#type' => 'value',
      '#value' => [],
    ];

    if ($exclude) {
      $includedSettings = $this->getSetting('included_countries');
      $includedFormState = $formState->getValue(['settings', 'included_countries']);
      $includedCountries = $includedFormState ?: $includedSettings;

      $selectedCollection = $collectionManager->createInstance($provider);
      $countries = $selectedCollection->toCollection()->getCountries();
      $countryOptions = [];
      foreach ($countries as $country) {
        $countryOptions[$country->getAlpha2()] = $country->getName();
      }

      asort($countryOptions);

      $element['included_countries'] = [
        '#type' => 'checkboxes',
        '#title' => $this->t('Countries'),
        '#description' => $this->t('Check all countries you want to enable, when no countries are selected all countries will be enabled.'),
        '#options' => $countryOptions,
        '#field_name' => $this->getFieldDefinition()->getName(),
        '#default_value' => $includedCountries,
      ];
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function refreshCallback(array &$form, FormStateInterface $formState) {
    return $form['settings'];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $fieldDefinition) {
    $properties['value'] = DataDefinition::create('any')
      ->setLabel(t('Computed Country'))
      ->setDescription(t('The computed iso3166 country object.'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\iso3166\Iso3166ComputedCountry');

    $properties['alpha2'] = DataDefinition::create('string')
      ->setLabel(t('The alpha2 country code'))
      ->setRequired(TRUE);

    $properties['alpha3'] = DataDefinition::create('string')
      ->setLabel(t('The alpha3 country code'))
      ->setRequired(TRUE);

    $properties['numeric'] = DataDefinition::create('string')
      ->setLabel(t('The numeric country code'))
      ->setRequired(TRUE);

    $properties['continent'] = DataDefinition::create('string')
      ->setLabel(t('The continent code for the country'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $fieldDefinition) {
    return [
      'columns' => [
        'alpha2' => [
          'description' => 'Stores the alpha2 country code value',
          'type' => 'varchar',
          'length' => 2,
          'not null' => FALSE,
        ],
        'alpha3' => [
          'description' => 'Stores the alpha3 country code value',
          'type' => 'varchar',
          'length' => 3,
          'not null' => FALSE,
        ],
        'numeric' => [
          'description' => 'Stores the numeric country code value',
          'type' => 'varchar',
          'length' => 3,
          'not null' => FALSE,
        ],
        'continent' => [
          'description' => 'Stores continent code for the country',
          'type' => 'varchar',
          'length' => 2,
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->toCountry()) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function onChange($propertyName, $notify = TRUE) {
    // Enforce that the computed country is recalculated.
    if (in_array($propertyName, ['alpha2', 'alpha3', 'numeric', 'continent'])) {
      $this->set('value', NULL);
    }
    parent::onChange($propertyName, $notify);
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function setValue($value, $notify = TRUE) {
    // Allow callers to pass a CountryInterface object
    // as the field item value.
    if ($value instanceof CountryInterface) {
      /** @var \Drupal\iso3166\CountryInterface $country */
      $value = $value->toArray();
    }

    parent::setValue($value, $notify);
  }

  /**
   * Get country object.
   *
   * @return \Drupal\iso3166\CountryInterface|null
   *   A country object or NULL
   */
  public function toCountry() {
    return $this->getCountryFactory()->createCountry(
      $this->get('alpha2')->getValue()
    );
  }

}

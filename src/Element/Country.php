<?php

namespace Drupal\iso3166\Element;

use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\Select;

/**
 * Provides a select form element for countries.
 *
 * Usage example:
 * @code
 *
 * $form['country'] = array(
 *   '#type' => 'country',
 *   '#title' => $this->t('Country'),
 *   '#plugin_id' => 'my_country_collection_plugin',
 *   '#plugin_config' => [],
 *   '#multiple' => FALSE,
 *   '#required' => TRUE,
 *   '#excluded_countries' => [],
 * );
 * @endcode
 *
 * @FormElement("country")
 */
class Country extends Select {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#multiple' => FALSE,
      '#process' => [
        [$class, 'processCountry'],
        [$class, 'processSelect'],
        [$class, 'processAjaxForm'],
      ],
      '#pre_render' => [
        [$class, 'preRenderSelect'],
      ],
      '#theme' => 'country',
      '#theme_wrappers' => ['form_element'],
      '#options' => [],
    ];
  }

  /**
   * Process the select.
   *
   * @param array $element
   *   The form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param array $complete_form
   *   The form.
   *
   * @return mixed
   *   The processed form element.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public static function processCountry(array &$element, FormStateInterface $form_state, array &$complete_form) {

    /** @var \Drupal\iso3166\Plugin\Iso3166\CountryCollectionManager $collectionManager */
    $collectionManager = \Drupal::service('plugin.manager.country_collection');

    /** @var \Drupal\iso3166\Plugin\Iso3166\CountryCollection\CountryCollectionPluginInterface $collectionInstance */
    $collectionInstance = $collectionManager->createInstance($element['#plugin_id'], []);
    $countries = $collectionInstance->toCollection()->getCountries();

    $countryOptions = [];
    foreach ($countries as $country) {
      if (!in_array($country->getAlpha2(), $element['#excluded_countries'])) {
        $countryOptions[$country->getAlpha2()] = $country->getName();
      }
    }

    //if (class_exists('Collator') === true) {
      //$collator = new \Collator($user->getCulture());
      //$collator->asort($countryOptions, SORT_LOCALE_STRING);
    //} else {
      asort($countryOptions);
    //}


    $element['#options'] = $countryOptions;

    return $element;
  }

}

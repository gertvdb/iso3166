<?php

namespace Drupal\iso3166\Element;

use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Select;

/**
 * Provides a select form element for countries.
 *
 * Usage example:
 * @code
 *
 * $form['continent'] = array(
 *   '#type' => 'continent',
 *   '#title' => $this->t('Continent'),
 *   '#multiple' => FALSE,
 *   '#required' => TRUE,
 *   '#excluded_continents' => [],
 * );
 * @endcode
 *
 * @FormElement("continent")
 */
class Continent extends Select {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#multiple' => FALSE,
      '#process' => [
        [$class, 'processContinent'],
        [$class, 'processSelect'],
        [$class, 'processAjaxForm'],
      ],
      '#pre_render' => [
        [$class, 'preRenderSelect'],
      ],
      '#theme' => 'continent',
      '#theme_wrappers' => ['form_element'],
      '#options' => [],
    ];
  }

  /**
   * Process the select.
   *
   * @param array $element
   *   The form element.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The form state.
   * @param array $completeForm
   *   The form.
   *
   * @return mixed
   *   The processed form element.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   *
   * @SuppressWarnings(PHPMD.UnusedFormalParameter)
   */
  public static function processContinent(array &$element, FormStateInterface $formState, array &$completeForm) {

    /** @var \Drupal\iso3166\Plugin\Iso3166\ContinentManager $continentManager */
    $continentManager = \Drupal::service('plugin.manager.continent');

    $continentOptions = [];
    $definitions = $continentManager->getDefinitions();
    foreach ($definitions as $pluginId => $pluginConfig) {
      /* @var \Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginInterface $continent */
      $continentInstance = $continentManager->createInstance($pluginId, $pluginConfig);

      /** @var \Drupal\iso3166\Continent $continent */
      $continent = $continentInstance->toContinent();

      if (!in_array($continent->getAlpha2(), $element['#excluded_continents'])) {
        $continentOptions[$continent->getAlpha2()] = $continent->getName();
      }
    }

    asort($continentOptions);
    $element['#options'] = $continentOptions;

    return $element;
  }

}

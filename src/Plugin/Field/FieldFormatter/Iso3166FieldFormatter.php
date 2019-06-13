<?php

namespace Drupal\iso3166\Plugin\Field\FieldFormatter;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Default formatter for iso3166.
 *
 * @FieldFormatter(
 *   id = "iso3166_default",
 *   label = @Translation("Iso3166 formatter"),
 *   field_types = {
 *     "iso3166"
 *   }
 * )
 */
class Iso3166FieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    /* @var \Drupal\iso3166\Plugin\Field\FieldType\Iso3166FieldItemInterface $item */
    foreach ($items as $delta => $item) {
      $country = $item->toCountry();
      if ($country) {

        $elements[$delta] = [
          '#markup' => $country->getName() . ' (' . $country->getAlpha2() . ')',
        ];
      }
    }

    return $elements;
  }

}

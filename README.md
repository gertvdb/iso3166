Description
-----------
This module provides countries and contintents based on the official iso3166 data.
It provides both countries and continents as plugins and maps them together.
Since the countries and continents are plugin the end user can easily add it's own
or override the existing.

Installation
------------
To install this module, do the following:

With composer:
1. ```composer require gertvdb/iso3166```


Examples
------------
You can find an example on how to use the iso3166 module below. 
The module provides a service to work with the plugin data.  

#### Using the plugin managers.
The plugin managers provide some extra methods to easily get country and continent data.


``` 
  /** @var \Drupal\iso3166\Plugin\CountryManager $pluginManager */
  $pluginManager = \Drupal::service('plugin.manager.country');
  
  $belguim = $pluginManager->getCountry('BE');
  $allCountries = $pluginManager->getCountries();
  
```

``` 
  /** @var \Drupal\iso3166\Plugin\ContinentManager $pluginManager */
  $pluginManager = \Drupal::service('plugin.manager.continent');
  
  $europe = $pluginManager->getContinent('EU');
  $allContinents = $pluginManager->getContinents();
  
```

#### Using the service.
The service provides several methods to work with country and continent data.

``` 
  /** @var \Drupal\iso3166\Iso3166 $service */
  $service = \Drupal::service('iso3166');
  
  $continentOfBelgium = $service->getContinentByCountry('BE');
  $allCountriesInEurope = $service->getCountriesByContinent('EU');
  
```

#### Changing plugin data.
To change data from the plugin you need to provide an alter hook. Or if you don't
like hooks, have a look at **hook_event_dispatcher** module and dispatch 
an iso3166_country_info_alter event.

``` 
  /**
   * Implements hook_iso3166_country_info_alter().
   */
  function MY_MODULE_iso3166_country_info_alter(array &$definitions) {
    $definitions['country:BE']['label'] = t('Other name for belgium');
  }
  
```

#### Adding data.
Since both continents, countries and county collections are plugin you can easily provide your own.
Below example will add "Neverland" to the list of countries in Europe. But you can
as well provide a new continent to add it to in the same manner.

``` 
   
  namespace Drupal\MY_MODULE\Plugin\iso3166\Country;
  
  use Drupal\Core\Annotation\Translation;
  use Drupal\iso3166\Annotation\Country;
  use Drupal\iso3166\Plugin\iso3166\Country\CountryPluginBase;
  
  /**
   * Provides a country.
   *
   * @Country(
   *   id = "country_neverland",
   *   label = @Translation("Neverland"),
   *   alpha2 = "NV",
   *   alpha3 = "NVL",
   *   numeric = "999",
   *   continent = "EU"
   * )
   */
  class Neverland extends CountryPluginBase {}

  
```

``` 
   
  namespace Drupal\MY_MODULE\Plugin\iso3166\Continent;
  
  use Drupal\Core\Annotation\Translation;
  use Drupal\iso3166\Annotation\Continent;
  use Drupal\iso3166\Plugin\Iso3166\Continent\ContinentPluginBase;
  
  /**
   * Provides a continent.
   *
   * @Continent(
   *   id = "continent_zealandia",
   *   label = @Translation("Zealandia"),
   *   alpha2 = "ZL",
   * )
   */
  class Zealandia extends ContinentPluginBase {}

  
```

``` 
   
    namespace Drupal\MY_MODULE\Plugin\iso3166\CountryCollection;
    
    use Drupal\Core\Annotation\Translation;
    use Drupal\iso3166\Annotation\CountryCollection;
    use Drupal\iso3166\Plugin\Iso3166\CountryCollection\CountryCollectionPluginBase;
    
    /**
     * Provides a country collection.
     *
     * @CountryCollection(
     *   id = "benelux",
     *   label = @Translation("Benelux"),
     *   countries={"BE","NL","LU"}
     * )
     */
    class Benelux extends CountryCollectionPluginBase {}
  
```



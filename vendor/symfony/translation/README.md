Translation Component
=====================

<<<<<<< HEAD
Translation provides tools for loading translation files and generating
translated strings from these including support for pluralization.

```php
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\ArrayLoader;

$translator = new Translator('fr_FR', new MessageSelector());
$translator->setFallbackLocales(array('fr'));
$translator->addLoader('array', new ArrayLoader());
$translator->addResource('array', array(
    'Hello World!' => 'Bonjour',
), 'fr');

echo $translator->trans('Hello World!')."\n";
```
=======
The Translation component provides tools to internationalize your application.
>>>>>>> git-aline/master/master

Resources
---------

<<<<<<< HEAD
Silex integration:

https://github.com/silexphp/Silex/blob/master/src/Silex/Provider/TranslationServiceProvider.php

Documentation:

https://symfony.com/doc/2.7/book/translation.html

You can run the unit tests with the following command:

    $ cd path/to/Symfony/Component/Translation/
    $ composer install
    $ phpunit
=======
  * [Documentation](https://symfony.com/doc/current/components/translation/index.html)
  * [Contributing](https://symfony.com/doc/current/contributing/index.html)
  * [Report issues](https://github.com/symfony/symfony/issues) and
    [send Pull Requests](https://github.com/symfony/symfony/pulls)
    in the [main Symfony repository](https://github.com/symfony/symfony)
>>>>>>> git-aline/master/master

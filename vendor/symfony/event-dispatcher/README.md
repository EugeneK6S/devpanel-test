EventDispatcher Component
=========================

<<<<<<< HEAD
The Symfony EventDispatcher component implements the Mediator pattern in a
simple and effective way to make your projects truly extensible.

```php
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

$dispatcher = new EventDispatcher();

$dispatcher->addListener('event_name', function (Event $event) {
    // ...
});

$dispatcher->dispatch('event_name');
```
=======
The EventDispatcher component provides tools that allow your application
components to communicate with each other by dispatching events and listening to
them.
>>>>>>> git-aline/master/master

Resources
---------

<<<<<<< HEAD
You can run the unit tests with the following command:

    $ cd path/to/Symfony/Component/EventDispatcher/
    $ composer install
    $ phpunit
=======
  * [Documentation](https://symfony.com/doc/current/components/event_dispatcher/index.html)
  * [Contributing](https://symfony.com/doc/current/contributing/index.html)
  * [Report issues](https://github.com/symfony/symfony/issues) and
    [send Pull Requests](https://github.com/symfony/symfony/pulls)
    in the [main Symfony repository](https://github.com/symfony/symfony)
>>>>>>> git-aline/master/master

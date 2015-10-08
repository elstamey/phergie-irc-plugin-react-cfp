# phergie/phergie-irc-plugin-react-cfp

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin for To list the currently open calls for papers.

[![Build Status](https://secure.travis-ci.org/elstamey/phergie-irc-plugin-react-cfp.png?branch=master)](http://travis-ci.org/elstamey/phergie-irc-plugin-react-cfp)

## Install

The recommended method of installation is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "phergie/phergie-irc-plugin-react-cfp": "dev-master"
    }
}
```

See Phergie documentation for more information on
[installing and enabling plugins](https://github.com/phergie/phergie-irc-bot-react/wiki/Usage#plugins).

## Configuration

```php
return [
    'plugins' => [
        // configuration
        new \Phergie\Irc\Plugin\React\Cfp\Plugin([



        ])
    ]
];
```

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

## License

Released under the BSD License. See `LICENSE`.

Zf2AMQPCarapace
=======================

[![Build Status](https://travis-ci.org/vuhl/zf2-amqp-carapace.svg)](https://travis-ci.org/vuhl/zf2-amqp-carapace)

Introduction
------------
Zf2AMQPCarapace is a wrapper for "vuhl/AMQPCarapace" which makes using AMQP in PHP extremely simple. Please refer to examples below
to see this for yourself.

Important Notes
---------------
- Zf2AMQPCarapace currently only has publish capabilities. Consuming and other abilities may be added in the future.
- Mandatory flag on a message is not currently supported. You should keep this flag as false otherwise an exception will be thrown.

Installation Using Composer
---------------------------
Add "vu/zf2-amqp-carapace" to the require section of your composer.json file and run a respective install or update.
For more information on Composer, please visit [their website](https://getcomposer.org/).

Basic Usage
-----------

Setup Configuration
-------------------
Inside one of your Zf2 config files, add basic configuration for your connection, transport, message, and application. You can
have any number of settings for each category.

- **Connection:** Settings related to creating an AMQP connection
- **Transport:** Defines exchange-specific settings such as what exchange to hit, routing keys, and more
- **Message:** Basic predefined message settings
- **Application:** Predefined connection, transport, and message settings for a specific application. This uses settings you have already
defined for connection, transport, and message.

Example:

```php
'AMQPCarapace' => [
    'connection' => [
        'connection_rabbit' => [
            'host'     => '0.0.0.0',
            'port'     => 0000,
            'user'     => 'username',
            'password' => 'password',
        ]
    ],
    'transport' => [
        'php_exchange' => [
            'exchange' => 'php_exchange',
            'routing_key' => 'php_test',
        ],
        'other_exchange' => [
            'exchange' => 'other_php_exchange',
            'routing_key' => 'rawr'
        ]
    ],
    'message' => [
        'text/plain' => [
            'content_type' => 'text/plain',
            'content_encoding' => 'UTF-8',
        ],
        'json' => [
            'content_type' => 'application/json',
            'content_encoding' => 'UTF-8'
        ]
    ],
    'application' => [
        //Every application config MUST include a valid connection, transport, and message config name
        'MyApp' => [
            'connection' => 'connection_rabbit',
            'transport' => 'php_exchange',
            'message' => 'text/plain'
        ],
        'AnotherApp' => [
            'connection' => 'connection_rabbit',
            'transport' => 'other_exchange',
            'message' => 'json'
        ]
    ]
]
```

Creating an AMQPPublisher
--------------------
The easiest way to publish a message is to use the PublisherFactory. The main purpose of the PublisherFactory is to use
predefined settings from the 'application' section of your configuration in order to create an AMQPPublisher. You may, though,
pass in custom settings to create an AMQPPublisher as well. Example:

```php
//Easiest way using predefined application settings
$publisher_factory = new Vu\Zf2AMQPCarapace\Publisher\PublisherFactory();
$myapp_amqp_publisher = $publisher_factory->getPublisher('MyApp');

//You may also create an AMQPPublisher manually using Connection, Transport, and Message objects
$connection_factory = new Vu\Zf2AMQPCarapace\Factory\Connection();
$amqp_connection = $connection_factory->create('connection_rabbit'); //Uses predefined connection config
//Create transport and message objects using Transport and Message factories in the same manner...
//More information on Connection, Transport, and Message factories are listed further down on this page
$manual_amqp_publisher = $publisher_factory->makePublisher($amqp_connection, $amqp_transport, $amqp_message);

//Lastly, you may create an AMQPPublisher by passing in an array of configuration
$config = [
    'connection' => [/* connection settings */],
    'transport' => [/* transport settings */],
    'message' => [/* message settings */]
];
$manual_amqp_publisher = $publisher_factory->makePublisherFromConfiguration($config);
```

Using AMQPPublisher
-------------------
Once you have an AMQPPublisher setup, you will easily be able to publish messages to whatever exchange you have defined.
The AMQPPublisher will take care of creating and closing AMQP channels for you.

```php
//Publish a single message
$my_first_message = "This will be the first message I publish!";
$myapp_amqp_publisher->basicPublish($my_first_message);
$myapp_amqp_publisher->basicPublish("I also want to publish this message");

//Publish multiple messages
$array_of_strings = [
    "First!",
    "Second...",
    "Tres!!"
];
$myapp_amqp_publisher->batchBasicPublish($array_of_strings);
```

Chaining the PublisherFactory and AMQPPublisher
-----------------------------------------------
The PublisherFactory and AMQPPublisher can be chained together.

```php
$publisher_factory->getPublisher('AnotherApp')->basicPublish("Here is my message!");
```

Using the Connection, Transport, and Message Factories
------------------------------------------------------
The Connection, Transport, and Message factories all implement the IFactory interface which specifies two methods - create and
createFromArray. They will return a respective AMQPCarapace Connection, Transport, or Message object.

- **create** - creates from predefined configuration as noted above. Example:

    ```php
    $factory->create('config_name');
    ```
- **createFromArray** - creates from configuration passed in as an array. Example:

    ```php
    $factory->createFromArray([/* config settings*/]);
    ```

AMQPCarapace
------------
For more information on the standalone AMQPCarapace, please view the vuhl\AMQPCarapace page

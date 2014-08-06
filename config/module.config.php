<?php
return array(
    /**
     * EXAMPLE CONFIGURATION
     */
    /*
    'AMQPCarapace' => [
        'connection' => [
            'connection_rabbit' => [
                //Required Params
                'host'     => '0.0.0.0',
                'port'     => 0000,
                'user'     => 'username',
                'password' => 'password',

                //Optional Params - Don't include if you will not use
                'vhost' => "/",
                'insist' => false,
                'login_method' => "AMQPLAIN",
                'login_response' => null,
                'locale' => "en_US",
                'connection_timeout' => 3,
                'read_write_timeout' => 3,
                'context' => null
            ]
        ],
        'transport' => [
            'php_exchange' => [
                //Suggested Params
                'exchange' => 'php_exchange',
                'routing_key' => 'php_test',

                //Optional Params - Don't include if you will not use
                'mandatory' => false,
                'immediate' => false,
                'ticket' => null
            ]
        ],
        'message' => [
            'text/plain' => [
                //Suggested Params
                'content_type' => 'text/plain',
                'content_encoding' => 'UTF-8',

                //Optional - Don't include if you will not use
                'application_headers' => [],
                'delivery_mode' => 0,
                'priority' => 1,
                'correlation_id' => 'id',
                'reply_to' => 'someone',
                'expiration' => 'expiration',
                'message_id' => 'message id',
                'timestamp' => 'timestamp',
                'type' => 'type',
                'user_id' => 'user id',
                'app_id' => 'app id',
                'cluster_id' => 'cluster id'
            ]
        ],
        'application' => [
            //Every application config MUST include a valid connection, transport, and message config name
            'MyApp' => [
                'connection' => 'connection_rabbit',
                'transport' => 'php_exchange',
                'message' => 'text/plain'
            ]
        ]
    ]
    */
);

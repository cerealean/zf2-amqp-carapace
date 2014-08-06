<?php
namespace ZF2AMQPCarapace;

class Module
{

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig(){
        return [
            'invokables' => [
                'AMQPCarapace\Connection\Connection'            => '\Vu\AMQPCarapace\Connection\Connection',
                'Vu\Zf2AMQPCarapace\Factory\Connection'         => 'Vu\Zf2AMQPCarapace\Factory\Connection',
                'Vu\Zf2AMQPCarapace\Factory\Message'            => 'Vu\Zf2AMQPCarapace\Factory\Message',
                'Vu\Zf2AMQPCarapace\Factory\Transport'          => 'Vu\Zf2AMQPCarapace\Factory\Transport',
                'Vu\Zf2AMQPCarapace\Publisher\PublisherFactory' => 'Vu\Zf2AMQPCarapace\Publisher\PublisherFactory'
            ]
        ];
    }

}

<?php


namespace Vu\Zf2AMQPCarapace\Publisher;

use Phake;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2TestExtensions\Test\Service\AbstractServiceLocatorAwareServiceTest;

class PublisherFactoryTest extends AbstractServiceLocatorAwareServiceTest {

    /**
     * @var PublisherFactory
     */
    protected $service;

    /**
     * @var \Vu\AMQPCarapace\Connection\Connection
     */
    protected $connection;

    /**
     * @var \Vu\AMQPCarapace\Model\Transport
     */
    protected $transport;

    /**
     * @var \Vu\AMQPCarapace\Model\Message
     */
    protected $message;

    /**
     * @var \Vu\Zf2AMQPCarapace\Factory\Connection
     */
    protected $connection_factory;

    /**
     * @var \Vu\Zf2AMQPCarapace\Factory\Transport
     */
    protected $transport_factory;

    /**
     * @var \Vu\Zf2AMQPCarapace\Factory\Message
     */
    protected $message_factory;

    function getClassName () {
        return 'Vu\Zf2AMQPCarapace\Publisher\PublisherFactory';
    }

    public function setUp(){
        parent::setUp();
        $this->connection         = Phake::mock('\Vu\AMQPCarapace\Connection\Connection');
        $this->transport          = Phake::mock('\Vu\AMQPCarapace\Model\Transport');
        $this->message            = Phake::mock('\Vu\AMQPCarapace\Model\Message');
        $this->connection_factory = Phake::mock('\Vu\Zf2AMQPCarapace\Factory\Connection');
        $this->transport_factory  = Phake::mock('\Vu\Zf2AMQPCarapace\Factory\Transport');
        $this->message_factory    = Phake::mock('\Vu\Zf2AMQPCarapace\Factory\Message');
        $this->service_locator->setService('Config', $this->getConfig());
        $this->service_locator->setService('Vu\Zf2AMQPCarapace\Factory\Connection', $this->connection_factory);
        $this->service_locator->setService('Vu\Zf2AMQPCarapace\Factory\Transport', $this->transport_factory);
        $this->service_locator->setService('Vu\Zf2AMQPCarapace\Factory\Message', $this->message_factory);
    }

    /**
     * @return array
     */
    private function getConfig(){
        return [
            'AMQPCarapace' => [
                'connection' => [
                    'Default' => $this->getConnectionConfiguration()
                ],
                'transport' => [
                    'Default' => $this->getTransportConfiguration()
                ],
                'message' => [
                    'Default' => $this->getMessageConfiguration()
                ],
                'application' => [
                    'MyApplication' => [
                        'connection' => 'Default',
                        'transport'  => 'Default',
                        'message'    => 'Default'
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getMessageConfiguration(){
        return [
            'content_type'        => 'content-type',
            'content_encoding'    => 'content-encoding',
            'application_headers' => ['rawr'],
            'delivery_mode'       => 0,
            'priority'            => 1,
            'correlation_id'      => 'correlation_id',
            'reply_to'            => 'reply_to',
            'expiration'          => 'expiration',
            'message_id'          => 'message_id',
            'timestamp'           => 'timestamp',
            'type'                => 'type',
            'user_id'             => 'user_id',
            'app_id'              => 'app_id',
            'cluster_id'          => 'cluster_id'
        ];
    }

    /**
     * @return array
     */
    private function getTransportConfiguration(){
        return [
            'exchange'    => 'rawr_exchange',
            'routing_key' => 'rawrz_routing_key',
            'mandatory'   => false,
            'immediate'   => false,
            'ticket'      => null
        ];
    }

    /**
     * @return array
     */
    private function getConnectionConfiguration(){
        return [
            'host'     => '5.2.3.4',
            'port'     => 0000,
            'user'     => 'john',
            'password' => 'doe'
        ];
    }

    public function test_makePublisherShouldReturnInstanceOfAMQPPublisher(){
        $expected = 'Vu\Zf2AMQPCarapace\Publisher\AMQPPublisher';

        $actual = $this->service->makePublisher($this->connection, $this->transport, $this->message);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_getPublisherShouldReturnInstanceOfAMQPPublisher(){
        $expected = 'Vu\Zf2AMQPCarapace\Publisher\AMQPPublisher';
        $application_name = 'MyApplication';
        Phake::when($this->connection_factory)
            ->create("Default")
            ->thenReturn($this->connection);
        Phake::when($this->transport_factory)
            ->create("Default")
            ->thenReturn($this->transport);
        Phake::when($this->message_factory)
            ->create("Default")
            ->thenReturn($this->message);

        $actual = $this->service->getPublisher($application_name);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_getPublisherShouldThrowConfigurationNotFoundExceptionIfApplicationNotFoundInListOfApplications(){
        $expected = '\Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException';
        $application_name = 'Will not be found';

        try{
            $this->service->getPublisher($application_name);
        }
        catch(ConfigurationNotFoundException $configuration_not_found_exception){}

        $this->assertInstanceOf($expected, $configuration_not_found_exception);
    }

    public function test_makePublisherFromConfigurationShouldReturnInstanceOfAMQPPublisher(){
        $expected = 'Vu\Zf2AMQPCarapace\Publisher\AMQPPublisher';
        Phake::when($this->connection_factory)
            ->createFromArray($this->getConnectionConfiguration())
            ->thenReturn($this->connection);
        Phake::when($this->transport_factory)
            ->createFromArray($this->getTransportConfiguration())
            ->thenReturn($this->transport);
        Phake::when($this->message_factory)
            ->createFromArray($this->getMessageConfiguration())
            ->thenReturn($this->message);

        $actual = $this->service->makePublisherFromConfiguration([
            'connection' => $this->getConnectionConfiguration(),
            'transport'  => $this->getTransportConfiguration(),
            'message'    => $this->getMessageConfiguration()
        ]);

        $this->assertInstanceOf($expected, $actual);
    }

}
 
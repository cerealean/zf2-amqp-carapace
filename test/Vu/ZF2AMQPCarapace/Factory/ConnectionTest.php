<?php


namespace Vu\Zf2AMQPCarapace\Factory;


use Phake;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2TestExtensions\Test\Service\AbstractServiceLocatorAwareServiceTest;

class ConnectionTest extends AbstractServiceLocatorAwareServiceTest {

    /**
     * @var \Vu\AMQPCarapace\Connection\Connection
     */
    protected $amqp_carapace_connection;

    /**
     * @var Connection
     */
    protected $service;

    function getClassName () {
        return 'Vu\Zf2AMQPCarapace\Factory\Connection';
    }

    public function setUp(){
        parent::setUp();
        $this->amqp_carapace_connection = Phake::mock('\Vu\AMQPCarapace\Connection\Connection');
        $this->service_locator->setService('AMQPCarapace\Connection\Connection', $this->amqp_carapace_connection);
        $this->service_locator->setService('Config', $this->getConfig());
    }

    private function getConfig(){
        return [
            'AMQPCarapace' => [
                'connection' => [
                    'Default' => [
                        'host' => '5.2.3.4',
                        'port' => 0000,
                        'user' => 'john',
                        'password' => 'doe'
                    ]
                ]
            ]
        ];
    }

    public function test_createShouldReturnInstanceOfAMQPCarapaceConnection(){
        $expected = '\Vu\AMQPCarapace\Connection\Connection';
        $factory = 'Default';

        $actual = $this->service->create($factory);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_createShouldCallAMQPCarapaceConnectionConnect(){
        $factory_name = 'Default';

        $this->service->create($factory_name);

        Phake::verify($this->amqp_carapace_connection)
            ->connect(Phake::anyParameters());
    }

    public function test_createShouldThrowConfigurationNotFoundExceptionIfConfigurationIsNotFoundInListOfConnections(){
        $factory_name = 'This should not be found';
        $expected = 'Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException';

        try{
            $this->service->create($factory_name);
        }
        catch(ConfigurationNotFoundException $configuration_not_found_exception){};

        $this->assertInstanceOf($expected, $configuration_not_found_exception);
    }

    public function test_createFromArrayShouldReturnInstanceOfAMQPCarapaceConnection(){
        $expected = '\Vu\AMQPCarapace\Connection\Connection';
        $connection_settings = $this->getConfig();

        $actual = $this->service->createFromArray($connection_settings);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_createFromArrayShouldCallAMQPCarapaceConnectionConnect(){
        $connection_settings = $this->getConfig();

        $this->service->createFromArray($connection_settings);

        Phake::verify($this->amqp_carapace_connection)
            ->connect(Phake::anyParameters());
    }

}
 
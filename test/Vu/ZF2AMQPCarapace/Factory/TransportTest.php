<?php


namespace Vu\Zf2AMQPCarapace\Factory;


use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2TestExtensions\Test\Service\AbstractServiceLocatorAwareServiceTest;

class TransportTest extends AbstractServiceLocatorAwareServiceTest {

    /**
     * @var Transport
     */
    protected $service;

    function getClassName () {
        return 'Vu\Zf2AMQPCarapace\Factory\Transport';
    }

    public function setUp(){
        parent::setUp();
        $this->service_locator->setService('Config', $this->getConfig());
    }

    private function getConfig(){
        return [
            'AMQPCarapace' => [
                'transport' => [
                    'Default' => $this->getDefaultConfiguration()
                ]
            ]
        ];
    }

    private function getDefaultConfiguration(){
        return [
            'exchange' => 'rawr_exchange',
            'routing_key' => 'rawrz_routing_key',
            'mandatory' => false,
            'immediate' => false,
            'ticket' => null
        ];
    }

    public function test_createShouldReturnInstanceOfTransportModel(){
        $expected = '\Vu\AMQPCarapace\Model\Transport';
        $factory_name = "Default";

        $actual = $this->service->create($factory_name);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_createShouldReturnTransportModelWithMatchingExchange(){
        $expected = "rawr_exchange";
        $factory_name = "Default";

        $transport_model = $this->service->create($factory_name);
        $actual = $transport_model->exchange;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnTransportModelWithMatchingRoutingKey(){
        $expected = "rawrz_routing_key";
        $factory_name = "Default";

        $transport_model = $this->service->create($factory_name);
        $actual = $transport_model->routing_key;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnTransportModelWithMatchingMandatory(){
        $expected = false;
        $factory_name = "Default";

        $transport_model = $this->service->create($factory_name);
        $actual = $transport_model->mandatory;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnTransportModelWithMatchingImmediate(){
        $expected = false;
        $factory_name = "Default";

        $transport_model = $this->service->create($factory_name);
        $actual = $transport_model->immediate;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnTransportModelWithMatchingTicket(){
        $expected = null;
        $factory_name = "Default";

        $transport_model = $this->service->create($factory_name);
        $actual = $transport_model->ticket;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldThrowConfigurationNotFoundExceptionIfTransportConfigurationNotFoundInListOfTransports(){
        $transport_name = "This should not be found";
        $expected = 'Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException';

        try{
            $this->service->create($transport_name);
        }
        catch(ConfigurationNotFoundException $configuration_not_found_exception){};

        $this->assertInstanceOf($expected, $configuration_not_found_exception);
    }

    public function test_createFromArrayShouldReturnInstanceOfTransportModel(){
        $expected = '\Vu\AMQPCarapace\Model\Transport';
        $configuration = $this->getDefaultConfiguration();

        $actual = $this->service->createFromArray($configuration);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_createFromArrayShouldReturnTransportModelWithMatchingExchange(){
        $expected = "rawr_exchange";
        $configuration = $this->getDefaultConfiguration();

        $transport_model = $this->service->createFromArray($configuration);
        $actual = $transport_model->exchange;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnTransportModelWithMatchingRoutingKey(){
        $expected = "rawrz_routing_key";
        $configuration = $this->getDefaultConfiguration();

        $transport_model = $this->service->createFromArray($configuration);
        $actual = $transport_model->routing_key;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnTransportModelWithMatchingMandatory(){
        $expected = false;
        $configuration = $this->getDefaultConfiguration();

        $transport_model = $this->service->createFromArray($configuration);
        $actual = $transport_model->mandatory;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnTransportModelWithMatchingImmediate(){
        $expected = false;
        $configuration = $this->getDefaultConfiguration();

        $transport_model = $this->service->createFromArray($configuration);
        $actual = $transport_model->immediate;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnTransportModelWithMatchingTicket(){
        $expected = null;
        $configuration = $this->getDefaultConfiguration();

        $transport_model = $this->service->createFromArray($configuration);
        $actual = $transport_model->ticket;

        $this->assertEquals($expected, $actual);
    }

}
 
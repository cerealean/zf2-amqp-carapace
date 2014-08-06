<?php


namespace Vu\Zf2AMQPCarapace\Factory;


use Zend\Stdlib\Hydrator\ObjectProperty;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2AMQPCarapace\AbstractFactory;

class Transport extends AbstractFactory implements IFactory {

    /**
     * @param string $factory_name
     * @return \Vu\AMQPCarapace\Model\Transport
     */
    public function create ($factory_name) {
        $transport_configuration = $this->getTransportConfiguration($factory_name);
        $transport_model = $this->generateTransportModel($transport_configuration);

        return $transport_model;
    }

    /**
     * @param array $configuration
     * @return \Vu\AMQPCarapace\Model\Transport
     */
    public function createFromArray (array $configuration) {
        return $this->generateTransportModel($configuration);
    }

    /**
     * @return array
     */
    private function getTransportConfigurations(){
        return $this->getAmqpConfig("transport");
    }

    /**
     * @param $configuration
     * @return array
     * @throws \Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException
     */
    private function getTransportConfiguration($configuration){
        $transport_configurations = $this->getTransportConfigurations();
        if(!array_key_exists($configuration, $transport_configurations)){
            throw new ConfigurationNotFoundException($configuration . " not found in array of transports");
        }

        return $transport_configurations[$configuration];
    }

    /**
     * @param array $transport_configuration
     * @return \Vu\AMQPCarapace\Model\Transport
     */
    private function generateTransportModel(array $transport_configuration){
        $transport_model = new \Vu\AMQPCarapace\Model\Transport();
        $hydrator = new ObjectProperty();

        $hydrator->hydrate($transport_configuration, $transport_model);

        return $transport_model;
    }

}
 
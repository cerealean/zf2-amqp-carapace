<?php


namespace Vu\Zf2AMQPCarapace\Factory;


use Zend\Stdlib\Hydrator\ObjectProperty;
use Vu\Zf2AMQPCarapace\AbstractFactory;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;

class Message extends AbstractFactory implements IFactory {

    /**
     * @param string $factory_name
     * @return \Vu\AMQPCarapace\Model\Message
     */
    public function create ($factory_name) {
        $message_configuration = $this->getMessageConfiguration($factory_name);
        $transport_model = $this->generateMessageModel($message_configuration);

        return $transport_model;
    }

    /**
     * @param array $configuration
     * @return \Vu\AMQPCarapace\Model\Message
     */
    public function createFromArray (array $configuration) {
        $transport_model = $this->generateMessageModel($configuration);

        return $transport_model;
    }

    /**
     * @return array
     */
    private function getMessageConfigurations(){
        return $this->getAmqpConfig("message");
    }

    /**
     * @param $configuration
     * @return array
     * @throws \Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException
     */
    private function getMessageConfiguration($configuration){
        $message_configurations = $this->getMessageConfigurations();
        if(!array_key_exists($configuration, $message_configurations)){
            throw new ConfigurationNotFoundException($configuration . " not found in array of messages");
        }

        return $message_configurations[$configuration];
    }

    /**
     * @param array $message_configuration
     * @return \Vu\AMQPCarapace\Model\Message
     */
    private function generateMessageModel(array $message_configuration){
        $message_model = new \Vu\AMQPCarapace\Model\Message();
        $hydrator = new ObjectProperty();

        $hydrator->hydrate($message_configuration, $message_model);

        return $message_model;
    }

}
 
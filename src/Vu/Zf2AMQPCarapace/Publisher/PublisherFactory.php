<?php


namespace Vu\Zf2AMQPCarapace\Publisher;


use Vu\AMQPCarapace\Connection\Connection;
use Vu\AMQPCarapace\Model\Message;
use Vu\AMQPCarapace\Model\Transport;
use Vu\Zf2AMQPCarapace\AbstractFactory;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;

class PublisherFactory extends AbstractFactory {

    /**
     * @param string $application_name
     * @return AMQPPublisher
     *
     * Create an AMQPPublisher from settings in your ZF2 configuration file
     */
    public function getPublisher($application_name){
        $application_configuration = $this->getApplicationConfiguration($application_name);
        $connection                = $this->createConnectionByConnectionName($application_configuration['connection']);
        $transport                 = $this->createTransportByTransportName($application_configuration['transport']);
        $message                   = $this->createMessageByMessageName($application_configuration['message']);
        $amqp_publisher            = $this->makePublisher($connection, $transport, $message);

        return $amqp_publisher;
    }

    /**
     * @param Connection $connection
     * @param Transport $transport
     * @param Message $message
     * @return AMQPPublisher
     *
     * Create an AMQPPublisher from AMQPCarapace connection, transport, and message objects
     */
    public function makePublisher (Connection $connection, Transport $transport, Message $message) {
        $amqp_publisher = new AMQPPublisher();
        $amqp_publisher->setConnection($connection);
        $amqp_publisher->setTransport($transport);
        $amqp_publisher->setMessage($message);

        return $amqp_publisher;
    }

    /**
     * @param array $configuration
     * @return AMQPPublisher
     *
     * Create an AMQPPublisher from an array of configuration
     */
    public function makePublisherFromConfiguration (array $configuration) {
        $connection     = $this->createConnectionByConfiguration($configuration['connection']);
        $transport      = $this->createTransportByConfiguration($configuration['transport']);
        $message        = $this->createMessageByConfiguration($configuration['message']);
        $amqp_publisher = $this->makePublisher($connection, $transport, $message);

        return $amqp_publisher;
    }

    /**
     * @param $application_name
     * @return array
     * @throws \Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException
     */
    private function getApplicationConfiguration($application_name){
        $application_configurations = $this->getApplicationConfigurations();
        if(!array_key_exists($application_name, $application_configurations)){
            throw new ConfigurationNotFoundException($application_name . " not found in array of applications");
        }

        return $application_configurations[$application_name];
    }

    /**
     * @return array
     */
    private function getApplicationConfigurations(){
        return $this->getAmqpConfig("application");
    }

    /**
     * @param string $connection_name
     * @return Connection
     */
    private function createConnectionByConnectionName($connection_name){
        $connection_factory = $this->getConnectionFactory();

        return $connection_factory->create($connection_name);
    }

    /**
     * @param string $transport_name
     * @return Transport
     */
    private function createTransportByTransportName($transport_name){
        $transport_factory = $this->getTransportFactory();

        return $transport_factory->create($transport_name);
    }

    /**
     * @param $message_name
     * @return Message
     */
    private function createMessageByMessageName($message_name){
        $message_factory = $this->getMessageFactory();

        return $message_factory->create($message_name);
    }

    /**
     * @param array $connection_configuration
     * @return Connection
     */
    private function createConnectionByConfiguration(array $connection_configuration){
        $connection_factory = $this->getConnectionFactory();

        return $connection_factory->createFromArray($connection_configuration);
    }

    /**
     * @param array $transport_configuration
     * @return Transport
     */
    private function createTransportByConfiguration(array $transport_configuration){
        $transport_factory = $this->getTransportFactory();

        return $transport_factory->createFromArray($transport_configuration);
    }

    /**
     * @param $message_configuration
     * @return Message
     */
    private function createMessageByConfiguration($message_configuration){
        $message_factory = $this->getMessageFactory();

        return $message_factory->createFromArray($message_configuration);
    }

    /**
     * @return \Vu\Zf2AMQPCarapace\Factory\Connection
     */
    private function getConnectionFactory () {
        /** @var \Vu\Zf2AMQPCarapace\Factory\Connection $connection_factory */
        $connection_factory = $this->getServiceLocator()->get('Vu\Zf2AMQPCarapace\Factory\Connection');

        return $connection_factory;
    }

    /**
     * @return \Vu\Zf2AMQPCarapace\Factory\Transport
     */
    private function getTransportFactory () {
        /** @var \Vu\Zf2AMQPCarapace\Factory\Transport $transport_factory */
        $transport_factory = $this->getServiceLocator()->get('Vu\Zf2AMQPCarapace\Factory\Transport');

        return $transport_factory;
    }

    /**
     * @return \Vu\Zf2AMQPCarapace\Factory\Message
     */
    private function getMessageFactory () {
        /** @var \Vu\Zf2AMQPCarapace\Factory\Message $message_factory */
        $message_factory = $this->getServiceLocator()->get('Vu\Zf2AMQPCarapace\Factory\Message');

        return $message_factory;
    }

}
 
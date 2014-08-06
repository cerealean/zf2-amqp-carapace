<?php


namespace Vu\Zf2AMQPCarapace\Factory;

use Vu\AMQPCarapace\Model\ConnectionSettings;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2AMQPCarapace\AbstractFactory;

class Connection extends AbstractFactory implements IFactory {

    /**
     * @param string $factory_name
     * @return \Vu\AMQPCarapace\Connection\Connection
     */
    public function create ($factory_name) {
        /** @var \Vu\AMQPCarapace\Connection\Connection $amqp_carapace_connection */
        $amqp_carapace_connection = $this->getServiceLocator()->get('AMQPCarapace\Connection\Connection');
        $connection_settings = $this->getConnectionConfiguration($factory_name);

        return $this->amqpCarapaceConnect($amqp_carapace_connection, $connection_settings);
    }

    /**
     * @param array $configuration
     * @return \Vu\AMQPCarapace\Connection\Connection
     */
    public function createFromArray(array $configuration){
        /** @var \Vu\AMQPCarapace\Connection\Connection $amqp_carapace_connection */
        $amqp_carapace_connection = $this->getServiceLocator()->get('AMQPCarapace\Connection\Connection');

        return $this->amqpCarapaceConnect($amqp_carapace_connection, $configuration);
    }

    /**
     * @return array
     */
    private function getConnectionConfigurations(){
        return $this->getAmqpConfig("connection");
    }

    /**
     * @param \Vu\AMQPCarapace\Connection\Connection $amqp_carapace_connection
     * @param array $connection_settings
     * @return \Vu\AMQPCarapace\Connection\Connection
     */
    private function amqpCarapaceConnect(\Vu\AMQPCarapace\Connection\Connection $amqp_carapace_connection, array $connection_settings){
        $connection_settings_model = $this->generateConnectionSettingsModel($connection_settings);
        $amqp_carapace_connection->connect($connection_settings_model);

        return $amqp_carapace_connection;
    }

    /**
     * @param $configuration
     * @return array
     * @throws \Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException
     */
    private function getConnectionConfiguration($configuration){
        $connection_configurations = $this->getConnectionConfigurations();
        if(!array_key_exists($configuration, $connection_configurations)){
            throw new ConfigurationNotFoundException($configuration . " not found in array of connections");
        }

        return $connection_configurations[$configuration];
    }

    /**
     * @param array $connection_settings
     * @return ConnectionSettings
     */
    private function generateConnectionSettingsModel(array $connection_settings){
        $connection_settings_model = new ConnectionSettings();
        $hydrator = new ObjectProperty();

        $hydrator->hydrate($connection_settings, $connection_settings_model);

        return $connection_settings_model;
    }
}
 
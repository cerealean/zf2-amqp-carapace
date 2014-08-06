<?php


namespace Vu\Zf2AMQPCarapace;


use Vu\Zf2TestExtensions\Service\AbstractServiceLocatorAwareService;

abstract class AbstractFactory extends AbstractServiceLocatorAwareService {
    /**
     * @return array
     */
    private function getConfig(){
        return $this->getServiceLocator()->get('Config');
    }

    /**
     * @param $configuration
     * @return array
     */
    protected function getAmqpConfig($configuration){
        $config = $this->getConfig();
        $amqp_configuration = $config['AMQPCarapace'][$configuration];

        if(!is_array($amqp_configuration) || $amqp_configuration == null){
            $amqp_configuration = [];
        }

        return $amqp_configuration;
    }

}
 
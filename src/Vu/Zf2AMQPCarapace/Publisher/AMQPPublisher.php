<?php


namespace Vu\Zf2AMQPCarapace\Publisher;


use Vu\AMQPCarapace\Connection\Connection;
use Vu\AMQPCarapace\Model\Message;
use Vu\AMQPCarapace\Model\Transport;
use Vu\Zf2TestExtensions\Service\AbstractServiceLocatorAwareService;

class AMQPPublisher extends AbstractServiceLocatorAwareService {

    /**
     * @var Connection
     */
    protected $connection = null;

    /**
     * @var Transport
     */
    protected $transport = null;

    /**
     * @var Message
     */
    protected $message = null;

    /**
     * @param string $message_body
     *
     * Publishes a message using AMQP
     */
    public function basicPublish($message_body){
        $channel = $this->connection->createChannel();
        $this->message->body = $message_body;
        $channel->basicPublish($this->message, $this->transport);
        $channel->close();
    }

    /**
     * @param string[] $message_bodies
     *
     * Publishes multiple messages using AMQP
     */
    public function batchBasicPublish(array $message_bodies){
        $channel = $this->connection->createChannel();

        foreach($message_bodies as $message_body){
            $this->message->body = $message_body;
            $channel->addMessageToBatchPublishQueue($this->message, $this->transport);
        }

        $channel->basicPublishBatch();
        $channel->close();
    }

    /**
     * @param Connection $connection
     */
    public function setConnection (Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param Message $message
     */
    public function setMessage (Message $message) {
        $this->message = $message;
    }

    /**
     * @param Transport $transport
     */
    public function setTransport (Transport $transport) {
        $this->transport = $transport;
    }

}
 
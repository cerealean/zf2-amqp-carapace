<?php


namespace Vu\Zf2AMQPCarapace\Publisher;

use Vu\AMQPCarapace\Connection\Connection;
use Vu\AMQPCarapace\Channel\Channel;
use Vu\AMQPCarapace\Model\Message;
use Vu\AMQPCarapace\Model\Transport;
use Phake;
use Vu\Zf2TestExtensions\Test\Service\AbstractServiceLocatorAwareServiceTest;

class AMQPPublisherTest extends AbstractServiceLocatorAwareServiceTest {

    /**
     * @var AMQPPublisher
     */
    protected $service;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Transport
     */
    protected $transport;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var Message
     */
    protected $message;

    function getClassName () {
        return 'Vu\Zf2AMQPCarapace\Publisher\AMQPPublisher';
    }

    public function setUp(){
        parent::setUp();
        $this->connection = Phake::mock('\Vu\AMQPCarapace\Connection\Connection');
        $this->channel    = Phake::mock('\Vu\AMQPCarapace\Channel\Channel');
        $this->message    = Phake::mock('\Vu\AMQPCarapace\Model\Message');
        $this->transport  = Phake::mock('\Vu\AMQPCarapace\Model\Transport');
        Phake::when($this->connection)
            ->createChannel()
            ->thenReturn($this->channel);
        $this->service->setConnection($this->connection);
        $this->service->setTransport($this->transport);
        $this->service->setMessage($this->message);
    }

    public function test_basicPublishShouldCallChannelBasicPublishWithMessageAndTransport(){
        $message_body = "This is a rawr message body";

        $this->service->basicPublish($message_body);

        Phake::verify($this->channel)
            ->basicPublish($this->message, $this->transport);
    }

    public function test_basicPublishShouldCloseTheChannel(){
        $message_body = "This is a rawr message body";

        $this->service->basicPublish($message_body);

        Phake::verify($this->channel)
            ->close();
    }

    public function test_batchBasicPublishShouldAdd4MessagesToBatchPublishQueue(){
        $messages = [
            'first message',
            'second message',
            'third message',
            'fourth'
        ];

        $this->service->batchBasicPublish($messages);

        Phake::verify($this->channel, Phake::times(4))
            ->addMessageToBatchPublishQueue($this->message, $this->transport);
    }

    public function test_batchBasicPublishShouldAdd10MessagesToBatchPublishQueue(){
        $messages = [
            'first message',
            'second message',
            'third message',
            'fourth',
            '5',
            '6',
            'seven',
            'eight is cool',
            'nueve',
            'diez'
        ];

        $this->service->batchBasicPublish($messages);

        Phake::verify($this->channel, Phake::times(10))
            ->addMessageToBatchPublishQueue($this->message, $this->transport);
    }

    public function test_batchBasicPublishShouldCallChannelBasicPublishBatch(){
        $messages = [
            'first message',
            'second message',
            'third message',
            'fourth'
        ];

        $this->service->batchBasicPublish($messages);

        Phake::verify($this->channel)
            ->basicPublishBatch();
    }

    public function test_batchBasicPublishShouldCloseTheChannel(){
        $messages = [
            'first message',
            'second message',
            'third message',
            'fourth'
        ];

        $this->service->batchBasicPublish($messages);

        Phake::verify($this->channel)
            ->close();
    }

}
 
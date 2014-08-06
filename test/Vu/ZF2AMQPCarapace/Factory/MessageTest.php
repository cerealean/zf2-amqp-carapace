<?php


namespace Vu\Zf2AMQPCarapace\Factory;


use Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException;
use Vu\Zf2TestExtensions\Test\Service\AbstractServiceLocatorAwareServiceTest;

class MessageTest extends AbstractServiceLocatorAwareServiceTest {

    /**
     * @var Message
     */
    protected $service;

    function getClassName () {
        return 'Vu\Zf2AMQPCarapace\Factory\Message';
    }

    public function setUp(){
        parent::setUp();
        $this->service_locator->setService('Config', $this->getConfig());
    }

    private function getConfig(){
        return [
            'AMQPCarapace' => [
                'message' => [
                    'Default' => $this->getDefaultConfiguration()
                ]
            ]
        ];
    }

    private function getDefaultConfiguration(){
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

    public function test_createShouldReturnInstanceOfMessageModel(){
        $expected = '\Vu\AMQPCarapace\Model\Message';
        $factory_name = 'Default';

        $actual = $this->service->create($factory_name);

        $this->assertInstanceOf($expected, $actual);
    }

    public function test_createShouldThrowConfigurationNotFoundExceptionIfConfigurationNotFoundInListOfMessages(){
        $message_name = "This should not be found";
        $expected = 'Vu\Zf2AMQPCarapace\Exception\ConfigurationNotFoundException';

        try{
            $this->service->create($message_name);
        }
        catch(ConfigurationNotFoundException $configuration_not_found_exception){};

        $this->assertInstanceOf($expected, $configuration_not_found_exception);
    }

    public function test_createShouldReturnMessageModelWithMatchingContentType(){
        $expected = 'content-type';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->content_type;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingContentEncoding(){
        $expected = 'content-encoding';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->content_encoding;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingApplicationHeaders(){
        $expected = ['rawr'];
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->application_headers;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingDeliveryMode(){
        $expected = 0;
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->delivery_mode;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingPriority(){
        $expected = 1;
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->priority;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingCorrelationId(){
        $expected = 'correlation_id';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->correlation_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingReplyTo(){
        $expected = 'reply_to';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->reply_to;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingExpiration(){
        $expected = 'expiration';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->expiration;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingMessageId(){
        $expected = 'message_id';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->message_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingTimestamp(){
        $expected = 'timestamp';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->timestamp;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingType(){
        $expected = 'type';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->type;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingUserId(){
        $expected = 'user_id';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->user_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingAppId(){
        $expected = 'app_id';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->app_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createShouldReturnMessageModelWithMatchingClusterId(){
        $expected = 'cluster_id';
        $factory_name = 'Default';

        $message_model = $this->service->create($factory_name);
        $actual = $message_model->cluster_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingContentType(){
        $expected = 'content-type';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->content_type;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingContentEncoding(){
        $expected = 'content-encoding';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->content_encoding;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingApplicationHeaders(){
        $expected = ['rawr'];
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->application_headers;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingDeliveryMode(){
        $expected = 0;
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->delivery_mode;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingPriority(){
        $expected = 1;
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->priority;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingCorrelationId(){
        $expected = 'correlation_id';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->correlation_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingReplyTo(){
        $expected = 'reply_to';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->reply_to;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingExpiration(){
        $expected = 'expiration';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->expiration;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingMessageId(){
        $expected = 'message_id';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->message_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingTimestamp(){
        $expected = 'timestamp';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->timestamp;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingType(){
        $expected = 'type';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->type;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingUserId(){
        $expected = 'user_id';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->user_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingAppId(){
        $expected = 'app_id';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->app_id;

        $this->assertEquals($expected, $actual);
    }

    public function test_createFromArrayShouldReturnMessageModelWithMatchingClusterId(){
        $expected = 'cluster_id';
        $configuration = $this->getDefaultConfiguration();

        $message_model = $this->service->createFromArray($configuration);
        $actual = $message_model->cluster_id;

        $this->assertEquals($expected, $actual);
    }

}
 
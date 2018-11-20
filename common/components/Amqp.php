<?php

namespace common\components;

use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Работа с очередями rabbit MQ
 * Class Amqp
 * @package common\components
 */
class Amqp extends Component
{
    /**
     * @var AMQPStreamConnection
     */
    protected static $ampqConnection;

    /**
     * @var AMQPChannel[]
     */
    protected $channels = [];

    /**
     * @var string
     */
    public $host = '127.0.0.1';

    /**
     * @var integer
     */
    public $port = 5672;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $vhost = '/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->user)) {
            throw new Exception("Parameter 'user' was not set for AMQP connection.");
        }
        if (empty(self::$ampqConnection)) {
            self::$ampqConnection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->user,
                $this->password,
                $this->vhost
            );
        }
    }

    /**
     * Returns AMQP connection.
     *
     * @return AMQPConnection
     */
    public function getConnection()
    {
        return self::$ampqConnection;
    }

    /**
     * Returns AMQP connection.
     *
     * @param string $channel_id
     * @return AMQPChannel
     */
    public function getChannel($channel_id = null)
    {
        $index = $channel_id ?: 'default';
        if (!array_key_exists($index, $this->channels)) {
            $this->channels[$index] = $this->connection->channel($channel_id);
        }
        return $this->channels[$index];
    }

    /**
     * Sends message to the exchange.
     *
     * @param string $exchange
     * @param string $queue_name
     * @param string|array $message
     * @return void
     */
    public function send($exchange, $queue_name, $message)
    {
        $channel = $this->getChannel();
        /*
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
        $channel->queue_declare($queue_name, false, true, false, false);

        /*
            name: $exchange
            type: direct
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: true //the exchange won't be deleted once the channel is closed.
        */
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        $channel->queue_bind($queue_name, $exchange);

        //Publish message
        $channel->basic_publish($this->prepareMessage($message), $exchange);
    }

    /**
     * Listens the exchange for messages.
     *
     * @param string $exchange
     * @param string $queue_name
     * @param string $consumer_tag
     * @param callable $callback
     */
    public function listen($exchange, $queue_name, $consumer_tag, $callback)
    {
        $channel = $this->getChannel();
        /*
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
        $channel->queue_declare($queue_name, false, true, false, false);

        /*
            name: $exchange
            type: direct
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */

        $channel->exchange_declare($exchange, 'direct', false, true, false);

        $channel->queue_bind($queue_name, $exchange);
        /*
            queue: Queue from where to get the messages
            consumer_tag: Consumer identifier
            no_local: Don't receive messages published by this consumer.
            no_ack: Tells the server if the consumer will acknowledge the messages.
            exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
            nowait:
            callback: A PHP Callback
        */

        $channel->basic_consume($queue_name, $consumer_tag, false, false, false, false, $callback);

        // Loop as long as the channel has callbacks registered
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    /*
    *  Получение списка сообщений из очереди
    */
    public function getMessagesList($exchange, $queue_name)
    {
        $channel = $this->getChannel();
        $channel->queue_declare($queue_name, false, true, false, false);
        $channel->exchange_declare($exchange, 'direct', false, true, false);
        $channel->queue_bind($queue_name, $exchange);

        $list = [];
        while ($msg = $channel->basic_get($queue_name)) {
            $list[] = $msg->body;
        }

        return $list;
    }    

    /**
     * Returns prepaired AMQP message.
     *
     * @param string|array|object $message
     * @param array $properties
     * @return AMQPMessage
     * @throws Exception If message is empty.
     */
    public function prepareMessage($message, $properties = null)
    {
        if (empty($message)) {
            throw new Exception('AMQP message can not be empty');
        }
        if (is_array($message) || is_object($message)) {
            $message = Json::encode($message);
        }
        return new AMQPMessage($message, $properties);
    }

    /**
     * Marked message like parsed
     * @param AMQPMessage $msg
     */
    public function deleteMessage(AMQPMessage $msg)
    {
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }

    /**
     * Stop consumer
     * @param AMQPMessage $msg
     */
    public function stopConsumer(AMQPMessage $msg)
    {
        $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['consumer_tag']);
    }
}
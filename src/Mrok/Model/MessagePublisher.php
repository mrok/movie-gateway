<?php

namespace Mrok\Model;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/**
 *
 */
class MessagePublisher
{

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var string - exchange name
     */
    private $exchangeName;

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param $exchangeName
     */
    public function __construct(AMQPChannel $channel, $exchangeName)
    {
        $this->channel = $channel;
        $this->exchangeName = $exchangeName;
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $msg
     * @param string $exchange - if not provided then one passed in constructor is used
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @param null $ticket
     */
    public function publish(AMQPMessage $msg, $exchange = "", $routing_key = "", $mandatory = false, $immediate = false, $ticket = null)
    {
        if (empty($exchange)) {
            $exchange = $this->exchangeName;
        }

        $this->channel->basic_publish($msg, $exchange, $routing_key, $mandatory, $immediate, $ticket);
    }

}

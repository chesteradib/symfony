<?php

require dirname(__DIR__).'/vendor/autoload.php';
use RealTime\RealTimePusher;

$realTimePusher = new RealTimePusher;

$loop= \React\EventLoop\Factory::create();


$context =  new \React\ZMQ\Context($loop);

$pull = $context->getSocket(\ZMQ::SOCKET_PULL);

$pull->bind('tcp://127.0.0.1:5555');
$pull->on('message', array($realTimePusher, 'onRealTime'));


$webSock= new \React\Socket\Server($loop);
$webSock->listen(8080, '0.0.0.0');

$webServer = new Ratchet\Server\IoServer(
        new \Ratchet\Http\HttpServer(
            new Ratchet\WebSocket\WsServer(
                new \Ratchet\Wamp\WampServer(
                        $realTimePusher
                        )
                    )
                )
        ,$webSock
);

$loop->run();
?>

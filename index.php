<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$container->register('order_controller', OrderController::class)
    ->addArgument(new Reference('database'))
    ->addArgument(new Reference('mailer.gmail'))
    ->addArgument(new Reference('texter.sms'))
    ->addMethodCall('sayHello', ['Salut IAD !!']);

$container->register('database', Database::class);

$container->register('texter.sms', SmsTexter::class)
    ->addArgument("service.sms.com")
    ->addArgument("apikey123")
;

$container->register('mailer.gmail', GmailMailer::class)
    ->addArgument("ayoub@gmail.com")
    ->addArgument("123456")
;

$controller = $container->get('order_controller');

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
$controller->placeOrder();
return;
}

include __DIR__. '/views/form.html.php';

<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\SmsTexter;
use App\Texter\FaxTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$container->autowire('order_controller', OrderController::class)
    ->setPublic(true)
    ->addMethodCall('sayHello', ['Salut IAD !!'])
;

$container->autowire('database', Database::class);

$container->autowire('texter.sms', SmsTexter::class)
    ->addArgument("service.sms.com")
    ->addArgument("apikey123")
;

$container->autowire('texter.fax', FaxTexter::class);

$container->autowire('mailer.gmail', GmailMailer::class)
    ->addArgument("ayoub@gmail.com")
    ->addArgument("123456")
;

$container->autowire('smtp.gmail', SmtpMailer::class)
    ->addArgument("smtp://localhost")
    ->addArgument("root")
    ->addArgument('123')
;

$container->setAlias('App\Controller\OrderController', 'order_controller')->setPublic(true);
$container->setAlias('App\Database\Database', 'database');
$container->setAlias('App\Mailer\GmailMailer', 'mailer.gmail');
$container->setAlias('App\Mailer\SmtpMailer', 'mailer.smtp');
$container->setAlias('App\Texter\SmsTexter', 'texter.sms');
$container->setAlias('App\Texter\FaxTexter', 'texter.fax');
$container->setAlias('App\Texter\TexterInterface', 'texter.sms');
$container->setAlias('App\Mailer\MailerInterface', 'mailer.gmail');

$container->compile();

$controller = $container->get(OrderController::class);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
$controller->placeOrder();
return;
}

include __DIR__. '/views/form.html.php';

<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'swiftmailer.mailer.default.transport' shared service.

include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/ReplacementFilterFactory.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/StreamFilters/StringReplacementFilterFactory.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/InputByteStream.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Filterable.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/ByteStream/AbstractFilterableInputStream.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/OutputByteStream.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/IoBuffer.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/StreamBuffer.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/Authenticator.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/Auth/CramMd5Authenticator.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/Auth/LoginAuthenticator.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/Auth/PlainAuthenticator.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/EsmtpHandler.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/AuthHandler.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Events/EventDispatcher.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Events/SimpleEventDispatcher.php';
include_once $this->targetDirs[3].'/vendor/symfony/swiftmailer-bundle/DependencyInjection/SmtpTransportConfigurator.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/AbstractSmtpTransport.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/SmtpAgent.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/EsmtpTransport.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Events/EventListener.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Events/SendListener.php';
include_once $this->targetDirs[3].'/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Plugins/MessageLogger.php';

$a = new \Swift_Transport_Esmtp_AuthHandler(array(0 => new \Swift_Transport_Esmtp_Auth_CramMd5Authenticator(), 1 => new \Swift_Transport_Esmtp_Auth_LoginAuthenticator(), 2 => new \Swift_Transport_Esmtp_Auth_PlainAuthenticator()));
$a->setUsername('baghinsaferdotcom@gmail.com');
$a->setPassword('salamoalaikom');
$a->setAuthMode('login');

$this->services['swiftmailer.mailer.default.transport'] = $instance = new \Swift_Transport_EsmtpTransport(new \Swift_Transport_StreamBuffer(new \Swift_StreamFilters_StringReplacementFilterFactory()), array(0 => $a), new \Swift_Events_SimpleEventDispatcher());

$instance->setHost('smtp.gmail.com');
$instance->setPort(465);
$instance->setEncryption('ssl');
$instance->setTimeout(30);
$instance->setSourceIp(NULL);
$instance->registerPlugin(${($_ = isset($this->services['swiftmailer.plugin.redirecting']) ? $this->services['swiftmailer.plugin.redirecting'] : $this->load('getSwiftmailer_Plugin_RedirectingService.php')) && false ?: '_'});
$instance->registerPlugin(${($_ = isset($this->services['swiftmailer.mailer.default.plugin.messagelogger']) ? $this->services['swiftmailer.mailer.default.plugin.messagelogger'] : $this->services['swiftmailer.mailer.default.plugin.messagelogger'] = new \Swift_Plugins_MessageLogger()) && false ?: '_'});
(new \Symfony\Bundle\SwiftmailerBundle\DependencyInjection\SmtpTransportConfigurator(NULL, ${($_ = isset($this->services['router.request_context']) ? $this->services['router.request_context'] : $this->getRouter_RequestContextService()) && false ?: '_'}))->configure($instance);

return $instance;

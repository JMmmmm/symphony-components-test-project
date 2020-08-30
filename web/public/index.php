<?php

include '../app/vendor/autoload.php';

use App\Application\User\Admin;
use App\Application\User\UserInterface;
use Dotenv\Dotenv;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Routing\Loader\PhpFileLoader as RoutePhpFileLoader;

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$configPath = '../app/config';
$configFileLocator = new FileLocator($configPath);

$routeLoader = new RoutePhpFileLoader($configFileLocator);
$routes = $routeLoader->load('routes.php');

$containerBuilder = new ContainerBuilder();
$loader = new PhpFileLoader($containerBuilder, $configFileLocator);
$loader->load('service-provider.php');
$containerBuilder->set(UserInterface::class, new Admin());

$containerBuilder->compile();

$request = Request::createFromGlobals();
$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$controllerResolver = new ContainerControllerResolver($containerBuilder);
$argumentValueResolvers = [
    new RequestAttributeValueResolver(),
    new RequestValueResolver(),
    new SessionValueResolver(),
    new DefaultValueResolver(),
    new VariadicValueResolver(),
    new ServiceValueResolver($containerBuilder)
];
$argumentResolver = new ArgumentResolver(null, $argumentValueResolvers);

$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);

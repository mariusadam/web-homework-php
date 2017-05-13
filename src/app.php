<?php

use App\Controller\IndexController;
use App\Controller\TeamController;
use App\Form\FootballTeamForm;
use App\Repository\FootballTeamRepository;
use App\Services\EntityBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app['validator.mapping.class_metadata_factory'] = function ($app) {
    $loader = new AnnotationLoader(new AnnotationReader());

    return new LazyLoadingMetadataFactory($loader);
};
$app->register(new LocaleServiceProvider());
$app->register(new CsrfServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), [
        'translator.domains' => [],
    ]
);
$app->register(new DoctrineServiceProvider(), [
        'db.options' => [
            'host'     => '172.24.0.2',
            'port'     => '3306',
            'driver'   => 'pdo_mysql',
            'charset'  => 'utf8mb4',
            'dbname'   => 'web_db',
            'user'     => 'web_user',
            'password' => 'abcd1234',
        ],
    ]
);

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
}
);

$controllers = [
    IndexController::class,
    TeamController::class,
];

foreach ($controllers as $controllerClass) {
    $app[$controllerClass] = function () use ($app, $controllerClass) {
        return new $controllerClass($app);
    };
}


$app[EntityBuilder::class] = function () {
    return new EntityBuilder();
};

$app[FootballTeamRepository::class] = function () use ($app) {
    return new FootballTeamRepository(
        $app['db'], $app[EntityBuilder::class]
    );
};

$app[FootballTeamForm::class] = function ($app) {
    $url = $app['url_generator']->generate('new_team');

    return new FootballTeamForm($app[FootballTeamRepository::class], $url);
};
$app->extend('form.types', function ($types) use ($app) {
    $types[] = FootballTeamForm::class;

    return $types;
});

return $app;

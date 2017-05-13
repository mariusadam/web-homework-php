<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application('My Silex Application', 'n/a');
$console->getDefinition()->addOption(
    new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
);
$console->setDispatcher($app['dispatcher']);
$console
    ->register('my-command')
    ->setDefinition(
        [
            // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
        ]
    )
    ->setDescription('My command description')
    ->setCode(
        function (InputInterface $input, OutputInterface $output) use ($app) {
            // do something
        }
    );

$db = \Doctrine\DBAL\DriverManager::getConnection($app['db.options']);
$migrationConfIg = new \Doctrine\DBAL\Migrations\Configuration\Configuration($db);
$migrationConfIg->setName('App Migrations');
$migrationConfIg->setMigrationsNamespace('App\\Migrations');
$migrationConfIg->setMigrationsDirectory(__DIR__.'/App/Migrations');
$migrationConfIg->setMigrationsTableName('doctrine_migrations_versions');

$console->getHelperSet()->set(new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($db), 'configuration');
$console->getHelperSet()->set(
    new \Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper($db, $migrationConfIg), 'configuration'
);

/** @var Application $console */
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand());
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand());
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand());
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand());
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand());
$console->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand());

return $console;

<?php

use App\Controller\IndexController;
use App\Controller\TeamController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//Request::setTrustedProxies(array('127.0.0.1'));

/** @var \Silex\Application $app */

$app->error(
    function (\Exception $e, Request $request, $code) use ($app) {
        if ($app['debug']) {
            return;
        }

        // 404.html, or 40x.html, or 4xx.html, or error.html
        $templates = [
            'errors/'.$code.'.html.twig',
            'errors/'.substr($code, 0, 2).'x.html.twig',
            'errors/'.substr($code, 0, 1).'xx.html.twig',
            'errors/default.html.twig',
        ];

        return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
    }
);

$app->get('/', IndexController::class.':indexAction')->bind('homepage');

$app->get('/teams-rankings', IndexController::class.':teamRankingsAction')->bind('teams_rankings');

$app->get('/teams/list', TeamController::class.':listAction')->bind('list_teams');

$app->get('/teams/{teamId}', TeamController::class.':getTeamAction')
    ->assert('teamId', '\d+')
    ->bind('get_team');

$app->match('/teams/new', TeamController::class.':newTeamAction')
    ->method('GET|POST')
    ->bind('new_team');

$app->get('/teams', TeamController::class.':getTeamsAction')->bind('get_teams');

$app->delete('/teams/{teamId}', TeamController::class.':deleteTeamAction')
    ->assert('teamId', '\d+')
    ->bind('delete_team');

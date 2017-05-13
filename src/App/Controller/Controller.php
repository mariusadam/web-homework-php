<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class Controller
 *
 * @package App\Controller
 *
 * @author  Marius Adam
 */
class Controller
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $templateName
     * @param array  $context
     *
     * @return string
     */
    protected function render(string $templateName, array $context = []): string
    {
        return $this->app['twig']->render($templateName, $context);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    protected function get(string $serviceName)
    {
        return $this->app[$serviceName];
    }

    /**
     * @param array $data
     * @param int   $status
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function json(array $data, int $status = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
     * @return FormFactory
     */
    protected function formFactory()
    {
        return $this->app['form.factory'];
    }

    protected function getUrlGenerator()
    {
        return $this->app['url_generator'];
    }
}
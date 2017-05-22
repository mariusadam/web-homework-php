<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;


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

    /**
     * @return UrlGenerator
     */
    protected function getUrlGenerator()
    {
        return $this->app['url_generator'];
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->get('session');
    }

    protected function addFlashError($message)
    {
        $this
            ->getSession()
            ->getFlashBag()
            ->add('error', $message);
    }

    protected function addFlashSuccess($message)
    {
        $this
            ->getSession()
            ->getFlashBag()
            ->add('success', $message);
    }

    /**
     * @param string $route
     * @param array  $params
     *
     * @return RedirectResponse
     */
    protected function redirect($route, $params = [])
    {
        return new RedirectResponse(
            $this->getUrlGenerator()->generate($route, $params)
        );
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        $id = $this->getSession()->get('logged_user_id');
        if ($id === null) {
            return null;
        }

        try {
            return $this
                ->getUserRepository()
                ->findBy($id);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @return UserRepository
     */
    protected function getUserRepository()
    {
        return $this->get(UserRepository::class);
    }
}
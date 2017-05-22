<?php

namespace App\Controller;

use App\Form\UserForm;
use Exception;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class UserController
 *
 * @package App\Controller
 *
 * @author  Marius Adam
 */
class UserController extends Controller
{
    public function newAction(Request $request)
    {
        $form = $this->formFactory()->create(UserForm::class);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this
                    ->getUserRepository()
                    ->save($form->getData());
                $this->addFlashSuccess('User successfully added');
            }
        } catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    public function homepageAction()
    {
        if ($this->getUser() === null) {
            $this->addFlashError('You need to login first');

            return $this->redirect('login_user');
        }

        return $this->render('user/homepage.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    public function logoutAction()
    {
        $this->getSession()->remove('logged_user_id');
        $this->addFlashSuccess('Logout successful');

        return $this->redirect('login_user');
    }

    public function loginAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $username = $request->request->get('username');
                $this->getSession()->set('last_username', $username);
                $user = $this
                    ->getUserRepository()
                    ->findByUsername($username);

                $password = $request->request->get('password');
                if (!password_verify($password, $user->getPassword())) {
                    $this->addFlashError('Invalid username or password.');
                } else {
                    $this->getSession()->set('logged_user_id', $user->getId());
                    $this->addFlashSuccess('Login successful.');

                    return $this->redirect('homepage_user');
                }
            } catch (Exception $e) {
                $this->addFlashError($e->getMessage());
            }
        }

        return $this->render('user/login.html.twig', [
            'last_username' => $this->getSession()->get('last_username'),
        ]);
    }

    public function searchAction(Request $request)
    {
        $text = $request->query->get('search_text');
        $users = $this->getUserRepository()->search($text);

        return $this->render('user/search.html.twig', [
            'users' => $users,
            'user'  => $this->getUser(),
        ]);
    }

    public function editAction()
    {

    }

    public function profileAction()
    {

    }
}
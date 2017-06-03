<?php

namespace App\Controller;

use App\Entity\User;
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
    public function editAction(Request $request, $id)
    {
        $form = $this->formFactory()->create(UserForm::class);
        try {
            $user = $this->getUserRepository()->findBy($id);
            $form->setData($user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var User $user */
                $user = $form->getData();
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
                $this
                    ->getUserRepository()
                    ->save($user);
                $this->addFlashSuccess('User successfully updated');
            }
        } catch (Exception $e) {
            $this->addFlashError($e->getMessage());
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    public function newAction(Request $request)
    {
        $form = $this->formFactory()->create(UserForm::class);
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var User $user */
                $user = $form->getData();
                $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
                $this
                    ->getUserRepository()
                    ->save($user);
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
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $this->addFlashError('You need to login first'.$date);

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

    public function profileAction($id)
    {
        try {
            $editedUser = $this->getUserRepository()->findBy($id);
        } catch (Exception $e) {
            $this->addFlashError($e->getMessage());
            $editedUser = null;
        }

        return $this->render('user/profile.html.twig', [
            'edited_user' => $editedUser
        ]);
    }

    public function deleteAction($id)
    {
        try {
            $this->getUserRepository()->delete($id);
            $result['success'] = true;
            $result['id'] = $id;
        } catch (\Exception $e) {
            $result['success'] = false;
            $result['msg'] = $e->getMessage();
        }

        return $this->json($result);
    }
}
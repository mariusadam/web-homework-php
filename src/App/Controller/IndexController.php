<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 *
 * @package App\Controller
 *
 * @author  Marius Adam
 */
class IndexController extends Controller
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function indexAction(Request $request)
    {
        $tables = $this->get('db')->fetchAssoc(
            'SHOW tables from web_db'
        );
        dump($tables);

        return $this->render('index/index.html.twig', ['someVar' => 'this is the value of some var']);
    }
}

<?php

namespace App\Controller;

use App\Form\FootballTeamForm;
use App\Repository\FootballTeamRepository;
use App\Services\EntityMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class TeamController
 *
 * @package App\Controller
 *
 * @author  Marius Adam
 */
class TeamController extends Controller
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function listAction(Request $request)
    {
        $teams = $this->getFootBallTeamsRepo()->getAll();

        return $this->render(
            'team/list.html.twig',
            [
                'teams' => $teams,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function newTeamAction(Request $request)
    {
        $form = $this->formFactory()->create(FootballTeamForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();
//            dump($team);die;
            $this->getFootBallTeamsRepo()->save($team);
        }

        return $this->render('team/new.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param int     $teamId
     *
     * @return JsonResponse
     */
    public function getTeamAction(Request $request, $teamId)
    {
        $data['success'] = true;
        try {
            $team = $this
                ->getFootBallTeamsRepo()
                ->findBy((int)$teamId);

            $data['team'] = EntityMapper::toArray($team, false);
        } catch (Exception $ex) {
            $data['success'] = false;
            $data['msg'] = $ex->getMessage();
        }

        return $this->json($data);
    }

    /**
     * @return FootballTeamRepository
     */
    private function getFootBallTeamsRepo()
    {
        return $this->get(FootballTeamRepository::class);
    }
}
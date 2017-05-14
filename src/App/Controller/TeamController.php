<?php

namespace App\Controller;

use App\Entity\FootballTeam;
use App\Form\FootballTeamForm;
use App\Repository\FootballTeamRepository;
use App\Services\EntityMapper;
use Exception;
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
        $result = [];
        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var FootballTeam $team */
                $team = $form->getData();
                $isNew = $team->getId() === null;
                $this->getFootBallTeamsRepo()->save($team);

                if ($isNew) {
                    $result['type'] = 'success';
                    $result['msg'] = "Team with id {$team->getName()} was successfully added";
                } else {
                    $result['type'] = 'info';
                    $result['msg'] = "Team {$team->getName()} was successfully updated";
                }
            } else if ($form->isSubmitted() && !$form->isValid()) {
                $result['msg'] = 'There were some validation errors.';
                $result['type'] = 'danger';

            }
        } catch (Exception $ex) {
            $result['type'] = 'danger';
            $result['msg'] = $ex->getMessage();
        }

        return $this->render('team/new.html.twig', [
                'form'   => $form->createView(),
                'result' => $result,
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
        $data['type'] = 'success';
        try {
            $team = $this
                ->getFootBallTeamsRepo()
                ->findBy((int)$teamId);

            $data['team'] = EntityMapper::toArray($team, false);
        } catch (Exception $ex) {
            $data['type'] = 'danger';
            $data['msg'] = $ex->getMessage();
        }

        return $this->json($data);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTeamsAction(Request $request)
    {
        $result['success'] = true;
        try {
            $teams = $this->getFootBallTeamsRepo()->getAll();
            $result['teams'] = array_map([EntityMapper::class, 'toArrayKeepCase'], $teams);
        } catch (Exception $ex) {
            $data['success'] = false;
            $data['msg'] = $ex->getMessage();
        }

        return $this->json($result);
    }

    public function deleteTeamAction($teamId)
    {
        $result['type'] = 'success';
        try {
            $team = $this->getFootBallTeamsRepo()->findBy($teamId);
            $this->getFootBallTeamsRepo()->delete($team);
            $result['msg'] = "{$team} with id {$teamId} was deleted.";
        } catch (Exception $ex) {
            $result['type'] = 'danger';
            $result['msg'] = $ex->getMessage();
        }

        return $this->json($result);
    }

    /**
     * @return FootballTeamRepository
     */
    private function getFootBallTeamsRepo()
    {
        return $this->get(FootballTeamRepository::class);
    }
}
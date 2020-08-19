<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 *
 * @Route(path="/api/")
 */
class TeamController extends AbstractController
{

    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @Route("team", name="add_team", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addTeam(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];

        if (empty($name)){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->teamRepository->saveTeam($name);

        return new JsonResponse(['status' => 'Team created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("team/{id}", name="get_one_team", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getTeam($id): JsonResponse
    {
        $team = $this->teamRepository->findOneBy(['id' => $id]);

        if (empty($team)){
            throw new HttpException(400, "Team does not exist.");
        }

        $data = [
            'id' => $team->getId(),
            'name' => $team->getName()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("teams", name="get_all_teams", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllTeams(): JsonResponse
    {
        $teams = $this->teamRepository->findAll();
        $data = [];

        foreach ($teams as $team) {
            $data[] = [
                'id' => $team->getId(),
                'name' => $team->getName()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("team/{id}", name="update_team", methods={"POST"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateTeam($id, Request $request): JsonResponse
    {
        $team = $this->teamRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $team->setName($data['name']);

        $this->teamRepository->updateTeam($team);

        return new JsonResponse(['status' => 'Team updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("team/{id}", name="remove_team", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function removeTeam($id): JsonResponse
    {
        $team = $this->teamRepository->findOneBy(['id' => $id]);

        if (empty($team)){
            throw new HttpException(400, "Team does not exist.");
        }

        $this->teamRepository->removeTeam($team);

        return new JsonResponse(['status' => 'Team removed!'], Response::HTTP_OK);
    }


}
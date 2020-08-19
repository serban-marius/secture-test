<?php

namespace App\Controller;

use App\Repository\PlayersRepository;
use App\Repository\PositionRepository;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlayersController
 *
 * @Route(path="/api/")
 */
class PlayersController extends AbstractController
{

    private $playersRepository;
    private $teamRepository;
    private $positionRepository;

    public function __construct(PlayersRepository $playersRepository,
                                TeamRepository $teamRepository,
                                PositionRepository $positionRepository)
    {
        $this->playersRepository = $playersRepository;
        $this->teamRepository = $teamRepository;
        $this->positionRepository = $positionRepository;
    }

    /**
     * @Route("player", name="add_player", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addPlayer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $team_id = $data['team'];
        $team = $this->teamRepository->findOneBy(['id' => $team_id]);
        $position_id = $data['position'];
        $position = $this->positionRepository->findOneBy(['id' => $position_id]);
        $price = $data['price'];

        if (empty($name) || empty($price)) {
            return new JsonResponse(['status' => 'Name & Price are required parameters.'], Response::HTTP_OK);
        }
        if (empty($team)) {
            return new JsonResponse(['status' => 'Team should exist.'], Response::HTTP_OK);
        }
        if (empty($position)) {
            return new JsonResponse(['status' => 'Position should exist.'], Response::HTTP_OK);
        }

        $this->playersRepository->savePlayer($name, $team, $position, $price);

        return new JsonResponse(['status' => 'Player created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("player/{id}", name="get_one_player", methods={"GET"})
     * @Route("player/{id}&currency={currency}", name="get_one_player_usd", methods={"POST"})
     * @param $id
     * @param string $currency
     * @return JsonResponse
     */
    public function getPlayer($id, $currency = "EUR"): JsonResponse
    {
        $player = $this->playersRepository->findOneBy(['id' => $id]);

        if (empty($player)){
            return new JsonResponse(['status' => 'Player does not exist.'], Response::HTTP_OK);
        }

        $data = [
            'id' => $player->getId(),
            'name' => $player->getName(),
            'position' => $player->getPosition()->getName(),
            'team' => $player->getTeam()->getName(),
            'price' => $player->getPrice($currency)
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("players", name="get_all_players", methods={"GET"})
     * @Route("players&currency={currency}", name="get_all_players_usd", methods={"POST"})
     * @param string $currency
     * @return JsonResponse
     */
    public function getAllPlayers($currency = "EUR"): JsonResponse
    {
        $players = $this->playersRepository->findAll();

        if (empty($players)){
            return new JsonResponse(['status' => 'There are no players.'], Response::HTTP_OK);
        }

        $data = [];

        foreach ($players as $player) {
            $data[] = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'position' => $player->getPosition()->getName(),
                'team' => $player->getTeam()->getName(),
                'price' => $player->getPrice($currency)
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("player/{id}", name="update_player", methods={"POST"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePlayer($id, Request $request): JsonResponse
    {
        $player = $this->playersRepository->findOneBy(['id' => $id]);

        if (empty($player)){
            return new JsonResponse(['status' => 'Player does not exist.'], Response::HTTP_OK);
        }

        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $player->setName($data['name']);
        $team = $this->teamRepository->findOneBy(['id' => $data['team']]);
        empty($team) ? true : $player->setTeam($team);
        $position = $this->positionRepository->findOneBy(['id' => $data['position']]);
        empty($position) ? true : $player->setPosition($position);
        empty($data['price']) ? true : $player->setPrice($data['price']);

        $this->playersRepository->updatePlayer($player);

        return new JsonResponse(['status' => 'Player updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("player/{id}", name="remove_players", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function removePlayer($id): JsonResponse
    {
        $player = $this->playersRepository->findOneBy(['id' => $id]);

        if (empty($player)){
            return new JsonResponse(['status' => 'Player does not exist.'], Response::HTTP_OK);
        }

        $this->playersRepository->removePlayer($player);

        return new JsonResponse(['status' => 'Player removed!'], Response::HTTP_OK);
    }

    /**
     * @Route("team_id/players/{team_id}", name="team_id_players", methods={"GET"})
     * @Route("team_id/players/{team_id}&currency={currency}", name="team_id_players_usd", methods={"POST"})
     * @param $team_id
     * @param string $currency
     * @return JsonResponse
     */
    public function teamPlayers($team_id, $currency = 'EUR'): JsonResponse
    {
        $players = $this->playersRepository->findBy(['team' => $team_id]);

        if (empty($players)){
            return new JsonResponse(
                ['status' => 'Team does not exist & or there are no players.'],
                Response::HTTP_OK);
        }

        $data = [];

        foreach ($players as $player) {
            $data[] = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'position' => $player->getPosition()->getName(),
                'team' => $player->getTeam()->getName(),
                'price' => $player->getPrice($currency)
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("position_id/players/{position_id}", name="position_id_players", methods={"GET"})
     * @Route("position_id/players/{position_id}&currency={currency}", name="position_id_players_usd", methods={"POST"})
     * @param $position_id
     * @param string $currency
     * @return JsonResponse
     */
    public function positionPlayers($position_id, $currency = 'EUR'): JsonResponse
    {
        $players = $this->playersRepository->findBy(['position' => $position_id]);

        if (empty($players)){
            return new JsonResponse(
                ['status' => 'Position does not exist & or there are no players.'],
                Response::HTTP_OK);
        }

        $data = [];

        foreach ($players as $player) {
            $data[] = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'position' => $player->getPosition()->getName(),
                'team' => $player->getTeam()->getName(),
                'price' => $player->getPrice($currency)
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("team_position_id/players/position_id={position_id}&team_id={team_id}",
     *     name="team_position_id_players", methods={"GET"})
     * @Route("team_position_id/players/position_id={position_id}&team_id={team_id}&currency={currency}",
     *     name="team_position_id_players_usd", methods={"POST"})
     * @param $team_id
     * @param $position_id
     * @param string $currency
     * @return JsonResponse
     */
    public function teamPositionPlayers($team_id, $position_id, $currency = 'EUR'): JsonResponse
    {
        $players = $this->playersRepository->findBy([
            'position' => $position_id,
            'team' => $team_id
        ]);

        if (empty($players)){
            return new JsonResponse(
                ['status' => 'Team / Position does not exist & or there are no players.'],
                Response::HTTP_OK);
        }

        $data = [];

        foreach ($players as $player) {
            $data[] = [
                'id' => $player->getId(),
                'name' => $player->getName(),
                'position' => $player->getPosition()->getName(),
                'team' => $player->getTeam()->getName(),
                'price' => $player->getPrice($currency)
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}

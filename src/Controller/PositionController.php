<?php

namespace App\Controller;

use App\Repository\PositionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PositionController
 *
 * @Route(path="/api/")
 */
class PositionController extends AbstractController
{

    private $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    /**
     * @Route("position", name="add_position", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addPosition(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];

        if (empty($name)){
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->positionRepository->savePosition($name);

        return new JsonResponse(['status' => 'Position created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("position/{id}", name="get_one_position", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getPosition($id): JsonResponse
    {
        $position = $this->positionRepository->findOneBy(['id' => $id]);

        if (empty($position)){
            throw new HttpException(400, "Position does not exist.");
        }

        $data = [
            'id' => $position->getId(),
            'name' => $position->getName()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("positions", name="get_all_positions", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllPositions(): JsonResponse
    {
        $positions = $this->positionRepository->findAll();
        $data = [];

        foreach ($positions as $position) {
            $data[] = [
                'id' => $position->getId(),
                'name' => $position->getName()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("position/{id}", name="update_position", methods={"POST"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePosition($id, Request $request): JsonResponse
    {
        $position = $this->positionRepository->findOneBy(['id' => $id]);

        if (empty($position)){
            throw new HttpException(400, "Position does not exist.");
        }

        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $position->setName($data['name']);

        $this->positionRepository->updatePosition($position);

        return new JsonResponse(['status' => 'Position updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("position/{id}", name="remove_position", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function removePosition($id): JsonResponse
    {
        $position = $this->positionRepository->findOneBy(['id' => $id]);

        if (empty($position)){
            throw new HttpException(400, "Position does not exist.");
        }

        $this->positionRepository->removePosition($position);

        return new JsonResponse(['status' => 'Position removed!'], Response::HTTP_OK);
    }

}

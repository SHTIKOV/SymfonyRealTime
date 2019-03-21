<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;

use App\Entity\Room;


/**
 * @Route("/rooms")
 */
class RoomController extends AbstractController
{

    /** @var string */
    private $mercurePublishUrl = "";

    public function __construct ($mercurePublishUrl) {
        $this->mercurePublishUrl = $mercurePublishUrl;
    }

    /**
     * @Route("/", name="rooms")
     */
    public function index () {
        $rooms = $this->getDoctrine ()
            ->getRepository (Room::class)
            ->findAll ();

        return $this->render ('rooms/index.html.twig', [
            'rooms' => $rooms,
            'mercurePublishUrl' => $this->mercurePublishUrl,
        ]);
    }
    
    /**
     * @Route("/get", name="get")
     */
    public function getRooms () {
        $rooms = $this->getDoctrine ()
            ->getRepository (Room::class)
            ->findAll ();

        return new JsonResponse ($rooms);
    }
    
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editRoom (Request $request, Room $room) {
        $isEdited = false;
        $em = $this->getDoctrine()->getManager();

        if ($request->query->has ('title')) {
            $isEdited = true;
            $room->setTitle ($request->query->get ('title'));
            $em->persist ($room);
            $em->flush();
        }

        return $this->render('rooms/edit.html.twig', [
            'room' => $room,
            'isEdited' => $isEdited,
        ]);
    }
    
    /**
     * @Route("/push", name="push", methods={"POST"})
     */
    public function pushRoom (Publisher $publisher) {
        $update = new Update ("http://localhost:8000/push", "[]");
        $publisher ($update);

        return $this->redirect ($this->generateUrl ('rooms'));
    }
}

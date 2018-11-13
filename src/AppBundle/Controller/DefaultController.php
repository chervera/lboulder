<?php

namespace AppBundle\Controller;

use BackBundle\Entity\Media;
use BackBundle\Entity\Sector;
use BackBundle\Entity\Via;
use BackBundle\Entity\Zona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $zonas = $em->getRepository('BackBundle:Zona')->findByActive(true);
        $boulderPoints = [];
        foreach($zonas as $zona){
            $boulderPoints = array_merge($boulderPoints, $zona->getBoulderPoints());
        }
        $lastAddedVias = $em->getRepository('BackBundle:Via')->findBy([], ["id" => "DESC"], 5);
        $lastAddedSectors = $em->getRepository('BackBundle:Sector')->findBy([], ["id" => "DESC"], 5);

        $lastAddedImages = $em->getRepository('BackBundle:Media')->findBy(["type" => Media::TYPE_IMAGE], ["id" => "DESC"], 2);
        $lastAddedVideos = $em->getRepository('BackBundle:Media')->findBy(["type" => Media::TYPE_VIDEO], ["id" => "DESC"], 5);

        return $this->render('AppBundle:Default:index.html.twig', [
                    "zonas" => $zonas,
                    "lastAddedVias" => $lastAddedVias,
                    "lastAddedSectors" => $lastAddedSectors,
                    "lastAddedImages" => $lastAddedImages,
                    "lastAddedVideos" => $lastAddedVideos,
                    "boulderPoints" => $boulderPoints
        ]);
    }

    public function sectorAction(Request $request, $sector_slug) {
        $em = $this->getDoctrine()->getManager();
        $sector = $em->getRepository(Sector::class)->findOneBySlug($sector_slug);

        if (!$sector) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Default:sector.html.twig', [
                    "sector" => $sector
        ]);
    }

    public function viaAction(Request $request, $via_id) {
        $em = $this->getDoctrine()->getManager();
        $via = $em->getRepository(Via::class)->find($via_id);

        if (!$via) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Default:via.html.twig', [
                    "via" => $via
        ]);
    }

    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $text = $request->get("search");
        $sectors = $em->getRepository(Sector::class)->findAllByText($text);
        $vias = $em->getRepository(Via::class)->findAllByText($text);

        return $this->render('AppBundle:Default:search.html.twig', [
                    "search" => $text,
                    "sectors" => $sectors,
                    "vias" => $vias
        ]);
    }

    public function _menuAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $zonas = $em->getRepository(Zona::class)->findByActive(true);

        return $this->render('AppBundle:Default:_menu.html.twig', [
                    "zonas" => $zonas
        ]);
    }

}

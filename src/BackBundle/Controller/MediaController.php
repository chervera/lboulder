<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Medium controller.
 *
 * @Route("zona/{zona_id}/sector/{sector_id}/boulder/{boulder_id}/via/{via_id}/media")
 */
class MediaController extends Controller
{
    /**
     * Lists all medium entities.
     *
     * @Route("/", name="media_index")
     * @Method("GET")
     */
    public function indexAction($zona_id, $sector_id, $boulder_id, $via_id)
    {
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('BackBundle:Media')->findByVia($via_id);
        $via = $em->getRepository('BackBundle:Via')->find($via_id);        

        return $this->render('BackBundle:media:index.html.twig', array(
            'medias' => $media,
            'via' => $via,
            "zona_id" => $zona_id,
            "sector_id" => $sector_id,
            "boulder_id" => $boulder_id,
            "via_id" => $via_id
        ));
    }

    /**
     * Creates a new medium entity.
     *
     * @Route("/new", name="media_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $zona_id, $sector_id, $boulder_id, $via_id)
    {
        $media = new Media();
        $em = $this->getDoctrine()->getManager();
        $via = $em->getRepository("BackBundle:Via")->find($via_id);
        $media->setVia($via);
        $form = $this->createForm('BackBundle\Form\MediaType', $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('media_show', array('id' => $media->getId(), "zona_id"=> $media->getVia()->getBoulder()->getSector()->getZona()->getId(), "sector_id"=>$media->getVia()->getBoulder()->getSector()->getId(), "boulder_id"=> $media->getVia()->getBoulder()->getId(), "via_id"=> $media->getVia()->getId()));
        }

        return $this->render('BackBundle:media:new.html.twig', array(
            'media' => $media,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a medium entity.
     *
     * @Route("/{id}", name="media_show")
     * @Method("GET")
     */
    public function showAction(Media $media)
    {
        $deleteForm = $this->createDeleteForm($media);

        return $this->render('BackBundle:media:show.html.twig', array(
            'media' => $media,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medium entity.
     *
     * @Route("/{id}/edit", name="media_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Media $medium)
    {
        $deleteForm = $this->createDeleteForm($medium);
        $editForm = $this->createForm('BackBundle\Form\MediaType', $medium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_edit', array('id' => $medium->getId(), "zona_id"=> $media->getVia()->getBoulder()->getSector()->getZona()->getId(), "sector_id"=>$media->getVia()->getBoulder()->getSector()->getId(), "boulder_id"=> $media->getVia()->getBoulder()->getId(), "via_id"=> $media->getVia()->getId()));
        }

        return $this->render('BackBundle:media:edit.html.twig', array(
            'media' => $medium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medium entity.
     *
     * @Route("/{id}", name="media_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Media $medium)
    {
        $form = $this->createDeleteForm($medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medium);
            $em->flush();
        }

        return $this->redirectToRoute('media_index', array("zona_id"=> $media->getVia()->getBoulder()->getSector()->getZona()->getId(), "sector_id"=>$media->getVia()->getBoulder()->getSector()->getId(), "boulder_id"=> $media->getVia()->getBoulder()->getId(), "via_id"=> $media->getVia()->getId()));
    }

    /**
     * Creates a form to delete a medium entity.
     *
     * @param Media $medium The medium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Media $media)
    {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('media_delete', array('id' => $media->getId(), "zona_id"=> $media->getVia()->getBoulder()->getSector()->getZona()->getId(), "sector_id"=>$media->getVia()->getBoulder()->getSector()->getId(), "boulder_id"=> $media->getVia()->getBoulder()->getId(), "via_id"=> $media->getVia()->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

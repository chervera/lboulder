<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Sector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sector controller.
 *
 * @Route("zona/{zona_id}/sector")
 */
class SectorController extends Controller {

    /**
     * Lists all sector entities.
     *
     * @Route("/", name="sector_index")
     * @Method("GET")
     */
    public function indexAction($zona_id) {
        $em = $this->getDoctrine()->getManager();

        $sectors = $em->getRepository('BackBundle:Sector')->findByZona($zona_id);
        $zona = $em->getRepository('BackBundle:Zona')->find($zona_id);

        return $this->render('BackBundle:sector:index.html.twig', array(
                    'sectors' => $sectors,
                    'zona' => $zona,
                    'zona_id' => $zona_id
        ));
    }

    /**
     * Creates a new sector entity.
     *
     * @Route("/new", name="sector_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $zona_id) {
        $sector = new Sector();
        $em = $this->getDoctrine()->getManager();

        $zona = $em->getRepository("BackBundle:Zona")->find($zona_id);
        $sector->setZona($zona);
        $form = $this->createForm('BackBundle\Form\SectorType', $sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($sector);
            $em->flush();

            return $this->redirectToRoute('sector_show', array('id' => $sector->getId(), "zona_id" => $sector->getZona()->getId()));
        }

        return $this->render('BackBundle:sector:new.html.twig', array(
                    'sector' => $sector,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sector entity.
     *
     * @Route("/{id}", name="sector_show")
     * @Method("GET")
     */
    public function showAction(Sector $sector) {
        $deleteForm = $this->createDeleteForm($sector);

        return $this->render('BackBundle:sector:show.html.twig', array(
                    'sector' => $sector,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sector entity.
     *
     * @Route("/{id}/edit", name="sector_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sector $sector) {
        $deleteForm = $this->createDeleteForm($sector);
        $editForm = $this->createForm('BackBundle\Form\SectorType', $sector);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sector_edit', array('id' => $sector->getId(), "zona_id" => $sector->getZona()->getId()));
        }

        return $this->render('BackBundle:sector:edit.html.twig', array(
                    'sector' => $sector,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sector entity.
     *
     * @Route("/{id}", name="sector_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sector $sector) {
        $form = $this->createDeleteForm($sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sector);
            $em->flush();
        }

        return $this->redirectToRoute('sector_index');
    }

    /**
     * Creates a form to delete a sector entity.
     *
     * @param Sector $sector The sector entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sector $sector) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('sector_delete', array('id' => $sector->getId(), "zona_id" => $sector->getZona()->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}

<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Via;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vium controller.
 *
 * @Route("zona/{zona_id}/sector/{sector_id}/boulder/{boulder_id}/via")
 */
class ViaController extends Controller
{
    /**
     * Lists all vium entities.
     *
     * @Route("/", name="via_index")
     * @Method("GET")
     */
    public function indexAction($zona_id, $sector_id, $boulder_id)
    {
        $em = $this->getDoctrine()->getManager();

        $vias = $em->getRepository('BackBundle:Via')->findByBoulder($boulder_id);
        $boulder = $em->getRepository('BackBundle:Boulder')->find($boulder_id);        

        return $this->render('BackBundle:via:index.html.twig', array(
            'vias' => $vias,
            "boulder" => $boulder,
            "zona_id" => $zona_id,
            "sector_id" => $sector_id,
            "boulder_id" => $boulder_id
        ));
    }

    /**
     * Creates a new vium entity.
     *
     * @Route("/new", name="via_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $zona_id, $sector_id, $boulder_id)
    {
        $via = new Via();
        $em = $this->getDoctrine()->getManager();
        $boulder = $em->getRepository("BackBundle:Boulder")->find($boulder_id);
        $via->setBoulder($boulder);
        
        $form = $this->createForm('BackBundle\Form\ViaType', $via);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($via);
            $em->flush();

            return $this->redirectToRoute('via_show', array('id' => $via->getId(), "zona_id" => $via->getBoulder()->getSector()->getZona()->getId(), "sector_id" => $via->getBoulder()->getSector()->getId(), "boulder_id" => $via->getBoulder()->getId()));
        }

        return $this->render('BackBundle:via:new.html.twig', array(
            'via' => $via,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vium entity.
     *
     * @Route("/{id}", name="via_show")
     * @Method("GET")
     */
    public function showAction(Via $via)
    {
        $deleteForm = $this->createDeleteForm($via);

        return $this->render('BackBundle:via:show.html.twig', array(
            'via' => $via,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vium entity.
     *
     * @Route("/{id}/edit", name="via_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Via $via)
    {
        $deleteForm = $this->createDeleteForm($via);
        $editForm = $this->createForm('BackBundle\Form\ViaType', $via);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('via_edit', array('id' => $via->getId(), "zona_id" => $via->getBoulder()->getSector()->getZona()->getId(), "sector_id" => $via->getBoulder()->getSector()->getId(), "boulder_id" => $via->getBoulder()->getId()));
        }

        return $this->render('BackBundle:via:edit.html.twig', array(
            'via' => $via,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vium entity.
     *
     * @Route("/{id}", name="via_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Via $vium)
    {
        $form = $this->createDeleteForm($vium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vium);
            $em->flush();
        }

        return $this->redirectToRoute('via_index');
    }

    /**
     * Creates a form to delete a vium entity.
     *
     * @param Via $vium The vium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Via $via)
    {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('via_delete', array('id' => $via->getId(), "zona_id" => $via->getBoulder()->getSector()->getZona()->getId(), "sector_id" => $via->getBoulder()->getSector()->getId(), "boulder_id" => $via->getBoulder()->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

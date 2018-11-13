<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Boulder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Boulder controller.
 *
 * @Route("zona/{zona_id}/sector/{sector_id}/boulder")
 */
class BoulderController extends Controller
{
    /**
     * Lists all boulder entities.
     *
     * @Route("/", name="boulder_index")
     * @Method("GET")
     */
    public function indexAction($zona_id, $sector_id)
    {
        $em = $this->getDoctrine()->getManager();

        $boulders = $em->getRepository('BackBundle:Boulder')->findBy(["sector" => $sector_id], ["order" => "ASC"]);
        $sector = $em->getRepository('BackBundle:Sector')->find($sector_id);        

        return $this->render('BackBundle:boulder:index.html.twig', array(
            'boulders' => $boulders,
            "zona_id" => $zona_id,
            "sector" => $sector,
            "sector_id" => $sector_id
        ));
    }

    /**
     * Creates a new boulder entity.
     *
     * @Route("/new", name="boulder_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $zona_id, $sector_id)
    {
        $boulder = new Boulder();
        $em = $this->getDoctrine()->getManager();
        $sector = $em->getRepository("BackBundle:Sector")->find($sector_id);
        $boulder->setSector($sector);
        
        
        $form = $this->createForm('BackBundle\Form\BoulderType', $boulder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($boulder);
            $em->flush();

            return $this->redirectToRoute('boulder_show', array('id' => $boulder->getId(), 'zona_id' => $boulder->getSector()->getZona()->getId(), 'sector_id' => $boulder->getSector()->getId()));
        }

        return $this->render('BackBundle:boulder:new.html.twig', array(
            'boulder' => $boulder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a boulder entity.
     *
     * @Route("/{id}", name="boulder_show")
     * @Method("GET")
     */
    public function showAction(Boulder $boulder)
    {
        $deleteForm = $this->createDeleteForm($boulder);

        return $this->render('BackBundle:boulder:show.html.twig', array(
            'boulder' => $boulder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing boulder entity.
     *
     * @Route("/{id}/edit", name="boulder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Boulder $boulder)
    {
        $deleteForm = $this->createDeleteForm($boulder);
        $editForm = $this->createForm('BackBundle\Form\BoulderType', $boulder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boulder_edit', array('id' => $boulder->getId(), 'zona_id' => $boulder->getSector()->getZona()->getId(), 'sector_id' => $boulder->getSector()->getId()));
        }

        return $this->render('BackBundle:boulder:edit.html.twig', array(
            'boulder' => $boulder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a boulder entity.
     *
     * @Route("/{id}", name="boulder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Boulder $boulder)
    {
        $form = $this->createDeleteForm($boulder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($boulder);
            $em->flush();
        }

        return $this->redirectToRoute('boulder_index');
    }

    /**
     * Creates a form to delete a boulder entity.
     *
     * @param Boulder $boulder The boulder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Boulder $boulder)
    {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('boulder_delete', array('id' => $boulder->getId(), "zona_id" => $boulder->getSector()->getZona()->getId(), "sector_id" => $boulder->getSector()->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

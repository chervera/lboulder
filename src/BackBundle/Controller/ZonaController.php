<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Zona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Zona controller.
 *
 * @Route("zona")
 */
class ZonaController extends Controller
{
    /**
     * Lists all zona entities.
     *
     * @Route("/", name="zona_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zonas = $em->getRepository('BackBundle:Zona')->findAll();

        return $this->render('BackBundle:zona:index.html.twig', array(
            'zonas' => $zonas,
        ));
    }

    /**
     * Creates a new zona entity.
     *
     * @Route("/new", name="zona_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zona = new Zona();
        $form = $this->createForm('BackBundle\Form\ZonaType', $zona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zona);
            $em->flush();

            return $this->redirectToRoute('zona_show', array('id' => $zona->getId()));
        }

        return $this->render('BackBundle:zona:new.html.twig', array(
            'zona' => $zona,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a zona entity.
     *
     * @Route("/{id}", name="zona_show")
     * @Method("GET")
     */
    public function showAction(Zona $zona)
    {
        $deleteForm = $this->createDeleteForm($zona);

        return $this->render('BackBundle:zona:show.html.twig', array(
            'zona' => $zona,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing zona entity.
     *
     * @Route("/{id}/edit", name="zona_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zona $zona)
    {
        $deleteForm = $this->createDeleteForm($zona);
        $editForm = $this->createForm('BackBundle\Form\ZonaType', $zona);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zona_edit', array('id' => $zona->getId()));
        }

        return $this->render('BackBundle:zona:edit.html.twig', array(
            'zona' => $zona,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a zona entity.
     *
     * @Route("/{id}", name="zona_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zona $zona)
    {
        $form = $this->createDeleteForm($zona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zona);
            $em->flush();
        }

        return $this->redirectToRoute('zona_index');
    }

    /**
     * Creates a form to delete a zona entity.
     *
     * @param Zona $zona The zona entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zona $zona)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zona_delete', array('id' => $zona->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

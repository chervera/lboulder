<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Grado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Grado controller.
 *
 * @Route("grado")
 */
class GradoController extends Controller
{
    /**
     * Lists all grado entities.
     *
     * @Route("/", name="grado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $grados = $em->getRepository('BackBundle:Grado')->findAll();

        return $this->render('BackBundle:grado:index.html.twig', array(
            'grados' => $grados,
        ));
    }

    /**
     * Creates a new grado entity.
     *
     * @Route("/new", name="grado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $grado = new Grado();
        $form = $this->createForm('BackBundle\Form\GradoType', $grado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grado);
            $em->flush();

            return $this->redirectToRoute('grado_show', array('id' => $grado->getId()));
        }

        return $this->render('BackBundle:grado:new.html.twig', array(
            'grado' => $grado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a grado entity.
     *
     * @Route("/{id}", name="grado_show")
     * @Method("GET")
     */
    public function showAction(Grado $grado)
    {
        $deleteForm = $this->createDeleteForm($grado);

        return $this->render('BackBundle:grado:show.html.twig', array(
            'grado' => $grado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing grado entity.
     *
     * @Route("/{id}/edit", name="grado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Grado $grado)
    {
        $deleteForm = $this->createDeleteForm($grado);
        $editForm = $this->createForm('BackBundle\Form\GradoType', $grado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grado_edit', array('id' => $grado->getId()));
        }

        return $this->render('BackBundle:grado:edit.html.twig', array(
            'grado' => $grado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a grado entity.
     *
     * @Route("/{id}", name="grado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Grado $grado)
    {
        $form = $this->createDeleteForm($grado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($grado);
            $em->flush();
        }

        return $this->redirectToRoute('grado_index');
    }

    /**
     * Creates a form to delete a grado entity.
     *
     * @param Grado $grado The grado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grado $grado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('grado_delete', array('id' => $grado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

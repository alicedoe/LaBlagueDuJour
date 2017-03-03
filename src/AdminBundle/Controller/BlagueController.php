<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Blague;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blague controller.
 *
 * @Route("blague")
 */
class BlagueController extends Controller
{
    /**
     * Lists all blague entities.
     *
     * @Route("/", name="blague_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blagues = $em->getRepository('AdminBundle:Blague')->findAll();

        return $this->render('blague/index.html.twig', array(
            'blagues' => $blagues,
        ));
    }

    /**
     * Creates a new blague entity.
     *
     * @Route("/new", name="blague_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blague = new Blague();
        $form = $this->createForm('AdminBundle\Form\BlagueType', $blague);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blague);
            $em->flush($blague);

            return $this->redirectToRoute('blague_show', array('id' => $blague->getId()));
        }

        return $this->render('blague/new.html.twig', array(
            'blague' => $blague,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blague entity.
     *
     * @Route("/{id}", name="blague_show")
     * @Method("GET")
     */
    public function showAction(Blague $blague)
    {
        $deleteForm = $this->createDeleteForm($blague);

        return $this->render('blague/show.html.twig', array(
            'blague' => $blague,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blague entity.
     *
     * @Route("/{id}/edit", name="blague_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Blague $blague)
    {
        $deleteForm = $this->createDeleteForm($blague);
        $editForm = $this->createForm('AdminBundle\Form\BlagueType', $blague);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blague_edit', array('id' => $blague->getId()));
        }

        return $this->render('blague/edit.html.twig', array(
            'blague' => $blague,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blague entity.
     *
     * @Route("/{id}", name="blague_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Blague $blague)
    {
        $form = $this->createDeleteForm($blague);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blague);
            $em->flush($blague);
        }

        return $this->redirectToRoute('blague_index');
    }

    /**
     * Creates a form to delete a blague entity.
     *
     * @param Blague $blague The blague entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Blague $blague)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blague_delete', array('id' => $blague->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

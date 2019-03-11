<?php

namespace CIR\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CIR\Bundle\Entity\SumitomoMain;
use CIR\Bundle\Form\SumitomoMainType;

/**
 * SumitomoMain controller.
 *
 * @Route("/sumitomomain")
 */
class SumitomoMainController extends Controller
{

    /**
     * Lists all SumitomoMain entities.
     *
     * @Route("/", name="sumitomomain")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CIRBundle:SumitomoMain')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SumitomoMain entity.
     *
     * @Route("/", name="sumitomomain_create")
     * @Method("POST")
     * @Template("CIRBundle:SumitomoMain:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SumitomoMain();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sumitomomain_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a SumitomoMain entity.
    *
    * @param SumitomoMain $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SumitomoMain $entity)
    {
        $form = $this->createForm(new SumitomoMainType(), $entity, array(
            'action' => $this->generateUrl('sumitomomain_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SumitomoMain entity.
     *
     * @Route("/new", name="sumitomomain_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SumitomoMain();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SumitomoMain entity.
     *
     * @Route("/{id}", name="sumitomomain_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CIRBundle:SumitomoMain')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SumitomoMain entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SumitomoMain entity.
     *
     * @Route("/{id}/edit", name="sumitomomain_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CIRBundle:SumitomoMain')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SumitomoMain entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SumitomoMain entity.
    *
    * @param SumitomoMain $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SumitomoMain $entity)
    {
        $form = $this->createForm(new SumitomoMainType(), $entity, array(
            'action' => $this->generateUrl('sumitomomain_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SumitomoMain entity.
     *
     * @Route("/{id}", name="sumitomomain_update")
     * @Method("PUT")
     * @Template("CIRBundle:SumitomoMain:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CIRBundle:SumitomoMain')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SumitomoMain entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sumitomomain_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SumitomoMain entity.
     *
     * @Route("/{id}", name="sumitomomain_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CIRBundle:SumitomoMain')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SumitomoMain entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sumitomomain'));
    }

    /**
     * Creates a form to delete a SumitomoMain entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sumitomomain_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

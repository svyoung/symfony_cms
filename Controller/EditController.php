<?php

namespace CIR\Bundle\Controller;

use CIR\Bundle\Form\SumitomoMainType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CIR\Bundle\Entity\SumitomoSub;
use CIR\Bundle\Entity\SumitomoMain;
use CIR\Bundle\Form\Type\SubType;
use CIR\Bundle\Form\Type\LogType;
use CIR\Bundle\Entity;


/**
 * Class EditController
 * @package CIR\Bundle\Controller
 * @Route("/edit")
 */
class EditController extends Controller
{
    /*************************************************************************************
     *                                      EDIT DA
     *************************************************************************************/

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="edit_home")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return array(
                'hello'      => "Hello!",
            );
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/editda/", name="edit_editda")
     * @Template("CIRBundle:Edit:editda.html.twig")
     */
    public function editDAIndexAction(Request $request) {
        $form = $this->createDAForm();
        $form->handleRequest($request);

        if($form->isValid()) {

            return $this->redirect($this->generateUrl('edit_showda', array(
                        'dano' => $form->get('dano')->getData()
                    )));
        }
        return array(
            'searchdaform'      => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/editda/{dano}", name="edit_showda")
     * @Method("GET")
     * @Template()
     */
    public function showDAAction($dano) {

        $getda = $this->getDoctrine()
            ->getRepository('CIRBundle:SumitomoMain')
            ->findByDano($dano);
        if (!$getda) {
            throw $this->createNotFoundException('Unable to find DA #');
        }

        $deleteform = $this->deleteDAForm($dano);

        return $this->render('CIRBundle:Edit:editda.html.twig', array(
                'dano' => $getda,
                'delete' => $deleteform->createView()
            ));
    }

    /**
     * @param Request $request
     * @param $dano
     * @Route("/editda/{dano}/edit", name="edit_edit_da")
     * @Method("GET")
     * @Template("CIRBundle:Edit:editda.html.twig")
     */
    public function editDAAction($dano) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CIRBundle:SumitomoMain')->findOneByDano($dano);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DA');
        }

        $editform = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'editform'    => $editform->createView()
         );

    }

    /**
     * Creates a form to edit a SumitomoMain entity.
     * @param SumitomoMain $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createEditForm(SumitomoMain $entity)
    {
        $form = $this->createForm(new SumitomoMainType(), $entity, array(
                'action' => $this->generateUrl('edit_updateda', array('dano' => $entity->getDano())),
                'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * @param Request $request
     * @param $dano
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/{dano}", name="edit_updateda")
     * @Method("PUT")
     * @Template("CIRBundle:Edit:editda.html.twig")
     */
    public function updateDAAction(Request $request, $dano) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CIRBundle:SumitomoMain')->findOneByDano($dano);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SumitomoMain entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('edit_home'));
        }

        return array(
            'entity'      => $entity,
            'editform'   => $editForm->createView(),
        );
    }

    public function createDAForm() {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('dano', 'text', array(
                    'label' => 'DA #',
                ))
            ->add('submit','submit')
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @param $dano
     * @Route("/{dano}", name="edit_deleteda")
     * @Method("DELETE")
     */
    public function deleteDAAction(Request $request, $dano) {

        $form = $this->deleteDAForm($dano);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CIRBundle:SumitomoMain')->findOneByDano($dano);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity to delete.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('submit_success'));
    }

    /**
     * @param $dano
     * @return \Symfony\Component\Form\Form
     */
    public function deleteDAForm($dano) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('edit_deleteda', array('dano' => $dano)))
            ->setMethod('DELETE')
            ->add('delete','submit', array(
                    'label' => 'Delete'
                ))
            ->getForm();

    }

    /*************************************************************************************
     *                                      EDIT PARTS
     *************************************************************************************/

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/editparts/", name="edit_editparts")
     * @Method("GET")
     * @Template("CIRBundle:Edit:editparts.html.twig")
     */
    public function editPartIndexAction(Request $request) {
        $form = $this->createDAForm();
        $form->handleRequest($request);

        if($form->isValid()) {

            return $this->redirect($this->generateUrl('edit_showparts', array(
                        'dano' => $form->get('dano')->getData()
                    )));
        }
        return array(
            'searchpartsform'      => $form->createView(),
        );
    }

    /**
     * @param $dano
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/editparts/{dano}", name="edit_showparts")
     */
    public function showPartsAction($dano) {
        $getparts = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub')
            ->findPartsByDano($dano);

        if (!$getparts) {
            throw $this->createNotFoundException('Unable to find DA #');
        }

        for($i = 0; $i < $getparts; $i++) {
            //var_dump($getparts[$i]);
            global $subid;
            foreach($getparts as $key => $subid) {
                $subid = $subid['subid'];
            }

                //exit(\Doctrine\Common\Util\Debug::dump($getparts));

            $deleteform = $this->deletePartsForm($subid);

            return $this->render('CIRBundle:Edit:editparts.html.twig', array(
                    'dano' => $getparts,
                    'deleteform' => $deleteform->createView()
                ));
        }
    }

    /**
     * @param Request $request
     * @param $dano
     * @Route("/editparts/{dano}/{subid}/edit", name="edit_edit_parts")
     * @Method("GET")
     * @Template("CIRBundle:Edit:editparts.html.twig")
     */
    public function editPartsAction($dano, $subid) {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CIRBundle:SumitomoSub')->findPartsByDanoSub($dano,$subid);

        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Parts entity to edit.');
        }

        $entity2 = $em->getRepository('CIRBundle:SumitomoSub')->findOneById($subid);

        $form = $this->editPartsForm($entity2);
        $deleteform = $this->deletePartsForm($subid);

       //exit(\Doctrine\Common\Util\Debug::dump($deleteform->getData()));

        return array(
            'editpartentity'      => $entities,
            'editpartsform'     => $form->createView(),
            'deleteform'        => $deleteform->createView()
        );
    }

    public function editPartsForm($entity) {
        $form = $this->createForm(new SubType(), $entity, array(
                'action' => $this->generateUrl('edit_updateparts', array('subid' => $entity->getId())),
                'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * @param $subid
     * @Route("/editparts/{subid}/", name="edit_updateparts")
     * @Template("CIRBundle:Edit:editparts.html.twig")
     * @Method("PUT")
     */
    public function updatePartsAction(Request $request, $subid) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CIRBundle:SumitomoSub')->findOneById($subid);
        //exit(\Doctrine\Common\Util\Debug::dump($entities));

        $form = $this->editPartsForm($entities);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('submit_success'));
        }

        return array(
            'entity'      => $entities,
            'editform'   => $form->createView(),
        );
    }

    /**
     * @Route("/editparts/delete/{subid}", name="edit_deleteparts")
     * @Method("POST")
     */
    public function deletePartsAction($subid) {

        $getid = $this->getDoctrine()
                ->getRepository('CIRBundle:SumitomoSub')
                ->findOneById($subid);

        $em = $this->getDoctrine()->getManager();
                $em->remove($getid);
                $em->flush();

        return $this->redirect($this->generateUrl('submit_success'));
    }

    /**
     * @param $subid
     * @return \Symfony\Component\Form\Form
     */
    public function deletePartsForm($subid) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('edit_deleteparts', array('subid' => $subid)))
            ->setMethod('DELETE')
            ->add('delete','submit', array(
                    'label' => 'Delete'
                ))
            ->getForm();

    }

    /*************************************************************************************
     *                                   EDIT SHIPPED
     *************************************************************************************/

    /**
     * @param Request $request
     * @return Response
     * @Route("/editshipped/", name="edit_shippedhome")
     */
    public function searchShippedAction(Request $request) {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('shipdate','date', array(
                    'label' => 'Date Out: ',
                    'widget' => 'single_text'
                ))
            ->add('submit','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->forward('CIRBundle:Edit:showShipped', array(
                        'shipdate' => $form->get('shipdate')->getData()
                    ));
        }

        return $this->render('CIRBundle:Edit:editshipped.html.twig', array(
            'shippedform' => $form->createView()
        ));
    }

    /**
     * @param $shipdate
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showShippedAction($shipdate) {
        $getshipped = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub')
                        ->findShippedByDate($shipdate);

        if(!$getshipped) {
            throw $this->createNotFoundException("Cannot find based on Ship Date");
        }

        return $this->render('CIRBundle:Edit:editshipped.html.twig', array(
                'getshipped' => $getshipped
            ));
    }

    /**
     * @param $logid
     * @param Request $request
     * @Route("/editshipped/{logid}/edit", name="edit_edit_shipped")
     */
    public function editShippedAction(Request $request, $logid) {
        $r = $this->getDoctrine()->getRepository('CIRBundle:SumitomoLog');
        $logentity = $r->findOneById($logid);

        $findsubid = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub')
                ->findSubByLog($logid);

        $form = $this->editShippedForm($logentity);

        return $this->render('CIRBundle:Edit:editshipped.html.twig', array(
                'editshippedform' => $form->createView(),
                'getsub' => $findsubid
            ));
    }

    public function editShippedForm($entity) {
        $form = $this->createForm(new LogType(), $entity, array(
                'action' => $this->generateUrl('edit_updateshipped', array('logid' => $entity->getId())),
                'method' => 'PUT'
        ));

        return $form;
    }

    /**
     * @param $logid
     * @Route("/editshipped/{logid}/", name="edit_updateshipped")
     * @Template("CIRBundle:Edit:editshipped.html.twig")
     * @Method("PUT")
     */
    public function updateShippedAction(Request $request, $logid) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CIRBundle:SumitomoLog')
                ->findOneById($logid);

        $form = $this->editShippedForm($entity);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('submit_success'));
        }

        return array(
            'entity'      => $entity,
            'editform'   => $form->createView(),
        );

    }

}
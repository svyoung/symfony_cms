<?php

namespace CIR\Bundle\Controller;

use CIR\Bundle\Entity\SumitomoMain;
use CIR\Bundle\Form\SumitomoMainType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CIR\Bundle\Form\Type\NewDAType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 *
 * NewDA Controller
 * @Route("/newda")
 */
class NewDAController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/", name="newda_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $newda = new SumitomoMain();

        $form = $this->createNewDAForm($newda);

        return array(
            'form' => $form->createView()
        );

    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/", name="newda_add")
     * @Method("POST")
     * @Template()
     */
    public function addDAAction(Request $request) {

        $entity = new SumitomoMain();
        $form = $this->createNewDAForm($entity);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newda_show', array('dano' => $entity->getDano())));
        }

        return array(
            'form' => $form->createView()
        );

    }

    public function createNewDAForm(SumitomoMain $entity) {
        $form = $this->createForm( new SumitomoMainType(), $entity, array(
                'action' => $this->generateUrl('newda_add'),
                'method' => 'POST'
            ) );

        $form->add('Submit','submit', array(
                'label' => 'Add'
            ));

        return $form;
    }

    /**
     * @Route("/{dano}", name="newda_show")
     * @Method("GET")
     * @Template("CIRBundle:NewDA:show.html.twig")
     */
    public function showDAAction($dano) {

        $repository = $this->getDoctrine()->getRepository('CIRBundle:SumitomoMain');

        $entity = $repository->findOneByDano($dano);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return array(
            'newda' => $entity
        );

    }

}

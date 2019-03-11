<?php

namespace CIR\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CIR\Bundle\Entity\SumitomoSub;
use CIR\Bundle\Entity\SumitomoMain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ShipmentController
 * @package CIR\Bundle\Controller
 * @Route("/log")
 */
class ShipmentController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="log_home")
     */
    public function indexAction()
    {
        return $this->render('CIRBundle:Shipment:index.html.twig');
    }

    /**
     * @Route("/searchsub/", name="log_searchsub")
     * @Method("GET")
     * @Template()
     */
    public function searchSubAction(Request $request) {
        $em = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub');
        $entities = $em->searchSub();

        $form = $this->searchDAForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl('log_searchdano', array(
                        'dano' => $form->get('dano')->getData()
                    )));
        }

            //var_dump($entities);
            return array(
                'entities' => $entities,
                'form' => $form->createView()
            );
    }

    public function searchDAForm() {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('dano','text', array(
                    'label' => 'Search by DA: '
                ))
            ->add('submit','submit')
            ->getForm();

        return $form;
    }

    /**
     * @param $dano
     * @Route("/searchsub/{dano}", name="log_searchdano")
     * @TEmplate("CIRBundle:Shipment:searchsub.html.twig")
     */
    public function searchSubByDanoAction(Request $request, $dano) {
        $em = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub');
        $entities = $em->searchSubDano($dano);

        $form = $this->searchDAForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl('log_searchdano', array(
                        'dano' => $form->get('dano')->getData()
                    )));
        }

        return array(
            'entities' => $entities,
            'form' => $form->createView()
        );
    }

}
<?php

namespace CIR\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package CIR\Bundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="cir_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        return $this->render('CIRBundle:Default:index.html.twig');
    }

    /**
     * @Route("/", name="submit_success")
     * @Method("GET")
     */
    public function submitSuccessAction() 
    {
    	return $this->render('CIRBundle:Default:submit.html.twig', array(
                'message' => "Submit success!"
            ));
    }

    /**
     * @Route("/", name="delete_success")
     * @Method("GET")
     */
    public function deleteSuccessAction() {
        return $this->render('CIRBundle:Default:submit.html.twig', array(
                'message' => "Delete success!"
            ));
    }
}

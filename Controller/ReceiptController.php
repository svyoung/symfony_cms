<?php

namespace CIR\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReceiptController extends Controller
{
    public function indexAction()
    {
		
        return $this->render('CIRBundle:Receipt:index.html.twig');
    }


}
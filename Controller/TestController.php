<?php

namespace CIR\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CIR\Bundle\Entity\SumitomoSub;
use CIR\Bundle\Entity\SumitomoMain;


/**
 * Class TestController
 * @package CIR\Bundle\Controller
 * @Route("/test", name="test_home")
 */
class TestController extends Controller
{
    /**
     * @Route("/", name="test_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('dano','text',array(
                    'label' => 'Search DA: '
                ))
            ->add('Submit','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl('test_danoshow', array(
                        'dano' => $form->get('dano')->getData(),
                    )));
        }

        return $this->render('CIRBundle:Test:index.html.twig', array(
                'form' => $form->createView()
            ));
    }

    /**
     * @param Request $request
     * @param $dano
     * @Route("/{dano}", name="test_danoshow")
     * @Template("CIRBundle:Test:addtest.html.twig")
     */
    public function getDanoAction($dano) {
            $r = $this->getDoctrine()->getRepository('CIRBundle:SumitomoMain');
            $entity = $r->findOneByDano($dano);

        return array(
            'entity' => $entity
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/submit/{id}", name="test_submitpart")
     * @Template("CIRBundle:Test:addtest.html.twig")
     */
    public function submitPartAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $main = $em->getRepository('CIRBundle:SumitomoMain')
            ->findOneById($id);

        $id = $request->get('id');
        $racknofirst = $request->get('rackno_first');
        $racknolast = $request->get('rackno_last');
        $heatcode = $request->get('heatcode');
        $diecode = $request->get('diecode');
        $inqty = $request->get('inqty');
        $onhold = $request->get('onhold');

        var_dump($id, $racknofirst, $racknolast, $heatcode, $diecode, $onhold);

        if(!$racknolast) {
            $racknolast = $racknofirst;
        }

        for($i = $racknofirst; $i <= $racknolast; $i++) {
            $newsub = new SumitomoSub();
            $main->addSub($newsub);
            $newsub->setRackno($i);
            $newsub->setHeatcode($heatcode);
            $newsub->setDiecode($diecode);
            $newsub->setInqty($inqty);
            $newsub->setOnhold($onhold);
            $em->persist($newsub);
            $em->flush();
        }

        return array(
           'hi' => "hello there!"
        );

    }

}

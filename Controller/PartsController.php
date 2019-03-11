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
use CIR\Bundle\Form\Type\MainType;
use CIR\Bundle\Form\Type\SubType;

/**
 * Class PartsController
 * @package CIR\Bundle\Controller
 * @Route("/parts")
 */
class PartsController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/", name="subpart_home")
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
            return $this->redirect($this->generateUrl('subpart_part', array(
                        'dano' => $form->get('dano')->getData(),
                    )));
        }
        return array(
                'form' => $form->createView()
            );
    }


    /**
     * @param Request $request
     * @param $dano
     * @Route("/{dano}", name="subpart_part")
     * @Template("CIRBundle:Parts:addparts.html.twig")
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
     * @Route("/{id}/submit/", name="subpart_submitpart")
     * @Template("CIRBundle:Parts:addparts.html.twig")
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

            return $this->redirect($this->generateUrl('subpart_home'));
        }

        return array(
            'entity' => $main
        );

    }

}
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
use Doctrine\ORM\Query;

/**
 * ReportsController
 *
 * @Route("/reports")
 */
class ReportsController extends Controller
{
    /**
     * @Route("/", name="reports_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        $repository = $this->getDoctrine()->getRepository('CIRBundle:SumitomoMain');

        $entity = $repository->find(3);

        return array(
            'entity' => $entity,
//            'response' => $response
        );
    }

    //Search by DA #
    /**
     * @Route("/", name="reports_home")
     * @Method("GET")
     */
    public function searchDAAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('dano', 'text', array(
                    'label' => 'DA #',
                ))
            ->add('submit','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {

            return $this->redirect($this->generateUrl('reports_getda', array(
                    'dano' => $form->get('dano')->getData()
                )));
        }

        return $this->render('CIRBundle:Reports:index.html.twig', array(
                'daform'      => $form->createView(),
            ));
    }

    //Get DA info
    /**
     * @param $dano
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/da/{dano}", name="reports_getda")
     */

    public function getDAAction($dano) {

        $getda = $this->getDoctrine()
            ->getRepository('CIRBundle:SumitomoSub')
            ->findInventoryByDano($dano);
        if (!$getda) {
            throw $this->createNotFoundException('Unable to find DA #');
        }

        return $this->render('CIRBundle:Reports:da.html.twig', array(
                'getda' => $getda
            ));
    }

    //Search Part
    /**
     * @param Request $request
     * @return Response
     * @Route("/parts", name="reports_parts")
     * @Method("GET")
     */
    public function searchPartAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('partno', 'text', array(
                    'label' => 'Part #',
                ))
            ->add('submit','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {

            return $this->redirect($this->generateUrl('reports_getpart', array(
                    'partno' => $form->get('partno')->getData()
                )));
        }

        return $this->render('CIRBundle:Reports:index.html.twig', array(
                'partform'      => $form->createView(),
            ));
    }

    //Get Part info
    /**
     * @param $partno
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/parts/{partno}", name="reports_getpart")
     * @Method("GET")
     */
    public function getPartAction($partno) {

        $getpart = $this->getDoctrine()
            ->getRepository('CIRBundle:SumitomoSub')
            ->findInventoryByPart($partno);

        if(!$getpart) {
            throw $this->createNotFoundException('Unable to find Part #');
        }

        return $this->render('CIRBundle:Reports:parts.html.twig', array(
                'getpart' => $getpart
            ));

    }

    //Search Batch
    /**
     * @param Request $request
     * @return Response
     * @Route("/batch", name="reports_batch")
     * @Method("GET")
     */
    public function searchBatchAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('batchno', 'text', array(
                    'label' => 'Batch #',
                ))
            ->add('submit','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {

            return $this->redirect($this->generateUrl('reports_getbatch', array(
                    'batchno' => $form->get('batchno')->getData()
                )));
        }

        return $this->render('CIRBundle:Reports:index.html.twig', array(
                'batchform'      => $form->createView(),
            ));
    }

    //Get Batch info
    /**
     * @param $batchno
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/batch/{batchno}", name="reports_getbatch")
     * @Method("GET")
     */
    public function getBatchAction($batchno) {

        $getbatch = $this->getDoctrine()
            ->getRepository('CIRBundle:SumitomoSub')
            ->findInventoryByBatch($batchno);

        if(!$getbatch) {
            throw $this->createNotFoundException('Unable to find Batch #');
        }

        return $this->render('CIRBundle:Reports:batch.html.twig', array(
                'getbatch' => $getbatch
            ));

    }

    // Generate Parts Summary and Details
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/parts/", name="reports_genparts")
     * @Method("GET")
     * @Template("CIRBundle:Reports:partsum.html.twig")
     */
    public function partsSumAction(Request $request) {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('generate','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl('reports_showpartsum'));
        }

        return array(
            'generateparts' => $form->createView()
        );
    }

    // Show part summary and details
    /**
     * @Route("/parts/results/", name="reports_showpartsum")
     * @Method("GET")
     * @Template("CIRBundle:Reports:partsum.html.twig")
     */
    public function genPartsSumAction() {
        $em = $this->getDoctrine()->getManager();
//        $test = $em->getRepository('CIRBundle:SumitomoSub')
//                ->test();

        $subq = $em->createQueryBuilder()
                ->select('m.partno, SUM(s.inqty) inqty')
                ->from('CIRBundle:SumitomoSub', 's')
                ->join('s.main', 'm')
                ->where('s.onhold != 1')
                ->groupby('s.rackno, m.partno')
                ->getDQL();

        var_dump($subq);

        $query = $this->_em->createQueryBuilder()
                ->select('m.partno, SUM(s.inqty inqty')
                ->where($query->expr()->in('s.id',$subq));

        var_dump($query);

        return array(
            'subq' => $subq
        );

    }

    // Print Date Summary
    /**
     * @param Request $request
     * @return Response
     * @Route("/datesum", name="reports_datesum")
     * @Method("GET")
     */
    public function searchDateSumAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('fromdate','date', array(
                    'label' => 'From: ',
                    'widget' => 'single_text'
                ))
            ->add('todate','date', array(
                    'label' => 'To: ',
                    'widget' => 'single_text'
                ))
            ->add('generate','submit')
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid()) {

            return $this->forward('CIRBundle:Reports:getDateSum', array(
                    'fromdate' => $form->get('fromdate')->getData(),
                    'todate' => $form->get('todate')->getData()
                ));
        }
        return $this->render('CIRBundle:Reports:index.html.twig', array(
                'datesumform'    => $form->createView(),
            ));
    }

    /**
     * @param $fromdate
     * @param $todate
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/datesum/{fromdate}/{todate}", name="reports_showdatesum")
     */
    public function getDateSumAction($fromdate, $todate) {
        $repository = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub');

        $gettotalins = $repository->totalInByDate($fromdate, $todate);

        if(!$gettotalins) {
            throw $this->createNotFoundException('Unable to find Date Summary');
        }

        $gettotalouts = $repository->distinctTotalOutByDate($fromdate,$todate);

        $getreceived = $repository->receivedByDate($fromdate,$todate);

        $getshipped = $repository->shippedByDate($fromdate,$todate);


        return $this->render('CIRBundle:Reports:datesum.html.twig', array(
                'gettotalins' => $gettotalins,
                'gettotalouts' => $gettotalouts,
                'getreceived' => $getreceived,
                'getshipped' => $getshipped,
                'fromdate' => $fromdate,
                'todate' => $todate
            ));
    }

    /**
     * @param Request $request
     * @Route("/onhold", name="reports_onhold")
     * @Method("GET")
     * @Template("CIRBundle:Reports:onhold.html.twig")
     */
    public function onHoldAction(Request $request) {
        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('generate','submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            return $this->redirect($this->generateUrl('reports_showonhold'));
        }

        return array(
               'onhold' => $form->createView()
            );
    }

    /**
     * @Route("/onhold/results", name="reports_showonhold")
     * @Method("GET")
     */
    public function getOnHoldAction() {
        $repository = $this->getDoctrine()->getRepository('CIRBundle:SumitomoSub');
        $results = $repository->findOnHold(1);

        //exit(\Doctrine\Common\Util\Debug::dump($results));

        return $this->render('CIRBundle:Reports:onhold.html.twig', array(
                'results' => $results
            ));
    }



}

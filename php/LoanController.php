<?php

namespace Lynx\OnLoanBundle\Controller;

use Lynx\OnLoanBundle\Entity\Email;
use Lynx\OnLoanBundle\Entity\Loan;
use Lynx\OnLoanBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends Controller
{
    public function newAction()
    {
        // getting params from GET
        $sum = $this->getRequest()->query->get('sum');
        $uid = $this->getRequest()->query->get('uid');
        $comment = $this->getRequest()->query->get('comment');
        $site = parse_url($this->getRequest()->server->get('HTTP_REFERER'),PHP_URL_HOST);

        $seller = $this->getDoctrine()->getRepository('LynxOnLoanBundle:Seller')->findOneBy(array(
            'uid' => $uid,
            'site' => $site
        ));

        if (!$seller) {
            return $this->render('LynxOnLoanBundle:Loan:error.html.twig', array(
                'site' => $site
            ));
        }


        return $this->render('LynxOnLoanBundle:Loan:new.html.twig', array(
            'sum' => $sum,
            'seller' => $seller,
            'comment' => $comment
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest()->request;
        $site = parse_url($this->getRequest()->server->get('HTTP_REFERER'),PHP_URL_HOST);

        $seller = $this->getDoctrine()->getRepository('LynxOnLoanBundle:Seller')->findOneBy(array(
            'uid' => $request->get('seller'),
            'site' => $site

        ));

        if (!$seller) {
            return $this->render('LynxOnLoanBundle:Loan:error.html.twig',array(
                'site' => $site
            ));
        }

        if ($seller->isActive()) {

            $bank = $this->getDoctrine()->getManager()->getRepository('LynxOnLoanBundle:Bank')->find(1);
            //creating loan
            $loan = new Loan();
            $loan->setClient($request->get('client'))
                 ->setBank($bank)
                 ->setSum($request->get('sum'))
                 ->setSeller($seller)
                 ->setComment($request->get('comment'))
                 ;
            $this->getDoctrine()->getManager()->persist($loan);
            $this->getDoctrine()->getManager()->flush();

            //creating emails to C and B

            $emailToClient = new Email();
            $emailToClient->setTo($loan->getClient()->email)
                ->setFrom($this->container->getParameter('email'))
                ->setSubject('Заявка на кредит отправлена в банк')
                ->setMessage($this->renderView('LynxOnLoanBundle:Emails:instructions.html.twig',array(
                'loan' => $loan
            )));

            $emailToBank = new Email();
            $emailToBank->setTo($loan->getSeller()->getEmail())
                ->setFrom($this->container->getParameter('email'))
                ->setSubject('Поступление новой заявки на кредит')
                ->setMessage($this->renderView('LynxOnLoanBundle:Emails:loan.html.twig',array(
                'loan' => $loan
            )));


            $this->getDoctrine()->getManager()->persist($emailToClient);
            $this->getDoctrine()->getManager()->persist($emailToBank);

            $this->getDoctrine()->getManager()->flush();
        }

        //return success message
        return new Response();
    }

    
}

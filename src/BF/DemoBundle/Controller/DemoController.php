<?php

namespace BF\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use BF13\BusinessApplicationBundle\Controller\baseController;
use BF13\BusinessApplicationBundle\Service\Breadcrumb\BreadcrumbControllerInterface;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DemoController extends baseController implements BreadcrumbControllerInterface
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->generateForm('BFDemoBundle:ContactForm');

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('bf_demo'));
            }
        }

        return array('form' => $form->createView());
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

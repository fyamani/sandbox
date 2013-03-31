<?php

namespace BF\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use BF13\BusinessApplicationBundle\Controller\baseController;
use BF13\BusinessApplicationBundle\Service\Breadcrumb\BreadcrumbControllerInterface;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BF\DemoBundle\Model\ContactMessage;

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
        $contactMessage = new ContactMessage();

        $form = $this->generateForm('BFDemoBundle:ContactForm', $contactMessage);

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

    public function listerContactsAction()
    {
        $contacts = array(
            array('id' => 1, 'name' => 'john', 'email' => 'john@free.fr'),
        );

        $datagrid = $this->generateDatagrid('BFDemoBundle:ListeContacts');

        $datagrid->bind($contacts);

        return $this->render('BFDemoBundle:Demo:liste_contacts.html.twig', array('datagrid' => $datagrid));
    }

    public function ValueListAction()
    {
        return $this->render('BFDemoBundle:Demo:value_list.html.twig');
    }

    public function callMessageAction()
    {
        $this->addSuccessMessage('demo message');

        $url = $this->generateUrl('bf_demo_render_message');

        return $this->redirect($url);
    }

    public function renderMessageAction()
    {
        return $this->render('BFDemoBundle:Demo:render_message.html.twig');
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

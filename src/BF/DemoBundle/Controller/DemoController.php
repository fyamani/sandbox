<?php

namespace BF\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use BF\Bundle\SharedBundle\Controller\Controller;
use BF13\Component\Breadcrumb\BreadcrumbControllerInterface;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BF\DemoBundle\Model\ContactMessage;

class DemoController extends Controller implements BreadcrumbControllerInterface
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

        $form = $this->generateForm('BFDemoBundle:form:ContactForm', $contactMessage);

        $request = $this->get('request');

        if ('POST' == $request->getMethod()) {

            try {

                $this->validateForm($form, $request);

                $mailer = $this->get('mailer');

                //actions

                $this->addSuccessMessage('Message sent!');

                return new RedirectResponse($this->generateUrl('bf_demo'));

            } catch (\Exception $e) {


            }
        }

        $code_data = array(
            'Controller' => array('file' => __FILE__, 'type' => 'php', 'highlight' => array(34)),
            'Render' => array('file' => __DIR__ . '/../Resources/views/Demo/contact.html.twig', 'type' => 'twig'),
            'Form' => array('file' => __DIR__ . '/../Resources/config/form/ContactForm.form.yml', 'type' => 'yaml'),
        );

        return array('form' => $form->createView(), 'code_data' => $code_data);
    }

    public function listerContactsAction()
    {
        $contacts = array(
            array('id' => 1, 'name' => 'john', 'email' => 'john@free.fr'),
        );

        $datagrid = $this->generateDatagrid('BFDemoBundle:ListeContacts');

        $datagrid->bind($contacts);

        $code_data = array(
                'Controller' => array('file' => __FILE__, 'type' => 'php', 'highlight' => array(65)),
                'Render' => array('file' => __DIR__ . '/../Resources/views/Demo/liste_contacts.html.twig', 'type' => 'twig'),
                'Form' => array('file' => __DIR__ . '/../Resources/config/datagrid/ListeContacts.datagrid.yml', 'type' => 'yaml'),
        );

        return $this->render('BFDemoBundle:Demo:liste_contacts.html.twig', array('datagrid' => $datagrid, 'code_data' => $code_data));
    }

    public function ValueListAction()
    {
        $code_data = array(
                'Render' => array('file' => __DIR__ . '/../Resources/views/Demo/value_list.html.twig', 'type' => 'twig', 'highlight' => array(6)),
        );

        return $this->render('BFDemoBundle:Demo:value_list.html.twig', array('code_data' => $code_data));
    }

    public function callMessageAction()
    {
        $this->addSuccessMessage('demo success message');

        $this->addErrorMessage('demo error message');

        $url = $this->generateUrl('bf_demo_render_message');

        return $this->redirect($url);
    }

    public function renderMessageAction()
    {
        $code_data = array(
                'Controller' => array('file' => __FILE__, 'type' => 'php', 'highlight' => array(96, 98)),
        );

        return $this->render('BFDemoBundle:Demo:render_message.html.twig', array('code_data' => $code_data));
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

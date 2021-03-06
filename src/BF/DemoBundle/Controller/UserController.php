<?php
namespace BF\DemoBundle\Controller;

use BF\Bundle\SharedBundle\Controller\Controller;

use BF13\Component\Breadcrumb\BreadcrumbControllerInterface;
use BF13\Component\Notification\NotificationMessage;

/**
 */
class UserController extends Controller implements BreadcrumbControllerInterface
{
    public function ListerMessagesAction()
    {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $datagrid = $this->generateDatagrid('BFDemoBundle:ListeMessages', array('username' => $username));

        return $this->render('BFDemoBundle:User/Message:liste_messages.html.twig', array('datagrid' => $datagrid));
    }

    public function PosterMessageAction()
    {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $message = new NotificationMessage();

        $message
            ->setFrom($username)
            ->setSubject('Nouveau message')
            ->setContent('Contenu')
            ;

        $form = $this->generateForm('BFDemoBundle:form:PosterMessage', $message);

        $request = $this->get('request');

        if ('POST' == $request->getMethod()) {

            $form->submit($request);

            if($form->isValid())
            {
                $notifier = $this->get('bf13.app.notification');

                $notifier->addMessage($message);

                $this->addSuccessMessage('Votre message a été posté.');

                $url = $this->generateUrl('bf_demo_user_messages');

                return $this->redirect($url);
            }
        }

        return $this->render('BFDemoBundle:User/Message:add.html.twig', array('form' => $form->createView()));
    }

    public function AfficherUtilisateurAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->render('BFDemoBundle:User:show.html.twig', array('user' => $user));
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}
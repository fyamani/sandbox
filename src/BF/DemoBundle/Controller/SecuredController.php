<?php

namespace BF\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use BF13\BusinessApplicationBundle\Controller\baseController;
use BF13\BusinessApplicationBundle\Service\Breadcrumb\BreadcrumbControllerInterface;


/**
 */
class SecuredController extends baseController implements BreadcrumbControllerInterface
{
    /**
     * @Template()
     */
    public function loginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $form = $this->generateForm('BFDemoBundle:LoginForm');

        return array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'form' => $form->createView()
        );
    }

    /**
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

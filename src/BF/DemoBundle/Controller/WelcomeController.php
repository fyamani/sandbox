<?php

namespace BF\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BF13\BusinessApplicationBundle\Controller\baseController;
use BF13\BusinessApplicationBundle\Service\Breadcrumb\BreadcrumbControllerInterface;

class WelcomeController extends baseController implements BreadcrumbControllerInterface
{
    public function indexAction()
    {
        return $this->render('BFDemoBundle:Welcome:index.html.twig');
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

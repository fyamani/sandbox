<?php

namespace BF\DemoBundle\Controller;

use BF13\Bundle\BusinessApplicationBundle\Controller\Controller;
use BF13\Component\Breadcrumb\BreadcrumbControllerInterface;

class WelcomeController extends Controller implements BreadcrumbControllerInterface
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

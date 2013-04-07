<?php

namespace BF\DemoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use BF13\BusinessApplicationBundle\Controller\baseController;
use BF13\BusinessApplicationBundle\Breadcrumb\BreadcrumbControllerInterface;

/**
 */
class ValueListController extends baseController implements BreadcrumbControllerInterface
{
    public function editValueAction($id)
    {
        $data = $this->getDomainRepository()->retrieve('BF13\BusinessApplicationBundle\Entity\DataValueList', $id);

        $form = $this->generateForm('BFDemoBundle:ValueListEditValueForm', $data);

        $request = $this->get('request');

        if('POST' == $request->getMethod())
        {
            try {

                $this->validateForm($form, $request);

                $this->getDomainRepository()->store($data);

                $this->addSuccessMessage('Form updated !');

            } catch (\Exception $e) {

                $this->addErrorMessage('Invalid form !');
            }
        }

        return $this->render('BFDemoBundle:Secured/ValueList:value.edit.html.twig', array('form' => $form->createView(), 'item' => $data));
    }

    public function createValueAction()
    {
        $data = $this->getDomainRepository()->retrieveNew('BF13\BusinessApplicationBundle\Entity\DataValueList');

        $form = $this->generateForm('BFDemoBundle:ValueListValueForm', $data);

        $request = $this->get('request');

        if ('POST' == $request->getMethod()) {

            try {

                $this->validateForm($form, $request);

                $this->getDomainRepository()->store($data);

                $this->addSuccessMessage('Success !');

            } catch (\Exception $e) {

                $this->addErrorMessage($e->getMessage());
            }
        }

        return $this->render('BFDemoBundle:Secured/ValueList:value.add.html.twig', array('form' => $form->createView()));
    }

    public function getBreadcrumbName()
    {
        return 'Public';
    }
}

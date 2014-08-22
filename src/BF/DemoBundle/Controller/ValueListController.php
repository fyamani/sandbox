<?php

namespace BF\DemoBundle\Controller;

use BF\Bundle\SharedBundle\Controller\Controller;
use BF13\Component\Breadcrumb\BreadcrumbControllerInterface;

/**
 */
class ValueListController extends Controller implements BreadcrumbControllerInterface
{
    public function editValueAction($id)
    {
        $data = $this->getDomainRepository()->retrieve('BF13\Bundle\BusinessApplicationBundle\Entity\DataValueList', $id);

        $form = $this->generateForm('BFDemoBundle:form:ValueListEditValueForm', $data);

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
        $data = $this->getDomainRepository()->retrieveNew('BF13\Bundle\BusinessApplicationBundle\Entity\DataValueList');

        $form = $this->generateForm('BFDemoBundle:form:ValueListValueForm', $data);

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

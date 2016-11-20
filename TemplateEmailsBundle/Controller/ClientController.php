<?php

namespace EE\Applications\TemplateEmailsBundle\Controller;

use EE\Applications\TemplateEmails\Form\SelectVersionType;
use EE\Applications\TemplateEmailsBundle\Form\EmailSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClientController
 *
 * @package EE\Applications\TemplateEmailsBundle\Controller
 */
class ClientController extends AbstractController
{

    /**
     * Gets ClientService
     *
     * @return \EE\Applications\TemplateEmailsBundle\Service\ClientService
     */
    protected function getClientService()
    {
        return $this->container->get('ee_applications_template_emails_service_client');
    }

    /**
     * Index action
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $contextEmail = $this->getEmailFromContext();

        if ($contextEmail !== null) {
            return $this->redirect($this->generateUrl(
                "ee_applications_template_emails_client_select_template",
                [
                    "email" => $contextEmail
                ]
            ));
        }

        $form = $this->createForm(new EmailSearchType());
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            return $this->redirect($this->generateUrl(
                'ee_applications_template_emails_client_select_template',
                [
                    'email' => $form->get('email')->getData()
                ]
            ));
        }

        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Select Template action
     *
     * @param Request $request
     * @param string  $email
     *
     * @return Response
     */
    public function selectTemplateAction(Request $request, $email)
    {
        $form = $this->createForm(
            new SelectVersionType(
                $email,
                $this->getClientService()->getActiveVersionKeyValueList()
            )
        );
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            return $this->redirect($this->generateUrl(
                'ee_applications_template_emails_client_fill_placeholders',
                [
                    'email' => $form->get('email')->getData(),
                    'id'    => $form->get('id')->getData()
                ]
            ));
        }

        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:selectTemplate.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}

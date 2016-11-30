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
                $this->getClientService()->getActiveVersionKeyValueList()
            )
        );
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            return $this->redirect($this->generateUrl(
                'ee_applications_template_emails_client_fill_placeholders',
                [
                    'email' => $email,
                    'id' => $form->get('id')->getData()
                ]
            ));
        }

        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:selectTemplate.html.twig',
            [
                'form'  => $form->createView(),
                'email' => $email
            ]
        );
    }

    /**
     * Fill Placeholders Action
     *
     * @param Request $request
     * @param string  $email
     * @param int     $id
     *
     * @return Response
     */
    public function fillPlaceholdersAction(Request $request, $email, $id)
    {
        $version = $this->getClientService()->getVersionById($id);

        $errors = [];
        $placeholders = [];

        try {
            $placeholderValues = $request->request->get("placeholders", []);

            if (count($placeholderValues) > 0) {
                $placeholders = $this->getClientService()->getPlaceholderWithValues($placeholderValues, $id);

                foreach ($placeholders as $placeholder) {
                    if ($placeholder->getError()) {
                        $errors[] = $placeholder->getError();
                    }
                }

                if (count($errors) === 0) {
                    $this->getClientService()->savePlaceholderValues($placeholders, $id);

                    return $this->redirect(
                        $this->generateUrl(
                            "ee_applications_template_emails_client_preview",
                            [
                                "email" => $email,
                                "id"    => $id
                            ]
                        )
                    );
                }
            } else {
                $placeholders = $this->getClientService()->getPlaceholdersByVersionId($id);
            }
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:fillPlaceholders.html.twig',
            [
                'email'        => $email,
                'version'      => $version,
                'placeholders' => $placeholders,
                'errors'       => $errors
            ]
        );
    }

    /**
     * Preview Action
     *
     * @param string  $email
     * @param int     $id
     *
     * @return Response
     */
    public function previewAction($email, $id)
    {
        $version = $this->getClientService()->getVersionById($id);

        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:preview.html.twig',
            [
                'email'        => $email,
                'version'      => $version
            ]
        );
    }

    /**
     * Preview Iframe Action
     *
     * @param int $id
     */
    public function previewIframeAction($id)
    {
        try {
            $body = $this->getClientService()->getPopulatedVersionBody($id);
        } catch (\Exception $e) {
            $body = $e->getMessage();
        }

        echo $body;
    }

    /**
     * Send action
     *
     * @param string $email
     * @param int    $id
     *
     * @return Response
     */
    public function sendAction($email, $id)
    {
        return $this->render(
            'EEApplicationsTemplateEmailsBundle:Client:sendResult.html.twig',
            $this->getClientService()->sendEmail($email, $id)
        );
    }
}
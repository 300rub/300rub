<?php

namespace EE\Applications\TemplateEmailsBundle\Controller;

use EE\Applications\AbstractBundle\Controller\AbstractController as Controller;

/**
 * Class AbstractController
 *
 * @package EE\Applications\TemplateEmailsBundle\Controller
 */
class AbstractController extends Controller
{

    /**
     * Gets EmailService
     *
     * @return \EE\Applications\TemplateEmailsBundle\Service\EmailService
     */
    protected function getEmailService()
    {
        return $this->container->get('ee_applications_template_emails_service_email');
    }
}

<?php

namespace EE\Applications\TemplateEmailsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class EmailSearchType
 *
 * @package EE\Applications\TemplateMessagesBundle\Form
 */
class EmailSearchType extends AbstractType
{

    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');

        $builder
            ->add(
                'email',
                'text',
                [
                    'constraints'     => [
                        new NotBlank(), new Email()
                    ],
                    'label'           => 'E-mail:',
                    'invalid_message' => 'Please provide a valid e-mail',
                    'error_bubbling'  => true,
                ]
            )
            ->add(
                'Open',
                'submit',
                [
                    'label' => 'Open',
                    'attr'  => [
                        'class' => 'btn btn-primary'
                    ]
                ]
            )
            ->getForm();
    }

    /**
     * No CSRF protection and set up validation groups
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection' => false
            )
        );
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return 'SearchEmail';
    }
}

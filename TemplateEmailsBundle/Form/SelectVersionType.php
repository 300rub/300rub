<?php
namespace EE\Applications\TemplateEmails\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class EmailSearchType
 *
 * @package EE\Applications\TemplateEmails\Form
 */
class SelectVersionType extends AbstractType
{

    /**
     * Email
     *
     * @var string
     */
    private $email;

    /**
     * Template list
     *
     * @var array
     */
    private $templateList;

    /**
     * Constructor
     *
     * @param string $email
     * @param array  $templateList
     */
    public function __construct($email, array $templateList)
    {
        $this->email = $email;
        $this->templateList = $templateList;
    }

    /**
     * Build form
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');

        $builder
            ->add('id', 'choice', [
                'label'           => 'Template',
                'choices'         => $this->templateList,
                'invalid_message' => 'You must select a template',
                'error_bubbling'  => true,
                'empty_value'     => 'Please select a template'
            ])
            ->add('email', 'hidden', array(
                'data' => $this->email,
                'constraints'     => [
                    new NotBlank(), new Email()
                ],
            ))
            ->add('next', 'submit', [
                'label' => 'Next',
                'attr'  => [
                    'class'       => 'btn btn-primary',
                    'data-button' => 'first'
                ]
            ]);

        $builder->getForm();
    }

    /**
     * No CSRF protection and set up validation groups
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'SelectVersionType';
    }
}
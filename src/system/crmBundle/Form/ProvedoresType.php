<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProvedoresType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre', 'text',array('required'=>true, 'label'=>'Nombre'))
			->add('contacto','text', array('required'=>true, 'label'=>'Contacto(vendedor)'))
			->add('direccion','text', array('required'=>false, 'label'=>'Direccion'))
			->add('estado', 'text', array('required'=>true, 'label'=>'Estado'))
			->add('municipio', 'text', array('required'=>true, 'label'=>utf8_decode('Municipio')))
			->add('telefono', 'text', array('required'=>false, 'label'=>'Telefono'))
			->add('telefono2', 'text', array('required'=>false, 'label'=>'Telefono2'))
			->add('otro', 'text', array('required'=>false, 'label'=>'Otro(Celuar, Fax, ect)'))
			->add('ramo', 'text', array('required'=>true, 'label'=>'Ramo'))
			->add('formaPago', 'text', array('required'=>false, 'label'=>'Forma Pago'))
			->add('email', 'text', array('required'=>true, 'label'=>'Email'))
			->add('web', 'text', array('required'=>false, 'label'=>'Sitio Web'))
			->add('observaciones', 'textarea', array('attr' => array('cols' => '5', 'rows' => '5'),'required'=>false))
			
			//   ->add('status','choice', array(array('choices' => array('1' => 'Activo', '0' => 'Inactivo'),
				//'required'=>true)))
			->add('save', 'submit', array('label' => 'Guardar' , 'attr'=>array('class'=>'btn btn-primary col-sm-4 col-sm-offset-3')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'system\crmBundle\Entity\Provedores'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provedores';
    }
}

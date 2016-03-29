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
			->add('nombre', 'text',array('required'=>true, 'label'=>'Nombre', 'attr' =>	array('placeholder' => 'Nombre del Provedor')))
			->add('contacto','text', array('required'=>true, 'label'=>'Contacto(vendedor)', 'attr' => array('placeholder' => 'Nombre del Contacto del Provedor')))
			->add('direccion','text', array('required'=>false, 'label'=>'Direccion', 'attr' =>array('placeholder' => 'Ubicacion del Provedor')))
			->add('estado', 'text', array('required'=>true, 'label'=>'Estado', 'attr' =>array('placeholder' => 'Estado')))
			->add('municipio', 'text', array('required'=>true, 'label'=>utf8_decode('Municipio'), 'attr' => array('placeholder' => 'Municipio')))
			->add('telefono', 'text', array('required'=>true, 'label'=>'Telefono', 'attr' => array('placeholder' => 'Telefono para contactar al Provedor')))
			->add('telefono2', 'text', array('required'=>false, 'label'=>'Telefono2', 'attr' => array('placeholder' => 'Otro telefono (Oficina, Celular) ')))
			->add('otro', 'text', array('required'=>false, 'label'=>'Otro', 'attr' => array('placeholder' => '(Celuar, Fax, ect)')))
			->add('ramo', 'hidden', array('required'=>false, 'label'=>'Ramo'))
			->add('formaPago', 'text', array('required'=>false, 'label'=>'Forma Pago', 'attr' => array('placeholder' => 'Forma de pago')))
			->add('email', 'text', array('required'=>true, 'label'=>'Email', 'attr' => array('placeholder' => 'Email: ejemplo@')))
			->add('web', 'text', array('required'=>false, 'label'=>'Sitio Web', 'attr' => array('placeholder' => 'Sitio Web: www.ejemplo.com')))
			->add('observaciones', 'textarea', array('attr' => array('cols' => '5', 'rows' => '5'),'required'=>false , 'attr' => array('placeholder' => 'Notas de este provedor')))
			
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

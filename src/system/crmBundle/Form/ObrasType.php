<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientesType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre', 'text',array('required'=>true, 'label'=>'Nombre'))
			->add('apellidoP','text', array('required'=>false, 'label'=>'Apellido Paterno'))
			->add('apellidoM','text', array('required'=>false, 'label'=>'Apellido Materno'))
			->add('calle', 'text', array('required'=>true, 'label'=>utf8_decode('Calle')))
			->add('colonia', 'text', array('required'=>true, 'label'=>utf8_decode('Colonia')))
			->add('municipio', 'text', array('required'=>true, 'label'=>utf8_decode('Municipio')))
			->add('estado', 'text', array('required'=>true, 'label'=>utf8_decode('Estado')))
			->add('telefono', 'text', array('required'=>true, 'label'=>'Telefono'))
			->add('celular', 'text', array('required'=>false, 'label'=>'Celular'))
			->add('email', 'text', array('required'=>true, 'label'=>'Email'))
			->add('rFC', 'text', array('required'=>false, 'label'=>'RFC')),
			->add('cP', 'text', array('required'=>false, 'label'=>'CP'))
			->add('formaPago', 'text', array('required'=>false, 'label'=>'Forma de Pago'))
			->add('notas', 'textarea', array('attr' => array('cols' => '5', 'rows' => '5')))
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
            'data_class' => 'system\crmBundle\Entity\Clientes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clientes';
    }
}

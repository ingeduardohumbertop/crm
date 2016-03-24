<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaquinariaType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('eco', 'text',array('required'=>true, 'label'=>'ECO'))
			->add('numeroSerie','text', array('required'=>true, 'label'=>'No Serie'))
			->add('nombre','text', array('required'=>false, 'label'=>'Nombre'))
			->add('years', 'text', array('required'=>true, 'label'=>utf8_decode('Años')))
			->add('modelo', 'text', array('required'=>true, 'label'=>utf8_decode('Modelo')))
			->add('marca', 'text', array('required'=>false, 'label'=>'Marca'))
			->add('almacen', 'text', array('required'=>false, 'label'=>'Almacen'))
			->add('idObra', 'text', array('required'=>false, 'label'=>'Obra'))
			->add('isActive', 'checkbox',  array('property_path' => 'isActive','required' => false,'label' => utf8_encode('Activo')))
			->add('status', 'choice', array( 'choices'  => array('operando' => utf8_decode('Operando'),
					'reparacion' => utf8_decode('Reparacion'),
					'inactiva' => utf8_decode('Inactiva'),
			), 'required' => true))
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
            'data_class' => 'system\crmBundle\Entity\Maquinaria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'maquinaria';
    }
}

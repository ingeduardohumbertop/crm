<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObrasType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('idCliente', 'integer',array('required'=>true, 'label'=>'Cliente'))
			->add('nombre', 'text',array('required'=>true, 'label'=>'Nombre'))
			->add('fechaInicioReal', 'date', array('required' => false,'widget' => 'single_text'))
			->add('fechafinalReal', 'date', array('required' => false,'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'label'=>'Fecha Final'))
			->add('fechaInicioPlan', 'date', array('required' => true,'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'label'=>'Fecha Inicio'))
			->add('fechaFinalPlan', 'date', array('required' => true,'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'label'=>'Fecha Final'))
			->add('costePlanificado','text', array('required'=>true, 'label'=>'Coste Planificado'))
			->add('costeReal', 'text', array('read_only'=>true,'required'=>false, 'label'=>utf8_decode('Coste Real')))
			->add('estado', 'text', array('required'=>true, 'label'=>utf8_decode('Estado')))
			->add('municipio', 'text', array('required'=>true, 'label'=>utf8_decode('Municipio')))
			->add('colonia', 'text', array('required'=>true, 'label'=>'Colonia'))
			->add('calle', 'text', array('required'=>false, 'label'=>'Calle'))
			->add('estadoObra', 'text', array('required'=>true, 'label'=>'Estado de Obra'))
			->add('fechaCreacion', 'datetime', array('read_only'=>true, 'required' => false,'widget' => 'single_text','format' => 'yyyy-MM-dd  HH:mm','label'=>'Alta'))
			->add('fechaModificacion', 'datetime', array('read_only'=>true, 'required' => false,'widget' => 'single_text','format' => 'yyyy-MM-dd  HH:mm','label'=>'Modificacion'))
			->add('notas', 'textarea', array('required'=>false,'attr' => array('cols' => '5', 'rows' => '5')))
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
            'data_class' => 'system\crmBundle\Entity\Obras'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obras';
    }
}

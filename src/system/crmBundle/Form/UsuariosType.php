<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuariosType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre', 'text',array('required'=>true, 'label'=>'Nombre'))
			->add('aPaterno','text', array('required'=>true, 'label'=>'Apellido Paterno'))
			->add('aMaterno','text', array('required'=>true, 'label'=>'Apellido Materno'))
			->add('username', 'text', array('required'=>true, 'label'=>'Usuario(RFC)'))
			->add('password', 'text', array('required'=>true, 'label'=>utf8_decode('Password')))
			->add('email', 'text', array('required'=>true, 'label'=>'Email'))
			->add('fechaNacimiento', 'date', array('required' => false,'widget' => 'single_text', 'format' => 'yyyy-MM-dd',))
			->add('isActive', 'checkbox',  array('property_path' => 'isActive','required' => false,'label' => utf8_encode('Activo')))
			->add('puesto', 'choice', array( 'choices'  => array('administrativo' => utf8_decode('Administrativo'),
					'gestor' => utf8_decode('Gestor'),
					'asistente' => utf8_decode('Asistente'),
					'gerente' => utf8_decode('Gerente'),
					'director' => utf8_decode('Director'),
					'contador' => utf8_decode('Contador'),
					), 'required' => true))
			->add('rol', 'choice', array( 'choices'  => array('ROLE_USER' => utf8_decode('Usuario'),
					'ROLE_ADMIN' => 'Administrador',
			), 'required' => true))
			->add('telefono', 'text', array('required'=>true, 'label'=>'Telefono'))
			->add('celular', 'text', array('required'=>true, 'label'=>'Celular'))
			->add('genero', 'choice', array( 'choices'  => array('masculino' => utf8_decode('Masculino'),
					'femenino' => 'Femenino',
			), 'required' => true))
			->add('estadoCivil', 'choice', array( 'choices'  => array('soltero' => utf8_decode('Soltero'),
					'casado' => 'Casado',
			), 'required' => true))
			->add('pais', 'text', array('required'=>true, 'label'=>'Pais'))
			->add('cP', 'text', array('required'=>true, 'label'=>'CP'))
			->add('estado', 'text', array('required'=>true, 'label'=>'Estado'))
			->add('municipio', 'text', array('required'=>true, 'label'=>'Municipio'))
			->add('colonia', 'text', array('required'=>true, 'label'=>'Colonia'))
			->add('calle', 'text', array('required'=>true, 'label'=>'Calle'))
			->add('calle', 'text', array('required'=>true, 'label'=>'Calle'))
			->add('notas', 'textarea', array('attr' => array('cols' => '5', 'rows' => '5'), 'required'=>false))
			
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
            'data_class' => 'system\crmBundle\Entity\Usuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usuarios';
    }
}

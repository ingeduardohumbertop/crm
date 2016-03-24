<?php

namespace system\crmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PermisosType extends AbstractType
{
	/**
	* @param FormBuilderInterface $builder
	* @param array $options
	*/
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('usuariosModulo','checkbox',array('required'=>false ,'label'=>'Modulo Usuarios'))
		->add('usuariosAgregar','checkbox',array('required'=>false ,'label'=>'Agregar Usuarios'))
		->add('usuariosEditar','checkbox',array('required'=>false,'label'=>'Editar Usuarios'))
		->add('usuariosEliminar','checkbox',array('required'=>false,'label'=>'EliminarUsuarios'))
		->add('moduloOpciones','checkbox',array('required'=>false,'label'=>'Menu de Opciones'))
		->add('permisosAgregar','checkbox',array('required'=>false,'label'=>'Agregar Permisos'))
		->add('provedoresModulo','checkbox',array('required'=>false,'label'=>'Modulo Provedores'))
		->add('provedoresAgregar','checkbox',array('required'=>false,'label'=>'Agregar Provedores'))
		->add('provedoresEditar','checkbox',array('required'=>false,'label'=>'Editar Provedores'))
		->add('provedoresEliminar','checkbox',array('required'=>false,'label'=>'Eliinar Provedores'))
		->add('moduloInventario','checkbox',array('required'=>false,'label'=>'Menu Inventario'))
		->add('maquinariaModulo','checkbox',array('required'=>false,'label'=>'Modulo Maquinaria'))
		->add('maquinariaAgregar','checkbox',array('required'=>false,'label'=>'Agregar Maquinaria'))
		->add('maquinariaEditar','checkbox',array('required'=>false,'label'=>'EditarMaquinaria'))
		->add('maquinariaEliminar','checkbox',array('required'=>false,'label'=>'Eliminar Maqunaria'))
		->add('moduloClientes','checkbox',array('required'=>false,'label'=>'Modulo Clientes'))
		->add('clientesAgregar','checkbox',array('required'=>false,'label'=>'Agregar Clientes'))
		->add('clientesEditar','checkbox',array('required'=>false,'label'=>'Editar Clientes'))
		->add('clientesEliminar','checkbox',array('required'=>false,'label'=>'Eliminar Clientes'))
		->add('obrasModulo','checkbox',array('required'=>false,'label'=>'Menu Obras'))
		->add('obrasAgregar','checkbox',array('required'=>false,'label'=>'Agregar Obras'))
		->add('obrasEditar','checkbox',array('required'=>false,'label'=>'Editar Obras'))
		->add('obrasEliminar','checkbox',array('required'=>false,'label'=>'Eliminar Obras'))
			
			//   ->add('status','choice', array(array('choices' => array('1' => 'Activo', '0' => 'Inactivo'),
				//'required'=>true)))
		//->add('save', 'submit', array('label' => 'Guardar' , 'attr'=>array('class'=>'btn btn-primary col-sm-4 col-sm-offset-3')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'system\crmBundle\Entity\Permisos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'permisos';
    }
}

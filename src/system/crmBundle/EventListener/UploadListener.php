<?php
namespace system\crmBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\File\File;


class UploadListener
{
	private $webroot;
	private $doctrine;
	public function __construct($doctrine,$webroot)
	{
		$this->doctrine = $doctrine;
		$this->webroot= $webroot;
		
	}
	
	public function onUpload(PostPersistEvent $event)
	{
		$request = $event->getRequest();
		$tipo=$request->get('tipo',null);
		$idUsuario = $request->get('idUsuario');
		if($tipo == null or !($tipo=='fotoUsuario')){
			return "no viene tipo";
		}
		$original_filename = $request->files->get('blueimp')->getClientOriginalName();
		switch ($tipo){
			case 'fotoUsuario':
				
				$dir=$this->webroot."/../web/uploads/usuarios/$idUsuario";
				
				try {
					$fs = new Filesystem();
					$fs->mkdir($dir);
				
					if ($file = $event->getFile()) {
						//guardar foto en bd
						$em = $this->doctrine->getManager();
						$usuarios = $em->getRepository('crmBundle:Usuarios')->find($idUsuario);
				
						$path = $this->webroot . '/../web';
						if($usuarios->getFotoPath()!='')
							if( file_exists ( $path.$usuarios->getFotoPath() )){
								unlink($path.$usuarios->getFotoPath());
						}
							
						$usuarios->setFotoPath("/uploads/usuarios/$idUsuario/".$file->getKey());
						$em->flush();							
							
						$response = $event->getResponse();
						$files[0] = array(
								'name' => $original_filename,
								'size' => $file->getSize(),
								'url'  => "/uploads/usuarios/$idUsuario/".$file->getKey(),
								'thumbnailUrl' => "/uploads/usuarios/$idUsuario/".$file->getKey(),
								'deleteUrl'   =>"/usuarios/eliminarFoto/".$idUsuario,
								'deleteType' => 'DELETE',
								'orden' => '1',
								'tipo' => 'foto',
								'idFotos'=> '1'
						);
						$fs->rename($this->webroot."/../web/uploads/gallery/".$file->getKey(), $dir.'/'.$file->getKey());
						$response['files'] = $files;
				
					}
				
				} catch (IOExceptionInterface $e) {
					echo "An error occurred while creating your directory at ".$e->getPath();
				}
				break;
			
			default:
				echo 'tipo no corresponde';
		}
		
	}
}
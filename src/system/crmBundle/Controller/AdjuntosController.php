<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdjuntosController extends Controller
{
	public function adjuntoslistenerAction($idObra){
		
		$em = $this->getDoctrine()->getManager();
		
			$repository = $this->getDoctrine()->getRepository('crmBundle:AdjuntosObras');
			$adjuntos = $repository->findBy(
					array('idObra' => $idObra),
					array('orden' => 'ASC'));
	
		
		$files=array();
		foreach ($adjuntos as $adjunto){
			$files[] = array(
					'name' => $adjunto->getNombre(),
					'size' => '0',
					'url'  => $adjunto->getPath(),
					'thumbnailUrl' => $adjunto->getPath(),
					'deleteUrl'   =>"/obras/adjuntos/adjuntoObra/eliminar/".$adjunto->getId(),
					'deleteType' => 'DELETE',
					'orden' => $adjunto->getOrden(),
					'idFotos'=> $adjunto->getId(),
					//'key'=>end( explode('.', strtolower( $adjunto->getPath())))
		
			);
				
		}
		$response = new JsonResponse();
		
		$response->setData(array(
				'files' => $files
		));
		return $response;
	}
	
	public function eliminarAction($id){
		$em = $this->getDoctrine()->getManager();
		$adjuntos = $em->getRepository('crmBundle:AdjuntosObras')->find($id);
		
		if (!$adjuntos) {
			$response = new JsonResponse();
			$response->setData(array(
					'status' => 'error',
					'message' => 'No se encontro Archivo',
			));
			return $response;
		}
		$path = $this->get('kernel')->getRootDir() . '/../web';
			
		if($adjuntos->getPath()!='')
			if( file_exists ( $path.$adjuntos->getPath() )){
				unlink($path.$adjuntos->getPath());
		}
			
		$em->remove($adjuntos);
		$em->flush();
		//set si tiene o no fotos
		$query = $em->createQuery(
		 'SELECT count(adjO) as numAdjuntos
		 FROM crmBundle:AdjuntosObras adjO
		 WHERE adjO.idObra = :idObra'
			)->setParameter('idObra', $adjuntos->getIdObra());
			$numAdjuntos= $query->setMaxResults(1)->getOneOrNullResult();
	
			$obras = $em->getRepository('crmBundle:Obras')->find($adjuntos->getIdObra());
			if($numAdjuntos['numAdjuntos']>0){
			$obras->setTieneArchivos(true);
			}else{
			$obras->setTieneArchivos(false);
			}
			$em->flush();
	
		$response = new JsonResponse();
		$response->setData(array(
				'status' => 'success',
				'message' => 'Borrado',
		));
		return $response;
	}
	public function reorderAction(Request $request){
	
		$content = $request->getContent();
		if (!empty($content))
		{
			$params = json_decode($content, true); // 2nd param to get as array
		}
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
	
			foreach ($params as $adjuntos){
				$idArchivo= $adjuntos['idArchivo'];
				$orden= $adjuntos['orden'];
				$query = $em->createQuery(
						'UPDATE
					    crmBundle:AdjuntosObras adjO
					    SET  adjO.orden=  :orden
					WHERE adjO.id = :idArchivo'
						)->setParameters(array('idArchivo'=> $idArchivo,'orden'=>$orden) );
						$query->execute();
						$em->flush();	
			}
		
		$response = new JsonResponse();
		$response->setData(array(
				'success' => 1
		));
		return $response;
	}
	
    public function eliminarFotoAction($id){

    	$em = $this->getDoctrine()->getManager();
    	
    	$usuarios = $em->getRepository('crmBundle:Usuarios')->find($id);
    	
    	$path = $this->get('kernel')->getRootDir() . '/../web';
    	
    	if($usuarios->getFotoPath()!='')
    		if( file_exists ( $path.$usuarios->getFotoPath() )){
    			unlink($path.$usuarios->getFotoPath());
    	}
    	
    	$usuarios->setFotoPath('');
    	$em->flush();
    	
    	$response = new JsonResponse();
    	$response->setData(array(
    			'status' => 'success',
    			'message' => 'Borrado',
    	));
    	return $response;
    	}
}

<?php 
//C:\Users\EduardoHumberto\Desktop\SCAOcrm
//php app/console doctrine:generate:entities system/crmBundle/Entity
namespace system\crmBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="adjuntosObras")
 */
class AdjuntosObras
{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $idObra;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $nombre;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $path;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $idUsuario;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaCreacion;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $orden;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idObra
     *
     * @param string $idObra
     * @return AdjuntosObras
     */
    public function setIdObra($idObra)
    {
        $this->idObra = $idObra;

        return $this;
    }

    /**
     * Get idObra
     *
     * @return string 
     */
    public function getIdObra()
    {
        return $this->idObra;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return AdjuntosObras
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return AdjuntosObras
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set idUsuario
     *
     * @param string $idUsuario
     * @return AdjuntosObras
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return string 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return AdjuntosObras
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set orden
     *
     * @param string $orden
     * @return AdjuntosObras
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return string 
     */
    public function getOrden()
    {
        return $this->orden;
    }
}

<?php 
//C:\Users\EduardoHumberto\Desktop\SCAOcrm
//php app/console doctrine:generate:entities system/crmBundle/Entity
namespace system\crmBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="obras")
 */
class Obras
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
	protected $nombre;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fechaInicioReal;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fechafinalReal;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fechaInicioPlan;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fechaFinalPlan;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $costePlanificado;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $costeReal;
	/**
	* @ORM\Column(type="string", length=100)
	 */
	protected $idCliente;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $estado;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $municipio;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $colonia	;
	/**
	* @ORM\Column(type="string", length=100)
	 */
	protected $calle;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $estadoObra;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $notas;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaCreacion;
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $idUsuarioCreador;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaModificacion;



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
     * Set nombre
     *
     * @param string $nombre
     * @return Obras
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
     * Set fechaInicioReal
     *
     * @param \DateTime $fechaInicioReal
     * @return Obras
     */
    public function setFechaInicioReal($fechaInicioReal)
    {
        $this->fechaInicioReal = $fechaInicioReal;

        return $this;
    }

    /**
     * Get fechaInicioReal
     *
     * @return \DateTime 
     */
    public function getFechaInicioReal()
    {
        return $this->fechaInicioReal;
    }

    /**
     * Set fechafinalReal
     *
     * @param \DateTime $fechafinalReal
     * @return Obras
     */
    public function setFechafinalReal($fechafinalReal)
    {
        $this->fechafinalReal = $fechafinalReal;

        return $this;
    }

    /**
     * Get fechafinalReal
     *
     * @return \DateTime 
     */
    public function getFechafinalReal()
    {
        return $this->fechafinalReal;
    }

    /**
     * Set fechaInicioPlan
     *
     * @param \DateTime $fechaInicioPlan
     * @return Obras
     */
    public function setFechaInicioPlan($fechaInicioPlan)
    {
        $this->fechaInicioPlan = $fechaInicioPlan;

        return $this;
    }

    /**
     * Get fechaInicioPlan
     *
     * @return \DateTime 
     */
    public function getFechaInicioPlan()
    {
        return $this->fechaInicioPlan;
    }

    /**
     * Set fechaFinalPlan
     *
     * @param \DateTime $fechaFinalPlan
     * @return Obras
     */
    public function setFechaFinalPlan($fechaFinalPlan)
    {
        $this->fechaFinalPlan = $fechaFinalPlan;

        return $this;
    }

    /**
     * Get fechaFinalPlan
     *
     * @return \DateTime 
     */
    public function getFechaFinalPlan()
    {
        return $this->fechaFinalPlan;
    }

    /**
     * Set costePlanificado
     *
     * @param string $costePlanificado
     * @return Obras
     */
    public function setCostePlanificado($costePlanificado)
    {
        $this->costePlanificado = $costePlanificado;

        return $this;
    }

    /**
     * Get costePlanificado
     *
     * @return string 
     */
    public function getCostePlanificado()
    {
        return $this->costePlanificado;
    }

    /**
     * Set costeReal
     *
     * @param string $costeReal
     * @return Obras
     */
    public function setCosteReal($costeReal)
    {
        $this->costeReal = $costeReal;

        return $this;
    }

    /**
     * Get costeReal
     *
     * @return string 
     */
    public function getCosteReal()
    {
        return $this->costeReal;
    }

    /**
     * Set idCliente
     *
     * @param string $idCliente
     * @return Obras
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * Get idCliente
     *
     * @return string 
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Obras
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     * @return Obras
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     * @return Obras
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string 
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Obras
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set estadoObra
     *
     * @param string $estadoObra
     * @return Obras
     */
    public function setEstadoObra($estadoObra)
    {
        $this->estadoObra = $estadoObra;

        return $this;
    }

    /**
     * Get estadoObra
     *
     * @return string 
     */
    public function getEstadoObra()
    {
        return $this->estadoObra;
    }

    /**
     * Set notas
     *
     * @param string $notas
     * @return Obras
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string 
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Obras
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
     * Set idUsuarioCreador
     *
     * @param integer $idUsuarioCreador
     * @return Obras
     */
    public function setIdUsuarioCreador($idUsuarioCreador)
    {
        $this->idUsuarioCreador = $idUsuarioCreador;

        return $this;
    }

    /**
     * Get idUsuarioCreador
     *
     * @return integer 
     */
    public function getIdUsuarioCreador()
    {
        return $this->idUsuarioCreador;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Obras
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }
}

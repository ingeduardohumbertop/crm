<?php 
namespace system\crmBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 * @UniqueEntity("username")
 */
class Usuarios implements AdvancedUserInterface, \Serializable
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
	 * @ORM\Column(type="string", length=100)
	 */
	protected $aPaterno;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $aMaterno;
	/**
	 * @ORM\Column(type="string", length=50, unique=true)
	 * @Assert\NotBlank()
	 */
	protected $username;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 */
	protected $password;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $email;
	/**
	 * @ORM\Column(type="date")
	 */
	protected $fechaNacimiento;
	/**
	 * @ORM\Column(name="isActive", type="boolean")
	 */
	protected $isActive;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $puesto;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaAlta;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $rol;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $ultimaActividadSistema;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $telefono;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $celular;
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $genero;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $estadoCivil;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $pais;
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $cP;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $estado;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $municipio;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $colonia;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $calle;
	/**
	 * @ORM\Column(type="text")
	 */
	protected $notas;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $fotoPath;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaBaja;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $fechaModificacion;
	
	public function __construct()
	{
		$this->isActive = true;
		//$this->propiedades = new ArrayCollection();
		// may not be needed, see section on salt below
		// $this->salt = md5(uniqid(null, true));
	}
	public function getSalt()
	{
		// you *may* need a real salt depending on your encoder
		// see section on salt below
		return null;
	}
	public function getRoles()
	{
		return array($this->rol);
		//return array('ROLE_USER');
	}
	public function eraseCredentials()
	{
	}
	
/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
				$this->id,
				$this->username,
				$this->password,
				$this->isActive,
				// see section on salt below
				// $this->salt,
		));
	}
	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
				$this->id,
				$this->username,
				$this->password,
				$this->isActive,
				// see section on salt below
				// $this->salt
		) = unserialize($serialized);
	}
	public function isAccountNonExpired()
	{
		return true;
	}
	
	public function isAccountNonLocked()
	{
		return true;
	}
	
	public function isCredentialsNonExpired()
	{
		return true;
	}
	
	public function isEnabled()
	{
		return $this->isActive;
	}
	// serialize and unserialize must be updated - see below


    /**
     * Set username
     *
     * @param string $username
     * @return Usuarios
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
    	return $this->username;
    }
    

    /**
     * Set password
     *
     * @param string $password
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
    	return $this->password;
    }


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
     * @return Usuarios
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
     * Set aPaterno
     *
     * @param string $aPaterno
     * @return Usuarios
     */
    public function setAPaterno($aPaterno)
    {
        $this->aPaterno = $aPaterno;

        return $this;
    }

    /**
     * Get aPaterno
     *
     * @return string 
     */
    public function getAPaterno()
    {
        return $this->aPaterno;
    }

    /**
     * Set aMaterno
     *
     * @param string $aMaterno
     * @return Usuarios
     */
    public function setAMaterno($aMaterno)
    {
        $this->aMaterno = $aMaterno;

        return $this;
    }

    /**
     * Get aMaterno
     *
     * @return string 
     */
    public function getAMaterno()
    {
        return $this->aMaterno;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuarios
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set puesto
     *
     * @param string $puesto
     * @return Usuarios
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return string 
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Usuarios
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return Usuarios
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set ultimaActividadSistema
     *
     * @param \DateTime $ultimaActividadSistema
     * @return Usuarios
     */
    public function setUltimaActividadSistema($ultimaActividadSistema)
    {
        $this->ultimaActividadSistema = $ultimaActividadSistema;

        return $this;
    }

    /**
     * Get ultimaActividadSistema
     *
     * @return \DateTime 
     */
    public function getUltimaActividadSistema()
    {
        return $this->ultimaActividadSistema;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Usuarios
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Usuarios
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set genero
     *
     * @param string $genero
     * @return Usuarios
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set estadoCivil
     *
     * @param string $estadoCivil
     * @return Usuarios
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return string 
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Usuarios
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set cP
     *
     * @param string $cP
     * @return Usuarios
     */
    public function setCP($cP)
    {
        $this->cP = $cP;

        return $this;
    }

    /**
     * Get cP
     *
     * @return string 
     */
    public function getCP()
    {
        return $this->cP;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Usuarios
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
     * @return Usuarios
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
     * @return Usuarios
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
     * @return Usuarios
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
     * Set notas
     *
     * @param string $notas
     * @return Usuarios
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
     * Set fotoPath
     *
     * @param string $fotoPath
     * @return Usuarios
     */
    public function setFotoPath($fotoPath)
    {
        $this->fotoPath = $fotoPath;

        return $this;
    }

    /**
     * Get fotoPath
     *
     * @return string 
     */
    public function getFotoPath()
    {
        return $this->fotoPath;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return Usuarios
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Usuarios
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

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Usuarios
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
}

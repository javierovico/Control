<?php


namespace App;


class Empleado{

    public $nombre = null;
    public $apellido = null;
    public $legajo = null;
    public $tieneTolerancia = false;
    public $minutosTolerancia = 0;

    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param null $apellido
     */
    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    /**
     * @return null
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     * @param null $legajo
     */
    public function setLegajo($legajo): void
    {
        $this->legajo = $legajo;
    }

    /**
     * @return bool
     */
    public function isTieneTolerancia(): bool
    {
        return $this->tieneTolerancia;
    }

    /**
     * @param bool $tieneTolerancia
     */
    public function setTieneTolerancia(bool $tieneTolerancia): void
    {
        $this->tieneTolerancia = $tieneTolerancia;
    }

    /**
     * @return int
     */
    public function getMinutosTolerancia(): int
    {
        return $this->minutosTolerancia;
    }

    /**
     * @param int $minutosTolerancia
     */
    public function setMinutosTolerancia(int $minutosTolerancia): void
    {
        $this->minutosTolerancia = $minutosTolerancia;
    }

    /**
     * Empleado constructor.
     * @param null $nombre
     * @param null $apellido
     * @param null $legajo
     */
    public function __construct($nombre, $apellido, $legajo, $tieneTolerancia , $minutosTolerancia)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->legajo = $legajo;
        $this->tieneTolerancia = $tieneTolerancia;
        $this->minutosTolerancia = $minutosTolerancia;
    }


}

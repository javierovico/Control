<?php


namespace App;


interface GuardadoEnBase{
    /**
     * @return bool : retorna true si se cargo, false si ya estaba cargado
     */
    public function guardarseSiNoExiste() : bool;

}

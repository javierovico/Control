<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

interface GuardadoEnBase{
    /**
     * Cada tipo de dato debe gestionar su propia forma de guardarse en la base de datos, para que sea polimorfica, se usa esta interface
     * @return bool : retorna true si se cargo, false si ya estaba cargado
     */
    public function guardarseSiNoExiste() : bool;

    /**
     * para que cada Clase retorne una instancia a su modelo
     * @return Model
     */
    public function retornarInstanciaBD();

}

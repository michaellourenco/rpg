<?php

class Inventario
{
	protected $_idInventario;
    protected $_fkItem;
    protected $_fkPersonagem;
    protected $_equipado;
	protected $_dataInclusao;

    public function getIdInventario() {
        return $this->_idInventario;
    }

    public function setIdInventario($idInventario) {
        $this->_idInventario = $idInventario;
        return $this;
    }
	
    public function getFkItem() {
        return $this->_fkItem;
    }

    public function setFkItem($fkItem) {
        $this->_fkItem = $fkItem;
        return $this;
    }

    public function getFkPersonagem() {
        return $this->_fkPersonagem;
    }

    public function setFkPersonagem($fkPersonagem) {
        $this->_fkPersonagem = $fkPersonagem;
        return $this;
    }

    public function getEquipado() {
        return $this->_equipado;
    }

    public function setEquipado($equipado) {
        $this->_equipado = $equipado;
        return $this;
    }

    public function getDataInclusao() {
        return $this->_dataInclusao;
    }

    public function setDataInclusao($dataInclusao) {
        $this->_dataInclusao = $dataInclusao;
        return $this;
    }

	public function getPersonagem(){
			$usuario= new Personagem();
			$mapperAg= new PersonagemMapper();
			$mapperAg->find("$this->_fkPersonagem",$usuario);
            return $usuario;
    }
	
	public function getItem(){
			$item= new Item();
			$mapperArt= new ItemMapper();
			$mapperArt->find("$this->_fkItem",$item);
            return $item;
    }

}


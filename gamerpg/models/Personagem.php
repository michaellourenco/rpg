<?php

class Personagem
{

    protected $_idPersonagem;
    protected $_titulo;
    protected $_fr;
    protected $_dx;
    protected $_con;
    protected $_inteligencia;
    protected $_sab;
    protected $_hp;
    protected $_energia;
    protected $_mana;
    protected $_fa;
    protected $_fd;
    protected $_dinheiro;



    public function getIdPersonagem() {
        return $this->_idPersonagem;
    }

    public function setIdPersonagem($idPersonagem) {
        $this->_idPersonagem = $idPersonagem;
        return $this;
    }
    public function getTitulo() {
        return html_entity_decode($this->_titulo);
    }

    public function setTitulo($titulo) {
        $this->_titulo =  htmlentities($titulo);
        return $this;
    }
    public function getFr() {
        return $this->_fr;
    }

    public function setFr($fr) {
        $this->_fr = $fr;
        return $this;
    }

    public function getDx() {
        return $this->_dx;
    }

    public function setDx($dx) {
        $this->_dx = $dx;
        return $this;
    }

    public function getCon() {
        return $this->_con;
    }

    public function setCon($con) {
        $this->_con = $con;
        return $this;
    }

    public function getInteligencia() {
        return html_entity_decode($this->_inteligencia);
    }

    public function setInteligencia($inteligencia) {
        $this->_inteligencia = htmlentities($inteligencia);
        return $this;
    }

    public function getSab() {
        return $this->_sab;
    }

    public function setSab($sab) {
        $this->_sab = $sab;
        return $this;
    }

    public function getFkCategoria() {
        return $this->_fkCategoria;
    }

    public function setFkCategoria($fkCategoria) {
        $this->_fkCategoria = $fkCategoria;
        return $this;
    }

    public function getHp() {
        return $this->_hp;
    }

    public function setHp($hp) {
        $this->_hp = $hp;
        return $this;
    }


    public function getEnergia() {
        return $this->_energia;
    }
    public function setEnergia($energia) {
        $this->_energia = $energia;
        return $this;
    }


    public function getMana() {
        return $this->_mana;
    }
    public function setMana($mana) {
        $this->_mana = $mana;
        return $this;
    }

    public function getDinheiro() {
        return $this->_dinheiro;
    }

    public function setDinheiro($dinheiro) {
        $this->_dinheiro = $dinheiro;
        return $this;
    }

	public function fa(){
		$dado = new D();
		$dado->setLado(10);
		$num = $dado->getDado();
		return $this->_fr*$num;
    }

    public function setFa($fa) {
        $this->_fa = $fa;
        return $this;
    }

	public function fd(){
		$dado = new D();
		$dado->setLado(10);
		$num = $dado->getDado();
		return $this->_dx*$num;
    }

    public function setFd($fd) {
        $this->_fd = $fd;
        return $this;
    }

	public function atacar(){
		$dado= new D();
		$dado->setLado(10);
		$num = $dado->getDado();
		return $this->_fr*$num;
    }			
	public function defender(){
		$dado = new D();
		$dado->setLado(10);
		$num = $dado->getDado();
		return $this->_con*$num;
    }				

	public function iniciativa(){
		$dado = new D();
		$dado->setLado(20);
		$num = $dado->getDado();
		return $this->_dx*$num;
    }	
}


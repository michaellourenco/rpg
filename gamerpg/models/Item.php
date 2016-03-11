<?php

class Item
{

    protected $_idItem;
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
    protected $_preco;



    public function getIdItem() {
        return $this->_idItem;
    }

    public function setIdItem($idItem) {
        $this->_idItem = $idItem;
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


    public function getFa() {
        return $this->_fa;
    }
    public function setFa($fa) {
        $this->_fa = $fa;
        return $this;
    }



    public function getFd() {
        return $this->_fd;
    }
	
    public function setFd($fd) {
        $this->_fd = $fd;
        return $this;
    }

    public function getPreco() {
        return $this->_preco;
    }

    public function setPreco($preco) {
        $this->_preco = $preco;
        return $this;
    }
	


	public function getListaGeneroMusical(){
		$table = new RelItemGeneroMusicalMapper();
		$itens= $table->generosMusicais($this->_idItem,10);
		return $itens;	

    }

	public function getListaEventos(){
        $itemMapper = new EventoMapper();
		$selectItens = $itemMapper->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);			
		$selectItens->where("fkLocal=$this->_idItem");
		$selectItens->order('dataEvento desc');		
		$selectItens->limit('350','0');
		$itens = $itemMapper->fetchAll($selectItens);
        return $itens;
    }

	public function getListaArtistas(){		
		
    }
	public function getCidade(){
			$cidade= new Cidade();
			$mapperCidade= new CidadeMapper();
			$mapperCidade->find("$this->_fkCidade",$cidade);
            return $cidade;
    }	

	public function getListaUsuarios(){
        $relUsuarioItemMap = new RelUsuarioItemMapper();
        $usuarios = $relUsuarioItemMap->fetchControlado("fkItem='$this->_idItem'", null);
        return $usuarios;

    }
	public function getImagensLogo(){
       		// IMAGEM LOGO INICIO
			// OBS A fkPosição = 9  refere-se a posição de layout 9 = foto destaque item
		$table = new RelCPMMapper();
		$imagens= $table->imagens($this->_idItem,9,1);
		return $imagens;			
      		// IMAGEM LOGO FIM	

	}

	public function getImagemTitulo(){
       		// FOTOS TITULO ESTABELECIMENTO INICIO
			// OBS A fkPosição = 3  refere-se a posição de layout 3 = foto titulo item
		$table = new RelCPMMapper();
		$imagens= $table->imagens($this->_idItem,3,1);
		return $imagens;			
      		// FOTOS ESTABELECIMENTO FIM

	}	
	
	public function getImagens(){
       		// FOTOS ESTABELECIMENTO INICIO
			// OBS A fkPosição = 6  refere-se a posição de layout 21 = foto item
		$table = new RelCPMMapper();
		$imagens= $table->imagens($this->_idItem,6,30);
		return $imagens;				
      		// FOTOS ESTABELECIMENTO FIM

	}	
	

}


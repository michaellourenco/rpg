<?php

class Usuario {

    protected $_idUsuario;
    protected $_login;
    protected $_senha;
    protected $_fkGrupoUsuario=1;
    protected $_dataNascimento;
    protected $_nome;
    protected $_fr;
    protected $_con;
    protected $_dx;
    protected $_cidade;
    protected $_descricao;
    protected $_roleId;
	protected $_genero;
	protected $_statusRelacionamento;
	protected $_frase;
	protected $_con2;
	protected $_con3;
	protected $_twitter;
	protected $_facebook;
	protected $_orkut;
	protected $_flickr;
	protected $_msn;


    public function getIdUsuario() {
        return $this->_idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->_idUsuario = $idUsuario;
        return $this;
    }

    public function getFkGrupoUsuario() {
        return $this->_fkGrupoUsuario;
    }

    public function setFkGrupoUsuario($fkGrupoUsuario) {
        $this->_fkGrupoUsuario = $fkGrupoUsuario;
        return $this;
    }

    public function getDataNascimento() {
        return $this->_dataNascimento;
    }

    public function setDataNascimento($dataNascimento) {
        $this->_dataNascimento = $dataNascimento;
        return $this;
    }

    public function getNome() {
        return html_entity_decode($this->_nome);
    }

    public function setNome($nome) {
        $this->_nome = htmlentities($nome);
        return $this;
    }

    public function getFr() {
        return $this->_fr;
    }

    public function setFr($fr) {
        $this->_fr = $fr;
        return $this;
    }

    public function getCon() {
        return $this->_con;
    }

    public function setCon($con) {
        $this->_con = $con;
        return $this;
    }

    public function getDx() {
        return $this->_dx;
    }

    public function setDx($dx) {
        $this->_dx = $dx;
        return $this;
    }

    public function getCidade() {
        return html_entity_decode($this->_cidade);
    }

    public function setCidade($cidade) {
        $this->_cidade = htmlentities($cidade);
        return $this;
    }

    public function getDescricao() {
        return $this->_descricao;
    }

    public function setDescricao($descricao) {
        $this->_descricao = $descricao;
        return $this;
    }

    public function getGenero() {
        return $this->_genero;
    }

    public function setGenero($genero) {
        $this->_genero = $genero;
        return $this;
    }

    public function getStatusRelacionamento($statusRelacionamento) {
        return $this->_statusRelacionamento;
    }

    public function setStatusRelacionamento($statusRelacionamento) {
        $this->_statusRelacionamento = $statusRelacionamento;
        return $this;
    }

    public function getFrase() {
        return html_entity_decode($this->_frase);
    }

    public function setFrase($frase) {
        $this->_frase = htmlentities($frase);
        return $this;
    }

    public function getCon2() {
        return $this->_con2;
    }

    public function setCon2($con2) {
        $this->_con2 = $con2;
        return $this;
    }

    public function getCon3() {
        return $this->_con3;
    }

    public function setCon3($con3) {
        $this->_con3 = $con3;
        return $this;
    }

    public function getTwitter() {
        return $this->_twitter;
    }

    public function setTwitter($twitter) {
        $this->_twitter = $twitter;
        return $this;
    }

    public function getFacebook() {
        return $this->_facebook;
    }

    public function setFacebook($facebook) {
        $this->_facebook = $facebook;
        return $this;
    }

    public function getOrkut() {
        return $this->_orkut;
    }

    public function setOrkut($orkut) {
        $this->_orkut = $orkut;
        return $this;
    }

    public function getFlickr() {
        return $this->_flickr;
    }

    public function setFlickr($flickr) {
        $this->_flickr = $flickr;
        return $this;
    }

    public function getMsn() {
        return $this->_msn;
    }

    public function setMsn($msn) {
        $this->_msn = $msn;
        return $this;
    }


    public function getGrupoUsuario() {
        $grupoUsuario = new GrupoUsuario();
        $mapperGrupoUsuario = new GrupoUsuarioMapper();
        $mapperGrupoUsuario->find("$this->_fkGrupoUsuario", $grupoUsuario);
        return $grupoUsuario;
    }

    public function getListaAlbuns() {
        $itemMapper = new AlbumMapper();
		$selectItens = $itemMapper->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);			
		$selectItens->where("fkUsuario=$this->_idUsuario");
		$itens = $itemMapper->fetchAll($selectItens);
        return $itens;
    }

//=========================================================
//funcoes adicionadas a para login/autenticacao (by ALK)
//=========================================================
    public function getLogin() {
        return $this->_login;
    }

    public function setLogin($_login) {
        $this->_login = $_login;
		return $this;
    }

    public function getSenha() {
        return $this->_senha;
    }

    public function setSenha($_senha) {
        $this->_senha = $_senha;
		return $this;
    }

    public function getRoleId() {
        if ($this->_fkGrupoUsuario == null) {
            return 'Visitante';
        }
        if ($this->_roleId==null){
            $this->_roleId = $this->getGrupoUsuario()->getRoleId();
        }
        return $this->_roleId;
    }


    //public function setRoleId($_roleId) {
    //    $this->_roleId = $_roleId;
    //}


    public function getListaPermissoes() {
        /* ALTERADO POR MGCL
			
		$id = $this->_idUsuario;
        if($id==null){$id='null';}
        $pUsuarioMapper = new PermissoesUsuarioMapper();
        $pUsuario = $pUsuarioMapper->fetchControlado("fkUsuario='$id'", null);
        return $pUsuario;*/

        $id = $this->_idUsuario;
        if($id==null){$id='null';}
        $itemMapper = new PermissoesUsuarioMapper();
		$selectItens = $itemMapper->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);			
		$selectItens->where("fkUsuario='$id'");
		$selectItens->limit('10','0');
		$itens = $itemMapper->fetchAll($selectItens);
        return $itens;


    }


//=========================================================
//funcoes adicionadas a para listas de relacionamentos do usuario (by MGCL)
//=========================================================
    
	public function getListaArtistas(){
        $itemMapper = new RelUsuarioArtistaMapper();
		$itens = $itemMapper->artistas($this->_idUsuario);
        return $itens;
    }

	public function getListaAgencias(){
        $itemMapper = new RelUsuarioAgenciaMapper();
		$itens = $itemMapper->agencias($this->_idUsuario);
        return $itens;

    }		
	public function getListaCidades(){
        $itemMapper = new RelUsuarioCidadeMapper();
		$itens = $itemMapper->cidades($this->_idUsuario);
        return $itens;

    }			
	public function getListaItems(){
        $itemMapper = new RelUsuarioItemMapper();
		$itens = $itemMapper->items($this->_idUsuario);
        return $itens;

    }
	public function getListaEventos(){
        $itemMapper = new RelUsuarioEventoMapper();
		$itens = $itemMapper->eventos($this->_idUsuario);
        return $itens;

    }
	public function getListaFestivais(){
        $itemMapper = new RelUsuarioFestivalMapper();
		$itens = $itemMapper->festivais($this->_idUsuario);
        return $itens;
    }
	public function getListaGenerosMusicais(){
        $itemMapper = new RelUsuarioGeneroMusicalMapper();
		$itens = $itemMapper->generoMusicais($this->_idUsuario);
        return $itens;

    }	

	public function getListaCategorias(){
        $itemMapper = new RelUsuarioCategoriaMapper();
		$itens = $itemMapper->categorias($this->_idUsuario);
        return $itens;
    }
	public function getListaTipoEventos(){
        $itemMapper = new RelUsuarioTipoEventoMapper();
		$itens = $itemMapper->tipoEevntos($this->_idUsuario);
        return $itens;
    }
	public function getListaAutores(){
        $itemMapper = new RelUsuarioAutorMapper();
		$itens = $itemMapper->autores($this->_idUsuario);
        return $itens;
    }

	public function getListaComentarios(){
		$itemMapper= new ComentarioMapper();
		$selectItens = $itemMapper->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);			
		$selectItens->where("fkUsuario='$this->_idUsuario'");
		$autores = $itemMapper->fetchAll($selectItens);	
		return $autores;
    }	

	public function getListaUsuarioOrigem(){
        $itemMapper = new RelUsuarioUsuarioMapper();
		$itens = $itemMapper->usuariosOrigem($this->_idUsuario);
        return $itens;

    }

	public function getListaUsuarioDestino(){
        $itemMapper = new RelUsuarioUsuarioMapper();
		$itens = $itemMapper->usuariosDestino($this->_idUsuario);
        return $itens;

    }
	public function getImagens(){
       		// FOTOS USUARIO INICIO
			// OBS A fkPosição = 12  refere-se a posição de layout 12 = foto usuario
		$table = new RelCPMMapper();
		$imagens= $table->imagens($this->_idUsuario,12,1);
		return $imagens;			
      		// FOTOS USUARIO FIM
	}
public function lastVip($last=10){//adota 10 como padrao, caso nehujm seja informado
	
	//ultimas adicoes vip de Agencias
	$mapper = new RelUsuarioAgenciaMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);

	$entries = array();
	$lasts = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getAgencia();
	}
	$lasts['Agencia'] = $entries;
	
	
	//ultimas adicoes vip de Atistas
	$mapper = new RelUsuarioArtistaMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getArtista();
	}
	$lasts['Artista'] = $entries;
	
	
	//ultimas adicoes vip de Autor
	$mapper = new RelUsuarioAutorMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getAutor();
	}
	$lasts['Autor'] = $entries;
	
	//ultimas adicoes vip de Cidade
	$mapper = new RelUsuarioCidadeMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getCidade();
	}
	$lasts['Cidade'] = $entries;
	
	//ultimas adicoes vip de Item
	$mapper = new RelUsuarioItemMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getItem();
	}
	$lasts['Item'] = $entries;

		//ultimas adicoes vip de Evento
	$mapper = new RelUsuarioEventoMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getEvento();
	}
	$lasts['Evento'] = $entries;
	
	//ultimas adicoes vip de Festival
	$mapper = new RelUsuarioFestivalMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getFestival();
	}
	$lasts['Festival'] = $entries;	
	
	//ultimas adicoes vip de GeneroMusical
	$mapper = new RelUsuarioGeneroMusicalMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries = $rel->getGeneroMusical();
	}
	$lasts['GeneroMusical'] = $entries;
	
			
	//ultimas adicoes vip de Categoria
	$mapper = new RelUsuarioCategoriaMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getCategoria();
	}
	$lasts['Categoria'] = $entries;
		
	//ultimas adicoes vip de TipoEvento
	$mapper = new RelUsuarioTipoEventoMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getTipoEvento();
	}
	$lasts['TipoEvento'] = $entries;
			
	//ultimas adicoes vip de Usuario
	$mapper = new RelUsuarioUsuarioMapper(); //instancia o mapper
	$select = $mapper->getDbTable()->select();
	$select->where('fkUsuario=?',$this->getIdUsuario());
	$select->limit($last, 0);
	$select->order('dataInclusao DESC');
	
	$rels = $mapper->fetchAll($select);
	$entries = array();
	foreach ($rels as $rel){
		$entries[] = $rel->getUsuarioDestino();
	}
	$lasts['Usuario'] = $entries;
	
	return $lasts;	
}

}
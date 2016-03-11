<?php

class WidgetController extends Zend_Controller_Action {

    public function init() {
        /* INICIALICA AS AÇÕES DO CONTROLLER AQUI 
			O QUE ESTIVER DEFINIDO NESTA FUNÇÃO FICA DISPONIVEL A TODO O CONTROLLER
		*/
			$usuarioAuth = Zend_Auth::getInstance()->getIdentity();
			$this->view->usuarioAuth = $usuarioAuth;
			$this->initView();	
			
			// desabilitando layout
			$this->_helper->layout->disableLayout();
			//habilitando layout 2
			$this->_helper->layout->setLayout('layout2');

				ZendX_JQuery::enableView($this->view);
 	      	$request = $this->getRequest();
			
			// INICIO CONTATO
			//$this->view->formContato = $this->view->action('index','contato');
			// FIM CONTATO

			// INICIO LOGIN
			$this->view->formLogin = $this->view->action('entrar','auth');
			// FIM LOGIN
			

			
	
    }
	public function criarCobertura($id){
		// DEFINICAO DO EVENTO INICIO
		
		$request = $this->getRequest();
		$item = new Evento();
		$mapper= new EventoMapper();
		$mapper->find($request->id,$item);

		$texto="";
		foreach ( $item->getFotos() as $cid){	
		$texto.=$cid->getCaminho().",";
		}

		$item->setCobertura($texto);
		$mapper->updateCobertura($item);


	}
    public function indexAction() {
			
       			
    }


		
    public function criarMaisCidadesAction() {
		// DEFINICAO DO CIDADES
		$request = $this->getRequest();			
		
		$mapperItens= new CidadeMapper();
		$selectItens = $mapperItens->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$selectItens->where("fkSigla='sp'");
		$selectItens->order("titulo asc");
		$itens = $mapperItens->fetchAll($selectItens);
		
		$arquivo = "../application/views/scripts/widget/mais-cidades.phtml"; // nome do arquivo gerado 
		
		$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"<div class='outros_itens'>\r\n");
		fwrite($ponteiro,"<h2>Mais Cidades</h2>\r\n");
		foreach($itens as $i ) {
			$titulo = ($i->getTitulo());
			$link = $i->getIdCidade();						
			$conteudo = "<div class='item_outros_itens'>\r\n";
			$conteudo .= "<a href='/cidade/conteudo/id/$link' title='ver'> $titulo</a>\r\n";
			$conteudo .= "</div>\r\n";										
			fwrite($ponteiro, $conteudo);    			
		}
		fwrite($ponteiro,"</div>\r\n");
	}
	    public function dataAction() {

$request = $this->getRequest();	
$this->view->data1 = $request->data1;
$this->view->data2 = $request->data2;
		}
    public function criarMenuCidadesAction() {
		// DEFINICAO DO CIDADES
				
		
		$mapperItens= new CidadeMapper();
		$selectItens = $mapperItens->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$selectItens->where("fkSigla='sp'");
		$selectItens->order("titulo asc");
		$itens = $mapperItens->fetchAll($selectItens);
		
		$arquivo = "../application/views/scripts/widget/menu-cidades.phtml"; // nome do arquivo gerado 
		
		$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"<div id='bloco-cidade-js'>\r\n");
		foreach($itens as $i ) {
			$titulo = ($i->getTitulo());
			$link = $i->getIdCidade();						
			$conteudo = "<div class='item-bloco-cidade-js'>\r\n";
			$conteudo .= "<a href='/cidade/conteudo/id/$link' title='ver'> $titulo</a>\r\n";
			$conteudo .= "</div>\r\n";										
			fwrite($ponteiro, $conteudo);    			
		}
		 
		fwrite($ponteiro,"<a href='#' id='botao2'><img src='/imagens/icones/fechar.png' title='fechar este quadro'/></a>\r\n");
		fwrite($ponteiro,"</div>\r\n");
	}
	public function criarUltimasCoberturasAction(){
		// DEFINICAO DO EVENTO INICIO

		$mapperCobertura= new EventoMapper();
		$selectMaisEventos = $mapperCobertura->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$selectMaisEventos->setIntegrityCheck(false);
		$selectMaisEventos->join('RelCPM', 'RelCPM.fkCanal=Evento.idEvento');
		$selectMaisEventos->where("RelCPM.fkPosicao='8'");
		$selectMaisEventos->where("Evento.dataEvento<= NOW()");
		$selectMaisEventos->group('Evento.idEvento');		
		$selectMaisEventos->order('Evento.dataEvento desc');
		$selectMaisEventos->limit(4,0);
		$coberturas = $mapperCobertura->fetchAll($selectMaisEventos);
		
		$arquivo = "../application/views/scripts/widget/ultimas-coberturas.phtml"; // nome do arquivo gerado 
		
		$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"<div class='mais-coberturas'>\r\n");
		fwrite($ponteiro,"<h2>Coberturas Recentes</h2>\r\n");
		
		foreach ( $coberturas as $cid){	

				$dataEvento = $cid->getDataEvento();
				$titulo = $cid->getTitulo();
				$id = $cid->getIdEvento();	

				
	
					foreach ( $cid->getFotoDestaque() as $fotoDestaque) { 
					$foto = $fotoDestaque->getCaminho();
					$conteudo .= "<div class='item-cobertura'>\r\n";
						$conteudo .= "<div class='data'>\r\n"; 
							$conteudo .= "<div class='data-mes'><?php echo \$this->Data('$dataEvento')->extenso_sub; ?></div>\r\n";
							$conteudo .= "<div class='data-dia'><?php echo \$this->Data('$dataEvento')->pt_br_dia; ?></div>\r\n";
							$conteudo .= "<div class='data-ano'><?php echo \$this->Data('$dataEvento')->mes_sub; ?></div>\r\n";
						$conteudo .= "</div>  \r\n"; 
						$conteudo .= "<div class='item-foto-cobertura' >\r\n";
							$conteudo .= "<a href=/evento/cobertura-fotografica/id/$id>\r\n";
								$conteudo .= "<img src='/img/$foto' width='190'/>\r\n";
							$conteudo .= "</a>   \r\n";              
						$conteudo .= "</div>\r\n";
						$conteudo .= "<div class='titulo-item-cobertura'>\r\n";
							$conteudo .= "<a href='/evento/cobertura-fotografica/id/$id' title='ver'>$titulo</a>\r\n";       
						$conteudo .= "</div>\r\n";     
					$conteudo .= "</div>\r\n";
					

			}	
			 	   			
		}
		fwrite($ponteiro, $conteudo);
		fwrite($ponteiro,"</div>\r\n");
	}

	public function criarListaArtigosAction(){
		// DEFINICAO DO EVENTO INICIO

	$mapperArtigo= new ArtigoMapper();
	$selectArtigos = $mapperArtigo->getDbTable()->select(); 
	$selectArtigos->order('dataArtigo desc');
    $artigos =  $mapperArtigo->fetchAll($selectArtigos); 
		
	$arquivo = "../application/views/scripts/widget/lista-artigos.phtml"; // nome do arquivo gerado 
	
	$ponteiro = fopen($arquivo, "w");	
	fwrite($ponteiro,"<div id='bloco-lista-artigo'>\r\n");
	fwrite($ponteiro,"<h2>Posts</h2>\r\n");	
	foreach ( $artigos as $cid){	
		$dataArtigo = $cid->getDataArtigo();
		$titulo = $cid->getTitulo();
		$tipoArtigo = $cid->getTipoArtigo()->getTitulo();
		$id = $cid->getIdArtigo();					
		foreach ( $cid->getListaColunistas() as $colunista) {
			$tituloAutor = $colunista->getAutor()->getTitulo(); 
			foreach ( $colunista->getAutor()->getImagens() as $fotoAutor) { 
				$foto = $fotoAutor->getCaminho();
				$conteudo .= "<div class='item-lista-artigo'>\r\n";		
					$conteudo .= "<div class='item-lista-artigo-coluna'>\r\n";	
						$conteudo .= "<div class='item-lista-artigo-colunista'>\r\n";
							$conteudo .= "<div class='item-foto-bloco-autor'>\r\n";
								$conteudo .= "<img src='/img/$foto' width='77'/>\r\n";
							$conteudo .= "</div>\r\n";
										$conteudo .= "$tituloAutor\r\n";
						$conteudo .= "</div>\r\n";
					$conteudo .= "</div>\r\n";
					$conteudo .= "<div class='data'>\r\n"; 
						$conteudo .= "<div class='data-mes'><?php echo \$this->Data('$dataArtigo')->extenso_sub; ?></div>\r\n";
						$conteudo .= "<div class='data-dia'><?php echo \$this->Data('$dataArtigo')->pt_br_dia; ?></div>\r\n";
						$conteudo .= "<div class='data-ano'><?php echo \$this->Data('$dataArtigo')->mes_sub; ?></div>\r\n";
					$conteudo .= "</div>  \r\n"; 
				$conteudo .= "<div class='item-lista-artigo-titulo'>\r\n"; 
					$conteudo .= "<a href='/artigo/conteudo/id/$id' title='ver'>\r\n";  
						$conteudo .= "$titulo\r\n"; 
						$conteudo .= "<div class='item-lista-artigo-coluna'>\r\n";  
						$conteudo .= " $tipoArtigo\r\n";             
						$conteudo .= " </div>\r\n"; 
					$conteudo .= "</a>\r\n"; 
				$conteudo .= "</div>\r\n"; 
				$conteudo .= "</div>\r\n"; 
			}
		}
		
	}
fwrite($ponteiro, $conteudo);
	fwrite($ponteiro,"</div>\r\n");
	}

	public function criarCoberturaAction(){
		// DEFINICAO DO EVENTO INICIO
		
		$request = $this->getRequest();
		$this->criarCobertura($request->id);
	}
 public function criarDestaquesCoberturasAction() {
			// DEFINICAO DO EVENTO INICIO
 	       	$request = $this->getRequest();
			$mapperCobertura= new EventoMapper();
			$selectMaisEventos = $mapperCobertura->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			$selectMaisEventos->setIntegrityCheck(false);
			$selectMaisEventos->join('RelCPM', 'RelCPM.fkCanal=Evento.idEvento');
			$selectMaisEventos->where("Evento.dataEvento<= NOW()");

			$selectMaisEventos->where("RelCPM.fkPosicao='8'");
			$selectMaisEventos->limit('4','0');
			$selectMaisEventos->order('Evento.dataEvento desc');
			$coberturas = $mapperCobertura->fetchAll($selectMaisEventos);	

			
			

		$arquivo = "Cuber.xml"; // nome do arquivo gerado e utilizado para visualização de imagens
		
		$ponteiro = fopen($arquivo, "w");	
fwrite($ponteiro,"<data>\r\n");
  fwrite($ponteiro,"<debug>0</debug><licence><![CDATA[!'ws\$Ui'U]VE5O/O/_%ysqBA51Za7)\{]]></licence>\r\n");
  //<![CDATA[!'ws$Ui'U]VE5O/O/_%ysqBA51Za7)\{]]></licence>
  fwrite($ponteiro,"<project_settings>\r\n");
    fwrite($ponteiro,"<width>500</width>\r\n");
    fwrite($ponteiro,"<height>330</height>\r\n");
  fwrite($ponteiro,"</project_settings>\r\n");
  fwrite($ponteiro,"<settings>\r\n");
    fwrite($ponteiro,"<folder_images>/img</folder_images>\r\n");
	fwrite($ponteiro,"<folder_fonts>/fonts</folder_fonts>\r\n");
   fwrite($ponteiro," <background>\r\n");
     fwrite($ponteiro," <color transparent=\"true\">0xffffff</color>\r\n");
   fwrite($ponteiro," </background>\r\n");
    fwrite($ponteiro,"<start_slide>1</start_slide>\r\n");
    fwrite($ponteiro,"<auto_play>true</auto_play>\r\n");
    fwrite($ponteiro,"<randomize_slides>false</randomize_slides>\r\n");
    fwrite($ponteiro,"<branding align_to=\"stage\" align_pos=\"TR\" x=\"-10\" y=\"10\">\r\n");
      fwrite($ponteiro,"<remove_logo_loader>true</remove_logo_loader>\r\n");
      fwrite($ponteiro,"<remove_right_menu_info>true</remove_right_menu_info>\r\n");
      fwrite($ponteiro,"<remove_right_menu_licence>false</remove_right_menu_licence>\r\n");
    fwrite($ponteiro,"</branding>\r\n");
    fwrite($ponteiro,"<camera x=\"0\" y=\"0\" z=\"-115\" angleX=\"0\" angleY=\"0\" angleZ=\"0\"/>\r\n");
    fwrite($ponteiro,"<shadow show=\"true\" use_image=\"false\" color=\"0x000000\" alpha=\"1\" blur=\"40\" corner_TL=\"-50,450\" corner_TR=\"600,450\" corner_BR=\"600,300\" corner_BL=\"-96,300\"/>\r\n");
  fwrite($ponteiro,"</settings>\r\n");
  fwrite($ponteiro,"<fonts/>\r\n");
  fwrite($ponteiro,"<preloader type=\"linear\" align_pos=\"MC\" width=\"200\" height=\"20\" x=\"0\" y=\"0\" radius=\"30\">\r\n");
    fwrite($ponteiro,"<background padding=\"5\">\r\n");
      fwrite($ponteiro,"<tweenShow tint=\"0x2185C5\" alpha=\"0.85\" x=\"0\" y=\"0\"/>\r\n");
      fwrite($ponteiro,"<tweenOver alpha=\"1\"/>\r\n");
      fwrite($ponteiro,"<tweenHide alpha=\"0\"/>\r\n");
    fwrite($ponteiro,"</background>\r\n");
    fwrite($ponteiro,"<loader>\r\n");
      fwrite($ponteiro,"<tweenShow tint=\"0xFFFFFF\" alpha=\"0.8\"/>\r\n");
      fwrite($ponteiro,"<tweenOver tint=\"0xFFFFFF\" alpha=\"1\"/>\r\n");
      fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\" alpha=\"0\"/>\r\n");
    fwrite($ponteiro,"</loader>\r\n");
  fwrite($ponteiro,"</preloader>\r\n");
  fwrite($ponteiro,"<controls>\r\n");
    fwrite($ponteiro,"<auto_play_indicator type=\"circular\" align_pos=\"TR\" x=\"-42\" y=\"29\" width=\"300\" height=\"10\" padding=\"2\" radius=\"15\">\r\n");
      fwrite($ponteiro,"<auto_hide time=\"3\">false</auto_hide>\r\n");
      fwrite($ponteiro,"<hide_on_transition>true</hide_on_transition>\r\n");
      fwrite($ponteiro,"<background padding=\"3\">\r\n");
        fwrite($ponteiro,"<tweenShow tint=\"0x000000\" alpha=\"0.7\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0x2185C5\" alpha=\"1\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0x000000\" alpha=\"0\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
      fwrite($ponteiro,"</background>\r\n");
      fwrite($ponteiro,"<loader>\r\n");
        fwrite($ponteiro,"<tweenShow tint=\"0xffffff\" alpha=\"0.85\"/>\r\n");
        fwrite($ponteiro,"<tweenOver alpha=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide alpha=\"0\"/>\r\n");
      fwrite($ponteiro,"</loader>\r\n");
    fwrite($ponteiro,"</auto_play_indicator>\r\n");
    fwrite($ponteiro,"<prev_button align_pos=\"ML\" width=\"40\" height=\"40\" x=\"47\" y=\"0\">\r\n");
      fwrite($ponteiro,"<auto_hide time=\"3\">false</auto_hide>\r\n");
      fwrite($ponteiro,"<hide_on_transition>true</hide_on_transition>\r\n");
      fwrite($ponteiro,"<background round_corners=\"0,0,0,0\">\r\n");
        fwrite($ponteiro,"<tweenShow tint=\"0x000000\" alpha=\"0.85\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0x2185C5\" alpha=\"1\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0x000000\" alpha=\"0\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
      fwrite($ponteiro,"</background>\r\n");
      fwrite($ponteiro,"<symbol type=\"1\" align_pos=\"MC\" x=\"0\" y=\"0\">\r\n");
        fwrite($ponteiro,"<tweenShow alpha=\"1\" scaleX=\"0.85\" scaleY=\"0.85\" tint=\"0xFFFFFF\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0xFFFFFF\" scaleX=\"1\" scaleY=\"1\" alpha=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\" scaleX=\"0.85\" scaleY=\"0.85\" alpha=\"0\"/>\r\n");
      fwrite($ponteiro,"</symbol>\r\n");
    fwrite($ponteiro,"</prev_button>\r\n");
    fwrite($ponteiro,"<next_button align_pos=\"MR\" width=\"40\" height=\"40\" x=\"-49\" y=\"0\">\r\n");
      fwrite($ponteiro,"<auto_hide time=\"3\">false</auto_hide>\r\n");
      fwrite($ponteiro,"<hide_on_transition>true</hide_on_transition>\r\n");
      fwrite($ponteiro,"<background round_corners=\"0,0,0,0\">\r\n");
        fwrite($ponteiro,"<tweenShow tint=\"0x000000\" alpha=\"0.85\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0x2185C5\" alpha=\"1\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0x000000\" alpha=\"0\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
      fwrite($ponteiro,"</background>\r\n");
      fwrite($ponteiro,"<symbol type=\"1\" align_pos=\"MC\" x=\"0\" y=\"0\">\r\n");
        fwrite($ponteiro,"<tweenShow alpha=\"1\" scaleX=\"0.85\" scaleY=\"0.85\" tint=\"0xFFFFFF\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0xFFFFFF\" scaleX=\"1\" scaleY=\"1\" alpha=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\" scaleX=\"0.85\" scaleY=\"0.85\" alpha=\"0\"/>\r\n");
      fwrite($ponteiro,"</symbol>\r\n");
    fwrite($ponteiro,"</next_button>\r\n");
  fwrite($ponteiro,"</controls>\r\n");
  fwrite($ponteiro,"<description align_pos=\"BC\" x=\"0\" y=\"-35\" width=\"450\" height=\"60\">\r\n");
    fwrite($ponteiro,"<auto_hide time=\"3\">true</auto_hide>\r\n");
    fwrite($ponteiro,"<hide_on_transition>true</hide_on_transition>\r\n");
    fwrite($ponteiro,"<bake_on_transition>true</bake_on_transition>\r\n");
    fwrite($ponteiro,"<background round_corners=\"0,0,0,0\">\r\n");
      fwrite($ponteiro,"<tweenShow tint=\"0x000000\" alpha=\"0.75\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
      fwrite($ponteiro,"<tweenOver tint=\"0x2185C5\" alpha=\"1\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
      fwrite($ponteiro,"<tweenHide tint=\"0x000000\" alpha=\"0\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");
    fwrite($ponteiro,"</background>\r\n");
    fwrite($ponteiro,"<heading margin=\"5,5,5,5\" text_bold=\"true\" text_size=\"18\" x=\"5\" y=\"5\" width=\"90\" text_leading=\"0\" text_letterSpacing=\"0\" font=\"Arial\" text_align=\"left\">\r\n");
      fwrite($ponteiro,"<tweenShow tint=\"0xFFFFFF\"/>\r\n");
      fwrite($ponteiro,"<tweenOver tint=\"0xFFFFFF\"/>\r\n");
      fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\"/>\r\n");
    fwrite($ponteiro,"</heading>\r\n");
    fwrite($ponteiro,"<paragraph margin=\"0,5,5,5\" text_size=\"12\" text_leading=\"0\" font=\"Arial\" text_align=\"left\" text_letterSpacing=\"0\">\r\n");
      fwrite($ponteiro,"<tweenShow tint=\"0xFFFFFF\"/>\r\n");
      fwrite($ponteiro,"<tweenOver tint=\"0xFFFFFF\"/>\r\n");
      fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\"/>\r\n");
    fwrite($ponteiro,"</paragraph>\r\n");
  fwrite($ponteiro,"</description>\r\n");
  fwrite($ponteiro,"<thumbnails align_to=\"stage\" align_pos=\"BC\" x=\"260\" y=\"50\" width=\"81\" height=\"391.4\" scroll=\"vertical\" padding_x=\"0\" padding_y=\"0\">\r\n");
    fwrite($ponteiro,"<auto_hide time=\"3\">false</auto_hide>\r\n");
    fwrite($ponteiro,"<hide_on_transition>false</hide_on_transition>\r\n");
    fwrite($ponteiro,"<background color=\"0x000000\" alpha=\"0\" round_corners=\"0,0,0,0\"/>\r\n");
    fwrite($ponteiro,"<thumb width=\"70\" height=\"50\" spacing_x=\"10\" spacing_y=\"10\">\r\n");
      fwrite($ponteiro,"<background round_corners=\"5,5,5,5\">\r\n");
        fwrite($ponteiro,"<tweenShow tint=\"0x000000\" alpha=\"0.85\"/>\r\n");
        fwrite($ponteiro,"<tweenOver tint=\"0x2185C5\" alpha=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide tint=\"0xFFFFFF\" alpha=\"0\"/>\r\n");
        fwrite($ponteiro,"<tweenSelected tint=\"0xff00cc\" alpha=\"1\"/>\r\n");
      fwrite($ponteiro,"</background>\r\n");
      fwrite($ponteiro,"<image x=\"5\" y=\"5\" width=\"60\" height=\"40\" round_corners=\"0,0,0,0\">\r\n");
        fwrite($ponteiro,"<tweenShow alpha=\"0.85\"/>\r\n");
        fwrite($ponteiro,"<tweenOver alpha=\"1\"/>\r\n");
        fwrite($ponteiro,"<tweenHide alpha=\"0.85\"/>\r\n");
        fwrite($ponteiro,"<tweenSelected alpha=\"1\"/>\r\n");
      fwrite($ponteiro,"</image>\r\n");
    fwrite($ponteiro,"</thumb>\r\n");
    fwrite($ponteiro,"<scroller align_pos=\"BL\" x=\"0\" y=\"15\" width=\"391.4\" height=\"10\" round_corners=\"5,5,5,5\">\r\n");
      fwrite($ponteiro,"<bar color=\"0x777777\" alpha=\".9\"/>\r\n");
      fwrite($ponteiro,"<slider thickness=\"3\" color=\"0xf2f2f2\" alpha=\"1\"/>\r\n");
    fwrite($ponteiro,"</scroller>\r\n");
  fwrite($ponteiro,"</thumbnails>\r\n");
  fwrite($ponteiro,"<defaults>\r\n");
    fwrite($ponteiro,"<slide time=\"5\" color=\"0x000000\">\r\n");
      fwrite($ponteiro,"<image align_pos=\"MC\" x=\"0\" y=\"0\" scaleX=\"1\" scaleY=\"1\"/>\r\n");

      fwrite($ponteiro,"<description>\r\n");

      fwrite($ponteiro,"</description>\r\n");
    fwrite($ponteiro,"</slide>\r\n");
    fwrite($ponteiro,"<transition type=\"3D\" columns=\"3\" rows=\"3\" type2D=\"slide\" flipAngle=\"180\" flipOrder=\"315\" flipShader=\"none\" flipOrderFromCenter=\"false\" flipDirection=\"right\" flipColor=\"0x878787\" flipBoxDepth=\"10\" flipDepth=\"250\" flipEasing=\"Sine.easeOut\" flipDuration=\".6\" flipDelay=\".15\" flipDelayRandomize=\".5\"/>\r\n");
  fwrite($ponteiro,"</defaults>\r\n");
  fwrite($ponteiro,"<slides width=\"520\" height=\"332\" align_pos=\"TC\" x=\"0\" y=\"0\">\r\n");
  			foreach($coberturas as $i ) {
				if( $i->getFotoDestaque() ) {
					foreach($i->getFotoDestaque() as $foto){
					
						$imagem   = $foto->getCaminho();
						$titulo = ($i->getTitulo());
						$link = $i->getIdEvento();						
						$descricao= $i->getItem()->getTitulo();
	

    $conteudo = "<slide>\r\n";
      $conteudo .= "<url><![CDATA[/img/$imagem]]></url>\r\n";
      $conteudo .= "<link target=\"_self\"><![CDATA[/evento/cobertura-fotografica/id/$link]]></link>\r\n";
      $conteudo .= "<description>\r\n";
	  $conteudo .= "<heading><![CDATA[$titulo]]></heading>\r\n";
	  $conteudo .= "<paragraph><![CDATA[$descricao]]></paragraph>\r\n";
	  $conteudo .= "</description>\r\n";
    $conteudo .= "</slide>\r\n";
    $conteudo .= "<transition/>\r\n";					

						
						fwrite($ponteiro, $conteudo);    
						

					}
				}
			}
	
  fwrite($ponteiro,"</slides>\r\n");
fwrite($ponteiro,"</data>\r\n");

	}
	public function criarTodasCoberturasAction(){
		// DEFINICAO DO EVENTO INICIO
		
		$request = $this->getRequest();
		$mapperCob= new EventoMapper();
		$selectEventos = $mapperCob->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$selectEventos->setIntegrityCheck(false);	
		$selectEventos->join('RelCPM', 'RelCPM.fkCanal=Evento.idEvento');
		$selectEventos->where("RelCPM.fkPosicao='5'");
		$selectEventos->where("Evento.dataEvento<=NOW()");
		$selectEventos->group('RelCPM.fkCanal');
		$selectEventos->order('Evento.dataEvento desc');

		$selectEventos->limit($request->fim,$request->inicio);
		$cob = $mapperCob->fetchAll($selectEventos);
				
		foreach ( $cob as $cid){	

			$id = $cid->getIdEvento();
			//echo "<h2>".$cid->getIdEvento()."</h2>";
			$this->criarCobertura($cid->getIdEvento());
		
		}
	}
	
	public function criarTodasPublicidadesAction(){
		//$this->getHelper('viewRenderer')->setNoRender();
		//$this->getHelper('layout')->disableLayout();
		// PUBLICIDADE
			
	// DIA DE HOJE
	$hoje=date('Y-m-d');
	$mapperReserva= new ReservaPublicidadeMapper();
	
	//INICIO SUPER BANNER
	$publicidadeSuperBanner = $mapperReserva->propagandas(1,$hoje,1);//superbanner
	$arquivo = "../application/views/scripts/publicidade/super-banner.phtml"; // nome do arquivo gerado 
	$ponteiro = fopen($arquivo, "w");	
	fwrite($ponteiro,"<div id='super-banner'>\r\n");
	foreach ( $publicidadeSuperBanner as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
				
				$conteudo .= "<a href='http://$link' target='_blank'>\r\n";		
					$conteudo .= "<img src='/img/$imagem' width='730' height='92'/>\r\n";	
				$conteudo .= "</a>\r\n";
 

	}
	fwrite($ponteiro, $conteudo);
	fwrite($ponteiro,"</div>\r\n");	
	//FIM SUPER BANNER
	
	
	//INICIO AGENDA INDEX BANNER
	$publicidadeBannerAgendaHome = $mapperReserva->propagandas(5,$hoje,1);//publicidadeBannerAgendaHome
	$arquivo4 = "../application/views/scripts/publicidade/publicidade-banner-agenda-home.phtml"; // nome do arquivo gerado 
	$ponteiro4 = fopen($arquivo4, "w");	
	fwrite($ponteiro4,"<div id='super-banner'>\r\n");
	foreach ( $publicidadeBannerAgendaHome as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
				
				$conteudo4 .= "<a href='http://$link' target='_blank'>\r\n";		
					$conteudo4 .= "<img src='/img/$imagem' width='730' height='92'/>\r\n";	
				$conteudo4 .= "</a>\r\n";
 

	}
	fwrite($ponteiro4, $conteudo4);
	fwrite($ponteiro4,"</div>\r\n");	
	//FIM AGENDA INDEX BANNER
	
	//INICIO ULTRA BANNER
	$publicidadeUltraBanner = $mapperReserva->propagandas(6,$hoje,1);//publicidadeUltraBanner
	$arquivo5 = "../application/views/scripts/publicidade/publicidade-ultra-banner.phtml"; // nome do arquivo gerado 
	$ponteiro5 = fopen($arquivo5, "w");	
	fwrite($ponteiro5,"<div id='publicidade-ultra-banner'>\r\n");
	foreach ( $publicidadeUltraBanner as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
				$conteudo5 .= "<p>Publicidade<p>";				
				$conteudo5 .= "<a href='http://$link'>\r\n";		
					$conteudo5 .= "<img src='/img/$imagem'/>\r\n";	
				$conteudo5 .= "</a>\r\n";
 

	}
	fwrite($ponteiro5, $conteudo5);
	fwrite($ponteiro5,"</div>\r\n");	
	//FIM ULTRA BANNER
	
	
	//INICIO RETANGULO MEDIO
	$retanguloMedio = $mapperReserva->propagandas(4,$hoje,1);//superbanner
	$arquivo1 = "../application/views/scripts/publicidade/publicidade1.phtml"; // nome do arquivo gerado 
	$ponteiro1 = fopen($arquivo1, "w");	
	fwrite($ponteiro1,"<div id='publicidade-1'>\r\n");
	foreach ( $retanguloMedio as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
				
				$conteudo1 .= "<a href='http://$link' target='_blank'>\r\n";		
					$conteudo1 .= "<img src='/img/$imagem' width='300'/>\r\n";	
				$conteudo1 .= "</a>\r\n";
 

	}
	fwrite($ponteiro1, $conteudo1);
	fwrite($ponteiro1,"</div>\r\n");	
	//FIM RETANGULO MEDIO
	
	//INICIO BRAND DIREITA
	$brandDireita1 = $mapperReserva->propagandas(7,$hoje,1);//publicidadeEventoIndex1
	$brandDireita2 = $mapperReserva->propagandas(8,$hoje,1);//publicidadeEventoIndex2	
	$brandDireita3 = $mapperReserva->propagandas(9,$hoje,1);//publicidadeEventoIndex3
	$brandDireita4 = $mapperReserva->propagandas(10,$hoje,1);//publicidadeEventoIndex4
	$brandDireita5 = $mapperReserva->propagandas(11,$hoje,1);//publicidadeEventoIndex5
	$brandDireita6 = $mapperReserva->propagandas(12,$hoje,1);//publicidadeEventoIndex6
	
	$arquivo2 = "../application/views/scripts/publicidade/publicidade-brand-direita.phtml"; // nome do arquivo gerado 
	$ponteiro2 = fopen($arquivo2, "w");	
	fwrite($ponteiro2,"<div id='publicidade-evento-index'>\r\n");
	foreach ( $brandDireita1 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}
	foreach ( $brandDireita2 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}	
	foreach ( $brandDireita3 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}
	foreach ( $brandDireita4 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}
	foreach ( $brandDireita5 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}
	foreach ( $brandDireita6 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo2 .= "<div class='item-publicidade-evento-index'>\r\n";
			$conteudo2 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo2 .= "<img src='/img/$imagem' width='150'/>\r\n";	
			$conteudo2 .= "</a>\r\n";
		$conteudo2 .= "</div>\r\n";
	}
	fwrite($ponteiro2, $conteudo2);
	fwrite($ponteiro2,"</div>\r\n");	
	//FIM BRAND DIREITA		
							
	//INICIO BRAND RODAPE
	$brandRodape1 = $mapperReserva->propagandas(13,$hoje,1);//Brand Rodape1
	$brandRodape2 = $mapperReserva->propagandas(14,$hoje,1);//Brand Rodape2	
	$brandRodape3 = $mapperReserva->propagandas(15,$hoje,1);//Brand Rodape3
	$brandRodape4 = $mapperReserva->propagandas(16,$hoje,1);//Brand Rodape4
	$brandRodape5 = $mapperReserva->propagandas(17,$hoje,1);//Brand Rodape5
	$brandRodape6 = $mapperReserva->propagandas(18,$hoje,1);//Brand Rodape6
	$brandRodape7 = $mapperReserva->propagandas(19,$hoje,1);//Brand Rodape7
	$brandRodape8 = $mapperReserva->propagandas(20,$hoje,1);//Brand Rodape8	
	
	$arquivo3 = "../application/views/scripts/publicidade/publicidade-brand-rodape.phtml"; // nome do arquivo gerado 
	$ponteiro3 = fopen($arquivo3, "w");	
	fwrite($ponteiro3,"<div id='publicidade-brand-rodape'>\r\n");
	foreach ( $brandRodape1 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape2 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}	
	foreach ( $brandRodape3 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape4 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape5 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape6 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape7 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	foreach ( $brandRodape7 as $cid){	
		$link = $cid->getLinkPropaganda();
		$imagem = $cid->getCaminho();
		$conteudo3 .= "<div class='item-publicidade-brand-rodape'>\r\n";
			$conteudo3 .= "<a href='http://$link' target='_blank'>\r\n";		
				$conteudo3 .= "<img src='/img/$imagem' width='105' '/>\r\n";	
			$conteudo3 .= "</a>\r\n";
		$conteudo3 .= "</div>\r\n";
	}
	fwrite($ponteiro3, $conteudo3);
	fwrite($ponteiro3,"</div>\r\n");	
	//FIM BRAND RODAPE		


	}
	
}
<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
			//$usuarioAuth = Zend_Auth::getInstance()->getIdentity();
			//$this->view->usuarioAuth = $usuarioAuth;	

			//dia de hoje
			$hoje=date('Y-m-d');

 	       	$request = $this->getRequest();
			$usuario= new Usuario();
			$mapper= new UsuarioMapper();
			$mapper->find($request->id,$usuario);
			$this->view->usuarios = $usuario;	




    }

    public function indexAction() {
		$mapper= new UsuarioMapper();
		$this->view->listaUsuarios = $mapper->fetchAll();
        
    }

    public function listarAction() {
        // action body
        $usuarios = new UsuarioMapper();
        $this->view->usuarios = $usuarios->fetchAll();
    }

    public function cadastrarAction() {
        // action body

        $request = $this->getRequest();
        $form = new Application_Form_UsuarioCadastrar();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
				$usuario = new Usuario($form->getValues());
				$mapper = new UsuarioMapper();
				$usuario->setDataNascimento($request->ano."-".$request->mes."-".$request->dia);
				$usuario->getDataNascimento();
				$id = $mapper->insert($usuario);
				$item = $mapper->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$item->setIntegrityCheck(false);
				$item->where("idUsuario='$id'");
				$mapperUsuario = $mapper->fetchAll($item);	

				foreach($mapperUsuario as $usu){
					echo "<div id='mensagem'>".($usu->getNome()).", uma mensagem com os dados de acesso a sua Área Vip e link para confirmação de cadastrofoi encaminhada para o con ";	
					echo $usu->getCon().". Acesse o mesmo para conseguir entrar no seu perfil na VNB eventos.<a href='/auth/login'>Faça seu login agora</a> ou <a href='/index/home'>continue navegando</a></div>";				   
					$assunto="[VNB] cadastro area VIP link de confirmação";
					$con=$usu->getCon();
				   
					$mail = new Zend_Mail();
					$mail->setFrom('contato@vnbeventos.com.br', $usu->getNome(),$assunto)
					 ->addTo($con, 'VNB Eventos')
					 ->setBodyHtml("
					 				<p>[VNB eventos] $assunto<br/></p>

									<p>Olá ".($usu->getNome())." Seu cadastro foi confirmado com sucesso pelo nosso sistema!</p>
									
									<p>Seja bem-vindo ao VNB Eventos, o lugar certo para quem busca se inteirar sobre os acontecimentos do mundo dos eventos!</p>
									<p>Lembre-se de guardar seu usuário e senha num lugar seguro e jamais revelá-los para outras pessoas.</p>
									<p>O VNB Eventos divulga os melhores eventos, coberturas fotográficas, notícias sobre seu ídolo, tudo sobre festas, agendas para o final de semana, e muito mais!  Aqui você é VIP, pode adicionar suas fotos favoritas ao álbum, se conectar a novos amigos, trocar comentários e interagir/participar do conteúdo e ainda ficar por dentro das novidades do mundo do entretenimento.</p> 
									
									<p><a href='/'>Acesse o dx agora!</a></p> 
									<p>A VNB Eventos e Kontempler respeitam sua privacidade e jamais enviarão qualquer material não solicitado para o seu e-mail. Leia nossa política de privacidade.</p>
									
									<p>Não responda este e-mail. Ele foi gerado automaticamente.</p>
									<p>Caso você não tenha se cadastrado na VNB Eventos, por favor desconsidere esse e-mail ou acesso dx <a href=''>www.vnbeventos.com.br.</a></p>

					 				<p>
									 Seguem abaixo as informações de acesso.
									</p>
					 				<p>
									login:".$usu->getLogin()."<br/>
									con:".$usu->getCon()." <br/>
										
									senha:".$usu->getSenha()."
									$request->mensagem
									</p>
					 				<p>
									Obs: Caso este pedido não tenha sido solicitado por você, favor, desconsiderar esta mensagem
									</p>		
									<p>
									Atenciosamente,
									Direção de Tecnologia<br/>
									VNB eventos<br/>
									\"Viva o mundo do Entretenimento\"<br/>
									www.vnbeventos.com.br
									</p>							
									")
					 ->setSubject("[VNB eventos] $assunto")
					 ->send();
				   }			   
              // return $this->_helper->redirector('index');
           }
		   
        }else{$this->view->form = $form;}
        
    }

    public function recuperarSenhaAction() {
        // action body

        $request = $this->getRequest();
        $form = new Application_Form_RecuperarSenhaUsuario();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
               $mapper = new UsuarioMapper();
               $mapperUsuario = $mapper->fetchControlado("con='$request->con'",null);
			   foreach($mapperUsuario as $usu){
				   echo $usu->getNome().", uma mensagem com os dados de acesso a sua Área Vip foi encaminhada para o con ";	
				   echo $usu->getCon().". Acesse o mesmo para conseguir entrar no seu perfil na VNB eventos.";			   
				   $assunto="recuperar informacoes de acesso";
				   $con=$usu->getCon();
				   
				$mail = new Zend_Mail();
				$mail->setFrom('vnbeventos@gmail.com', $usu->getNome(),$assunto)
					 ->addTo($con, 'VNB Eventos')
					 ->setBodyHtml("
					 				<p>[VNB eventos] $assunto<br/></p>
					 				<p>
										Olá".$usu->getNome().", através do dx www.vnbeventos.com.br foi solicitado o envio de seus dados de acesso a sua Área VIP. Seguem abaixo as informações de acesso.
									</p>
					 				<p>
									login:".$usu->getLogin()."<br/>
									con:".$usu->getCon()." <br/>
										
									senha:".$usu->getSenha()."
									$request->mensagem
									</p>
					 				<p>
									Obs: Caso este pedido não tenha sido solicitado por você, favor, desconsiderar esta mensagem
									</p>		
									<p>
									Atenciosamente,
									Direção de Tecnologia<br/>
									VNB eventos<br/>
									\"Viva o mundo do Entretenimento\"<br/>
									www.vnbeventos.com.br
									</p>							
									")
					 ->setSubject("[VNB eventos] $assunto")
					 ->send();
				   }
               //return $this->_redirect('/usuario/recuperar-senha');
           }
        }
        $this->view->form = $form;
    }
    public function inserirUsuarioAction() {
        // action body

        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
        if ($this->getRequest()) {
               $usuarioDestinoId = $request->id;
				$usuarioid = $usuarioAuth->idUsuario;
				$this->view->usuarioid = $usuarioid;
				$this->view->usuarioDestinoId = $usuarioDestinoId;
			
               $album = new RelUsuarioUsuario();
			   $album->setFkUsuarioDestino($usuarioDestinoId);	
			   $album->setFkUsuarioOrigem($usuarioid);
			   $album->setDataInclusao(date('Y-m-d H:i:s'));
   			   $album->getFkUsuarioDestino();	
			   $album->getFkUsuarioOrigem();				
               $mapper = new RelUsuarioUsuarioMapper();
               $mapper->insert($album);
               return $this->_redirect("/usuario/conteudo/id/".$request->id);
        }
    
    }

	public function cadastrarImagemAction() {
						//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;
			// action body
			$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
			$request = $this->getRequest();
			$form = new Application_Form_Imagem();
			// Envia para a view
			$this->view->form = $form;
					
		   // Verifica se foi uma requisição POST
		   if( !$this->_request->isPost() )
			   return false;
				// Capturamos aqui o dados enviados via post
				$data = $this->_request->getPost();
				// Verifica se os dados do formulário são válidos
				if( !$form->isValid($data) )
					return false;
	
				$imgCadastro = new ImagemMapper();
				$novoId = $imgCadastro->cadastrarImagem(12,$usuarioAuth->idUsuario);
				$this->view->idImg = $novoId;
				return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
				
		}	

    public function pesquisarAction() {
        // action body
    }

    public function editarAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();			
        $form = new Application_Form_Usuario();
		if ($request->id == $usuarioAuth->idUsuario) {
			if ($this->getRequest()->isPost()) {
				if ($form->isValid($request->getPost())) {
				   $usuario = new Usuario($form->getValues());
				   $mapper = new UsuarioMapper();
				   $usuario->setDataNascimento($request->ano."-".$request->mes."-".$request->dia);
				   $usuario->getDataNascimento();
				   $mapper->update($usuario);
				   return $this->_redirect("/usuario/conteudo/id/".$request->id);
				} else {
				   //preeencher formulario com os dados originais       
				}   
			}
				$usuario= new Usuario();
				$mapper= new UsuarioMapper();
				$mapper->find($request->id,$usuario);
				$this->view->form = $form->populate($usuario->toArray());	
		}
			
    }


    public function editarRelacoesAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
        $form = new Application_Form_UsuarioSobre();
			if ($request->id == $usuarioAuth->idUsuario) {	
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
               $usuario = new Usuario($form->getValues());
               $mapper = new UsuarioMapper();
               $mapper->updateRelacoes($usuario);
               return $this->_redirect("/usuario/conteudo/id/".$request->id);
           	} else {
               //preeencher formulario com os dados originais       
           	}   
        }
			$usuario= new Usuario();
			$mapper= new UsuarioMapper();
			$mapper->find($request->id,$usuario);
		    $this->view->form = $form->populate($usuario->toArray());	
			}
	
    }
    public function conteudoAction() {
        // action body
	
	
    }	
    public function comentarioAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }
    public function artistaAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function agenciaAction() {
        // action body

//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function autorAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function cidadeAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
	
    public function itemAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function eventoAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function festivalAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function generoMusicalAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	

    public function usuarioAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	

    public function sigoAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }	
    public function seguidoAction() {
        // action body
	
//publicidade
			$reservaPublicidade= new ReservaPublicidade();
			$mapper= new ReservaPublicidadeMapper();
			$mapper->find(2,$reservaPublicidade);
			//$this->view->reservaPublicidade = $reservaPublicidade;	
    }

    public function excluirAction() {
        // action body
        $this->view->id = $id; 
    }
	
/*---DELETAR RELAÇÕES---*/
    public function deletarRelUsuarioAgenciaAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioAgenciaMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }
    public function deletarRelUsuarioArtistaAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioArtistaMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }
    public function deletarRelUsuarioAutorAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioAutorMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }		
    public function deletarRelUsuarioCidadeAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioCidadeMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	
    public function deletarRelUsuarioItemAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioItemMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	

    public function deletarRelUsuarioEventoAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioEventoMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	

    public function deletarRelUsuarioFestivalAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioFestivalMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	

    public function deletarRelUsuarioTipoAutorAction() {
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioTipoAutorMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	

    public function deletarRelUsuarioUsuarioAction() {
		// aqui defini que será excluido apenas os usuarios que sao ligados pelo cadastrado
		// ele nao pode recusar os que decidem segui-lo
        // action body
        $request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
		if ($this->getRequest()) {
			$usuariosMap= new RelUsuarioUsuarioMapper();
			$usuariosDeletar = $usuariosMap->delete($usuarioAuth->getIdUsuario(),$request->id);
			return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);
        }
		    
    }	

	//2
	public function deletarUsuarioImagemAction() {
		// action body
		
		// Capturamos aqui o dados enviados via post
		$request = $this->getRequest();
		$usuarioAuth = Zend_Auth::getInstance()->getIdentity();	
			if ($request->idItem == $usuarioAuth->idUsuario) {	
		// Verifica se os dados do formulário são válidos
		if ($this->getRequest()) {
			$imgRelCPM = new RelCPMMapper();
			$imgRelCPM->deleteMidia($request->id);
			$imgIndiceMidia = new IndiceMidiaMapper();
			$imgIndiceMidia->delete($request->id);
			$img = new ImagemMapper();
			$img->delete($request->id);
	return $this->_redirect("/usuario/conteudo/id/".$usuarioAuth->idUsuario);		
		}
			}
		
	}

}
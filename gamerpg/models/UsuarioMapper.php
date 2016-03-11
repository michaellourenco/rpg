<?php

class UsuarioMapper
{
    protected $_dbTable;


    public function insert(Usuario $usuario)
    {
       $data = array(
            'idUsuario'   => $usuario->getIdUsuario(),
            'login' => $usuario->getLogin(),
            'senha' => $usuario->getSenha(),
            'fkGrupoUsuario' => $usuario->getFkGrupoUsuario(),
			'dataNascimento' => $usuario->getDataNascimento(),
			'nome' => $usuario->getNome(),
			'fr' => $usuario->getFr(),						
            'con' => $usuario->getCon(),
			'dx' => $usuario->getDx(),
            'cidade' => $usuario->getCidade(),
            'descricao' => $usuario->getDescricao(),

        );
       return $this->getDbTable()->insert($data);
    }

    public function update(Usuario $usuario) {
        $dataUsuario = array(
            'idUsuario'   => $usuario->getIdUsuario(),
            'login' => $usuario->getLogin(),
            'senha' => $usuario->getSenha(),
            'fkGrupoUsuario' => $usuario->getFkGrupoUsuario(),
			'dataNascimento' => $usuario->getDataNascimento(),
			'nome' => $usuario->getNome(),
			'fr' => $usuario->getFr(),						
            'con' => $usuario->getCon(),
			'dx' => $usuario->getDx(),
            'cidade' => $usuario->getCidade(),
            'descricao' => $usuario->getDescricao(),
			'genero' =>$usuario->getGenero(),
			'statusRelacionamento' =>$usuario->getStatusRelacionamento(),
			'frase' =>$usuario->getFrase(),
			'con2' =>$usuario->getCon2(),
			'con3' =>$usuario->getCon3(),
			'twitter' =>$usuario->getTwitter(),
			'facebook' =>$usuario->getFacebook(),
			'orkut' =>$usuario->getOrkut(),
			'flickr' =>$usuario->getFlickr(),
			'msn' =>$usuario->getMsn(),


        );
        $id = $usuario->getIdUsuario();
        $this->getDbTable()->update($dataUsuario, array('idUsuario = ?' => $id));


    }
    public function updateRelacoes(Usuario $usuario) {
        $dataUsuario = array(
            'idUsuario'   => $usuario->getIdUsuario(),
			'fr' => $usuario->getFr(),						
            'con' => $usuario->getCon(),
			'dx' => $usuario->getDx(),
            'cidade' => $usuario->getCidade(),
            'descricao' => $usuario->getDescricao(),
			'genero' =>$usuario->getGenero(),
			'statusRelacionamento' =>$usuario->getStatusRelacionamento(),
			'frase' =>$usuario->getFrase(),
			'con2' =>$usuario->getCon2(),
			'con3' =>$usuario->getCon3(),
			'twitter' =>$usuario->getTwitter(),
			'facebook' =>$usuario->getFacebook(),
			'orkut' =>$usuario->getOrkut(),
			'flickr' =>$usuario->getFlickr(),
			'msn' =>$usuario->getMsn(),


        );
        $id = $usuario->getIdUsuario();
        $this->getDbTable()->update($dataUsuario, array('idUsuario = ?' => $id));


    }


    public function find($id, Usuario $usuario)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $usuario->setIdUsuario($row->idUsuario)
                  ->setLogin($row->login)
                  ->setSenha($row->senha)
                  ->setFkGrupoUsuario($row->fkGrupoUsuario)
                  ->setDataNascimento($row->dataNascimento)				  				  				  
                  ->setNome($row->nome)				  			  				  				  
                  ->setFr($row->fr)				  
                  ->setCon($row->con)
                  ->setDx($row->dx)
                  ->setCidade($row->cidade)
                  ->setDescricao($row->descricao)
					->setGenero($row->genero)
					->setStatusRelacionamento($row->statusRelacionamento)
					->setFrase($row->frase)
					->setCon2($row->con2)
					->setCon3($row->con3)
					->setTwitter($row->twitter)
					->setFacebook($row->facebook)
					->setOrkut($row->orkut)
					->setFlickr($row->flickr)
					->setMsn($row->msn);
    }
	
    public function fetchPairs()
		{		
			$db     = Zend_Db_Table::getDefaultAdapter();		
			$select = $db->select()->from('Usuario', array(
				'idUsuario',
				'nome',
			));
			return $db->fetchPairs($select);
		}

    public function fetchControlado($where,$order)
    {
        $resultSet = $this->getDbTable()->fetchAll($where,$order);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Usuario();
            $entry->setIdUsuario($row->idUsuario)
                  ->setLogin($row->login)
                  ->setSenha($row->senha)
                  ->setCon($row->con)
                  ->setFkGrupoUsuario($row->fkGrupoUsuario)	
                  ->setDataNascimento($row->dataNascimento)					  	  				  				  
                  ->setNome($row->nome)				  			  				  				  
                  ->setFr($row->fr)				  
                  ->setDx($row->dx)
                  ->setCidade($row->cidade)
                  ->setDescricao($row->descricao)
					->setGenero($row->genero)
					->setStatusRelacionamento($row->statusRelacionamento)
					->setFrase($row->frase)
					->setCon2($row->con2)
					->setCon3($row->con3)
					->setTwitter($row->twitter)
					->setFacebook($row->facebook)
					->setOrkut($row->orkut)
					->setFlickr($row->flickr)
					->setMsn($row->msn);
				  
            $entries[] = $entry;
        }
 
        return $entries;
    }
  
    public function fetchAll($param=null)
    {
        $resultSet = $this->getDbTable()->fetchAll($param);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Usuario();
            $entry->setIdUsuario($row->idUsuario);
            $entry->setLogin($row->login);
            $entry->setSenha($row->senha);
            $entry->setCon($row->con);
            $entry->setFkGrupoUsuario($row->fkGrupoUsuario);
            $entry->setDataNascimento($row->dataNascimento);
            $entry->setNome($row->nome);
            $entry->setFr($row->fr);
            $entry->setDx($row->dx);
            $entry->setCidade($row->cidade);
            $entry->setDescricao($row->descricao);
			$entry->setGenero($row->genero);
			$entry->setStatusRelacionamento($row->statusRelacionamento);
			$entry->setFrase($row->frase);
			$entry->setCon2($row->con2);
			$entry->setCon3($row->con3);
			$entry->setTwitter($row->twitter);
			$entry->setFacebook($row->facebook);
			$entry->setOrkut($row->orkut);
			$entry->setFlickr($row->flickr);
			$entry->setMsn($row->msn);

            $entries[] = $entry;
        }
 
        return $entries;
    }




}

<?php

class PersonagemMapper
{
    protected $_dbTable;

    public function insert(Personagem $personagem)
    {
       $inteligencia = array(
        'idPersonagem'   => $personagem->getIdPersonagem(),
        'con' => $personagem->getCon(),
        'inteligencia' => $personagem->getInteligencia(),
        'sab' => $personagem->getSab(),						
        'titulo' => $personagem->getTitulo(),
        'fr' => $personagem->getFr(),
        'dx' => $personagem->getDx(),			
        'hp' => $personagem->getHp(),
        'energia' => $personagem->getEnergia(),						
        'mana' => $personagem->getMana(),
        'fa' => $personagem->getFa(),
        'fd' => $personagem->getFd(),
        'dinheiro' => $personagem->getDinheiro(),	
      );
       return $this->getDbTable()->insert($inteligencia);
    }

    public function update(Personagem $personagem) {
        $inteligencia = array(
          'idPersonagem'   => $personagem->getIdPersonagem(),
          'con' => $personagem->getCon(),
          'inteligencia' => $personagem->getInteligencia(),
          'sab' => $personagem->getSab(),						
          'titulo' => $personagem->getTitulo(),
          'fr' => $personagem->getFr(),
          'dx' => $personagem->getDx(),
          'hp' => $personagem->getHp(),
          'energia' => $personagem->getEnergia(),						
          'mana' => $personagem->getMana(),
          'fa' => $personagem->getFa(),
          'fd' => $personagem->getFd(),
          'dinheiro' => $personagem->getDinheiro(),	
        );
        $id = $personagem->getIdPersonagem();
        $this->getDbTable()->update($inteligencia, array('idPersonagem = ?' => $id));
    }



    public function find($id, Personagem $personagem)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $personagem->setIdPersonagem($row->idPersonagem)
                  ->setTitulo($row->titulo)			  				  				  
                  ->setCon($row->con)				  
                  ->setInteligencia($row->inteligencia)				  				  				  
                  ->setSab($row->sab)				  
                  ->setFr($row->fr)
                  ->setDx($row->dx)				  				  				  
                  ->setHp($row->hp)				  
                  ->setEnergia($row->energia)				  				  				  
                  ->setMana($row->mana)				  
                  ->setFa($row->fa)
                  ->setFd($row->fd)
                  ->setDinheiro($row->dinheiro);	
	}
	
    public function fetchPairs()
		{		
			$db     = Zend_Db_Table::getDefaultAdapter();		
			$select = $db->select()->from('Personagem', array(
				'idPersonagem',
				'titulo',
			))
			->order('titulo asc');
			return $db->fetchPairs($select);
		}
 
     public function fetchControlado($where,$order)
    {
        $resultSet = $this->getDbTable()->fetchAll($where,$order);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Personagem();
            $entry->setIdPersonagem($row->idPersonagem)
                  ->setTitulo($row->titulo)			  				  				  
                  ->setCon($row->con)				  
                  ->setInteligencia($row->inteligencia)				  				  				  
                  ->setSab($row->sab)				  
                  ->setFr($row->fr)
                  ->setDx($row->dx)		  				  				  
                  ->setHp($row->hp)				  
                  ->setEnergia($row->energia)				  				  				  
                  ->setMana($row->mana)				  
                  ->setFa($row->fa)
                  ->setFd($row->fd)
                  ->setDinheiro($row->dinheiro);					                     
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll($param=null)
    {
        $resultSet = $this->getDbTable()->fetchAll($param);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Personagem();
            $entry->setIdPersonagem($row->idPersonagem)
                  ->setTitulo($row->titulo)			  				  				  
                  ->setCon($row->con)				  
                  ->setInteligencia($row->inteligencia)				  				  				  
                  ->setSab($row->sab)				  
                  ->setFr($row->fr)
                  ->setDx($row->dx)			  				  				  
                  ->setHp($row->hp)				  
                  ->setEnergia($row->energia)				  				  				  
                  ->setMana($row->mana)				  
                  ->setFa($row->fa)
                  ->setFd($row->fd)
                  ->setDinheiro($row->dinheiro);					                    
            $entries[] = $entry;
        }
        return $entries;
    }



}

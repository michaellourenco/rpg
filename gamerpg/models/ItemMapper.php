<?php

class ItemMapper
{


    public function insert(Item $item)
    {
       $inteligencia = array(
            'idItem'   => $item->getIdItem(),
			'con' => $item->getCon(),
			'inteligencia' => $item->getInteligencia(),
			'sab' => $item->getSab(),						
            'titulo' => $item->getTitulo(),
			'fr' => $item->getFr(),
            'dx' => $item->getDx(),			
			'hp' => $item->getHp(),
			'energia' => $item->getEnergia(),						
            'mana' => $item->getMana(),
			'fa' => $item->getFa(),
            'fd' => $item->getFd(),
            'preco' => $item->getPreco(),	
        );
       return $this->getDbTable()->insert($inteligencia);
    }

    public function update(Item $item) {
        $inteligencia = array(
            'idItem'   => $item->getIdItem(),
			'con' => $item->getCon(),
			'inteligencia' => $item->getInteligencia(),
			'sab' => $item->getSab(),						
            'titulo' => $item->getTitulo(),
			'fr' => $item->getFr(),
            'dx' => $item->getDx(),
			'hp' => $item->getHp(),
			'energia' => $item->getEnergia(),						
            'mana' => $item->getMana(),
			'fa' => $item->getFa(),
            'fd' => $item->getFd(),
            'preco' => $item->getPreco(),	
        );
        $id = $item->getIdItem();
        $this->getDbTable()->update($inteligencia, array('idItem = ?' => $id));


    }



    public function find($id, Item $item)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $item->setIdItem($row->idItem)
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
                  ->setPreco($row->preco);	
	}
	
    public function fetchPairs()
		{		
			$db     = Zend_Db_Table::getDefaultAdapter();		
			$select = $db->select()->from('Item', array(
				'idItem',
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
            $entry = new Item();
            $entry->setIdItem($row->idItem)
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
                  ->setPreco($row->preco);					                     
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll($param=null)
    {
        $resultSet = $this->getDbTable()->fetchAll($param);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Item();
            $entry->setIdItem($row->idItem)
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
                  ->setPreco($row->preco);					                    
            $entries[] = $entry;
        }
        return $entries;
    }


    public function dbSelect(array $query) {//esta array sao os parametros

        $select = $this->getDbTable()->select();
        foreach ($query as $command => $criterio) {
            $select->$command($criterio);

        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Item($row->toArray());//esta linha deve ser alterada de acordo com a classe ex.:Cidade, Evento
            //esta maneira tambem pode ser usada nos outros metodos, ou seja , passar o $row->toArray() como parametro no construtor
            // ao inves de fazer todos os sets um por um. 
            $entries[] = $entry;
        }
        return $entries;
    }


}

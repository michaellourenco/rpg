<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
		
    }

    public function indexAction()
    {
			// desabilitando layout
			$this->_helper->layout->disableLayout();
			//habilitando layout 2
			$this->_helper->layout->setLayout('layout-index');
			$categoria = new Categoria();
			$mapperCategoria = new CategoriaMapper();
			$selectCategoria = $mapperCategoria->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			$selectCategoria->where("fkCategoriaPai = 0");
			$this->view->categorias = $mapperCategoria->fetchAll($selectCategoria);	
		
    }

    public function homeAction()
    { 
        // action body
		   
			$mapperAgenda= new EventoMapper();
			$selectMaisEventos = $mapperAgenda->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			$selectMaisEventos->setIntegrityCheck(false);
			$selectMaisEventos->join('RelCPM', 'RelCPM.fkCanal=Evento.idEvento');
			$selectMaisEventos->where("Evento.dataEvento>= NOW()");
			
			$selectMaisEventos->where("RelCPM.fkPosicao='31'");
			$selectMaisEventos->limit('3','0');
			$selectMaisEventos->order('RAND()');
			$this->view->listaAgenda = $mapperAgenda->fetchAll($selectMaisEventos);		
					
    }

    public function viewAction(){
	}
	
	public function calendarioAction(){
	}

}


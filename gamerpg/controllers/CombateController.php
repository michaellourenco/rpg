<?php

class CombateController extends Zend_Controller_Action {

    public function init() {

 	       $request = $this->getRequest();


    }
    public function indexAction() {
			
			$p = new Personagem();
			$pMapper = new PersonagemMapper();
			$pMapper->find(1,$p);
	
			$px = new Personagem();
			$pxMapper = new PersonagemMapper();
			$pxMapper->find(2,$px);		
			
			$combate = new Combate();
			//$ini = $combate->iniciativa($p1->getIdPersonagem(),$p2->getIdPersonagem());
			$combate->iniciativa($p,$px);
    }


}
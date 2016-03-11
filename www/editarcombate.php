<?php
		$data = file_get_contents("php://input");
		$item = json_decode($data);
		$namespace = $item->namespace;

		$arquivo = "combates/".$namespace.".phtml";


$dataarquivo = file_get_contents("combates/".$namespace.".phtml");


$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"");
		$texto='';
		$texto.=$data;
		$texto.='';

 fwrite($ponteiro, $texto);		

?>
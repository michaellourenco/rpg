<?php
		$data = file_get_contents("php://input");
		$item = json_decode($data);
		$namespace = $item->namespace;

		$arquivo = "jogadores/".$namespace.".phtml";


$dataarquivo = file_get_contents("jogadores/".$namespace.".phtml");


$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"");
		$texto='';
		$texto.=$data;
		$texto.='';

 fwrite($ponteiro, $texto);		

?>
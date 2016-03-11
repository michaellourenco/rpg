<?php
		$data = file_get_contents("php://input");
		


$arquivo = "localcardapio.php";
$dataarquivo = file_get_contents("localcardapio.php");


$ponteiro = fopen($arquivo, "w");	
		fwrite($ponteiro,"");
		$texto='{"cardapios":';
		$texto.=$data;
		$texto.='}';

 fwrite($ponteiro, $texto);		

?>
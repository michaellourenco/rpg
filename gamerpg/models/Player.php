<?php
class Player{

	public static function play($canal){
		if ($canal instanceof Imagem){
			$cod_html = "<img src='http://guiadodia.com.br/img/".$canal->getCaminho()."'/>";
		}
		else if($canal instanceof Video){
			$cod_html = "<video src='".$canal->getCaminho()."'  />";		
		}
		else if($canal instanceof Audio){
			$cod_html = "<audio src='".$canal->getCaminho()."'  />";
		}
		else if($canal instanceof Artigo){
			$cod_html = "$canal->getDescricao()";
		}				
		else if($canal instanceof Comentario){
			$cod_html = $canal->getDescricao();
		}
		return $cod_html;
	}

}

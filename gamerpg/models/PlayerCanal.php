<?php
class PlayerCanal{

	public static function play($canal){
		if ($canal instanceof Agencia){
			$cod_html = "<a href='/agencia/conteudo/id/".$canal->getIdAgencia()."'>".$canal->getTitulo()."</a>";
		}
		else if($canal instanceof Artista){
			$cod_html = "<a href='/artista/conteudo/id/".$canal->getIdArtista()."'>".$canal->getTitulo()."</a>";
		}
		else if($canal instanceof Autor){
			$cod_html = "<a href='/autor/conteudo/id/".$canal->getIdAutor()."'>".$canal->getTitulo()."</a>";
		}				
		else if($canal instanceof Cidade){
			$cod_html = "<a href='/cidade/conteudo/id/".$canal->getIdCidade()."'>".$canal->getTitulo()."</a>";
		}
		else if($canal instanceof Estado){
			$cod_html = "<a href='/estado/conteudo/id/".$canal->getIdEstado()."'>".$canal->getTitulo()."</a>";
		}
		else if($canal instanceof Item){
			$cod_html = "<a href='/item/conteudo/id/".$canal->getIdItem()."'>".$canal->getTitulo()."</a>";
		}		
		else if($canal instanceof Evento){
			$cod_html = "<a href='/evento/conteudo/id/".$canal->getIdEvento()."'>".$canal->getTitulo()."</a>";
		}
		else if($canal instanceof Festival){
			$cod_html = "<a href='/festival/conteudo/id/".$canal->getIdFestival()."'>".$canal->getTitulo()."</a>";
		}
		return $cod_html;
	}

}

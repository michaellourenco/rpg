<?php

class Combate
{

	public function iniciativa(Personagem $p1,Personagem $p2){

		if($p1->iniciativa() > $p2->iniciativa()){
			echo"Iniciativa vencida por <strong>".$p1->getTitulo()."</strong><br/>";
			return Combate::turno(0,$p1,$p2);
		}else{
			echo"Iniciativa vencida por <strong>".$p2->getTitulo()."</strong><br/>";
			return Combate::turno(0,$p2,$p1);				
		}						

    }	

	public function turno($i,Personagem $p1,Personagem $p2){
	$pv=$p2->getHp();
	$pa=$p2->getHp();	
	
		if($p1->fa()>$p2->fd()){	
			$dano=$p1->atacar();
			$def=$p2->defender();
			$danoTotal=$dano-$def;
			if($danoTotal > 0){
				$danoI = $danoTotal;
				$pv -=$danoI;
			}
			else{
				$danoI=1;
				$pv -=$danoI;
			}
			if($pv <= 0){
				$p2->setHp($pv);
				echo "<p>TURNO ".$i++." | ";
				echo "ATK ".$dano;
				echo " | DEF ".$def;
				echo " =  ".$danoTotal." de dano<br/>";				
				
				echo "<strong>".$p1->getTitulo()."</strong> atacou e inflingiu <strong>".$danoI."</strong> de dano em <strong>".$p2->getTitulo()."</strong> que tinha <strong>".$pa."</strong><br/>";
				echo "<strong>".$p2->getTitulo()."</strong> perdeu pois ficou com <strong>".$p2->getHp()."</strong> pontos de vida <br/>";	
				echo "PARABENS <strong>".$p1->getTitulo()."</strong> VOCE VENCEU!</p>";
			}else if($pv > 0){
				$p2->setHp($pv);
				echo "<p>TURNO ".$i++." | ";
				echo "ATK ".$dano;
				echo " | DEF ".$def;
				echo " =  ".$danoTotal." de dano<br/>";				

				echo "<strong>".$p1->getTitulo()."</strong> atacou e inflingiu <strong>".$danoI."</strong> de dano em <strong>".$p2->getTitulo()."</strong> que tinha <strong>".$pa."</strong><br/>";
				echo "Agora <strong>".$p2->getTitulo()."</strong> tem <strong>".$p2->getHp()."</strong> pontos de vida restantes</p><br/>";
				return Combate::turno($i,$p2,$p1);
			}

		}
		else{
			echo "<p>TURNO ".$i++." | ";
			echo "<strong>".$p1->getTitulo()."</strong> errou o ataque</p>";
			return Combate::turno($i,$p2,$p1);
			
		}
		
	}	
			
}


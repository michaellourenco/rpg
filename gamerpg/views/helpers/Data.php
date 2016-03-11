<?php
/*
 * Helper que retorna o uma data em vários formatos diferentes.
 * ex: echo $this->Data('2009-18-11')->extenso;
 * ex: echo $this->Data('2009-18-11')->pt_br;
 * ex: echo $this->Data('2009-18-11 09:11:00')->hora;
 * @author Nivaldo Arruda - nivaldo@gmail.com
 * @see www.nivaldoarruda.com.br
 * @version 1.0
*/
class Zend_View_Helper_Data extends Zend_View_Helper_Abstract
{
	
    public $extenso;
    public $pt_br;
    public $hora;
 
    public function data($data)
  {
	  
        list($ano, $mes, $dia) = explode("-", substr($data, 0, 10));

        $this->extenso = $this->diasemana("$ano-$mes-$dia");
        $this->extenso_sub = $this->diasemana_subdividido("$ano-$mes-$dia");
		$this->mes_extenso = $this->mes_extenso("$ano-$mes-$dia");
		$this->proximo_mes = $this->mes_extenso("$ano-$mes-$dia");		
		$this->mes_extenso_sub = $this->mes_extenso_sub("$ano-$mes-$dia");		
        $this->pt_br = "$dia/$mes/$ano";
		$this->pt_br_dia_mes = "$dia/$mes";		
		$this->pt_br_ano = "$ano";
		$this->pt_br_mes = "$mes";		
		$this->pt_br_prox_mes = $this->proximo_mes("$ano-$mes-$dia");
		$this->pt_br_ant_mes =$this->mes_anterior("$ano-$mes-$dia");		
		$this->pt_br_dia = "$dia";
 
        if(strlen($data)>10){
            list($hora, $minuto, $segundo) = explode(":", substr($data, 11, 8));
            $this->hora = "$hora:$minuto:$segundo";
        }
 
        return $this;
    }
 
    /**
     * Retorna o dia da semana, por extenso e em português, correspondente
     * a data informada por parametro (no padrão aaaa-mm-dd).
     *
    * @param Date $data
     * @return String
    */
    public function diasemana($data){
        list($ano, $mes, $dia) = explode("-", $data);
 
        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
 
        switch($diasemana) {
            case 0: $diasemana = "Domingo";
                    break;
            case 1: $diasemana = "Segunda-Feira";
                    break;
            case 2: $diasemana = "Terça-Feira";
                    break;
            case 3: $diasemana = "Quarta-Feira";
                    break;
            case 4: $diasemana = "Quinta-Feira";
                    break;
            case 5: $diasemana = "Sexta-Feira";
                   break;
            case 6: $diasemana = "Sábado";
                    break;
        }
 
        return $diasemana;
 
    }
    public function diasemana_subdividido($data){
        list($ano, $mes, $dia) = explode("-", $data);
 
        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
 
        switch($diasemana) {
            case 0: $diasemana = "dom";
                    break;
            case 1: $diasemana = "seg";
                    break;
            case 2: $diasemana = "ter";
                    break;
            case 3: $diasemana = "qua";
                    break;
            case 4: $diasemana = "qui";
                    break;
            case 5: $diasemana = "sex";
                   break;
            case 6: $diasemana = "sab";
                    break;
        }
 
        return $diasemana;
 
    }
    public function mes_anterior($data){
        list($ano, $mes, $dia) = explode("-", $data);
 
        $mesAnterior = date("Y-m-d", mktime(0, 0, 0, $mes-1, $dia, $ano));
		return $mesAnterior;
	}

    public function proximo_mes($data){
        list($ano, $mes, $dia) = explode("-", $data);
 
        $mesAnterior = date("Y-m-d", mktime(0, 0, 0, $mes+1, $dia, $ano));
		return $mesAnterior;
	}	/*
	
	SINTAXE:
	echo mes_extenso(); //retornará mês corrente por extenso
	echo mes_extenso(6); //retornará Junho
	
	*/

	function mes_extenso($data = NULL)
	{
        list($ano, $mes, $dia) = explode("-", $data);
 
        $mesAnteriorRecebido = date('Y-m-d', mktime(0, 0, 0, $mes, $dia, $ano));		
		// leitura das datas
		$diaRecebido = date('d', mktime(0, 0, 0, $mes, $dia, $ano));
		$mesRecebido = date('m', mktime(0, 0, 0, $mes, $dia, $ano));
		$anoRecebido = date('Y', mktime(0, 0, 0, $mes, $dia, $ano));
		$semanaRecebida =date('w', mktime(0, 0, 0, $mes, $dia, $ano));
		// configuração mes
		switch ($mesRecebido){
		
		case 1: $mesRecebido = "janeiro"; break;
		case 2: $mesRecebido = "fevereiro"; break;
		case 3: $mesRecebido = "março"; break;
		case 4: $mesRecebido = "abril"; break;
		case 5: $mesRecebido = "maio"; break;
		case 6: $mesRecebido = "junho"; break;
		case 7: $mesRecebido = "julho"; break;
		case 8: $mesRecebido = "agosto"; break;
		case 9: $mesRecebido = "setembro"; break;
		case 10: $mesRecebido = "outubro"; break;
		case 11: $mesRecebido = "novembro"; break;
		case 12: $mesRecebido = "dezembro"; break;
		
		}
		return $mesRecebido;

	}
	function mes_extenso_sub($data = NULL)
	{
        list($ano, $mes, $dia) = explode("-", $data);
 
        $mesAnteriorRecebido = date('Y-m-d', mktime(0, 0, 0, $mes, $dia, $ano));		
		// leitura das datas
		$diaRecebido = date('d', mktime(0, 0, 0, $mes, $dia, $ano));
		$mesRecebido = date('m', mktime(0, 0, 0, $mes, $dia, $ano));
		$anoRecebido = date('Y', mktime(0, 0, 0, $mes, $dia, $ano));
		$semanaRecebida =date('w', mktime(0, 0, 0, $mes, $dia, $ano));
		// configuração mes
		switch ($mesRecebido){
		
		case 1: $mesRecebido = "jan"; break;
		case 2: $mesRecebido = "fev"; break;
		case 3: $mesRecebido = "mar"; break;
		case 4: $mesRecebido = "abr"; break;
		case 5: $mesRecebido = "mai"; break;
		case 6: $mesRecebido = "jun"; break;
		case 7: $mesRecebido = "jul"; break;
		case 8: $mesRecebido = "ago"; break;
		case 9: $mesRecebido = "set"; break;
		case 10: $mesRecebido = "out"; break;
		case 11: $mesRecebido = "nov"; break;
		case 12: $mesRecebido = "dez"; break;
		
		}
		return $mesRecebido;

	}
}
?>
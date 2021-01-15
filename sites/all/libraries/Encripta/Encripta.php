<?php
/**
 * Classe que codifica um array de vari�veis em um Hash String
 *  Esta clase foi melhorada para o uso de dados bin�rios
 *  Com essa modifica��o os �ndices dos arrays criptografados ser�o perdidos
 *
 * @author Marcelo Bur�gio - marceloburegio@gmail.com
 * @subpackage util
 * @version 3.0
 * @since 06/10/2008 17:45
 */
class Encripta {
	
	/**
	 * M�todo construtor da classe
	 * 
	 * @access private
	 */
	private function __construct() {
	}
	
	/**
	 * M�todo que converte um array em uma string codificada
	 *
	 * @access public
	 * @param mixed $mixVars
	 * @param string $strId
	 * @param int $intExpire=0
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function encode($mixVars, $strId, $intExpire=0, $bolIpSecurity=false) {
		/**
		 * FORMATO
		 * -------------------
		 * HASH|TIME|EXPIRE|VARS
		 * 16 bytes
		 * 4  bytes
		 * 4  bytes
		 * X  bytes (X = Bytes Vari�veis - Serializados com GZIP)
		 */
		$intTime = time();
		$strIp   = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
		
		// Serializando o array de forma mais econ�mica
		$strVars = "";
		if (is_array($mixVars)) {
			foreach ($mixVars as $strVar) {
				if (!empty($strVars)) $strVars .= chr(1);
				$strVars .= serialize($strVar);
			}
		}
		else $strVars = serialize($mixVars);
		
		// Comprime as vari�veis usando o GZip DEFLATE
		$binVars = gzdeflate($strVars);
		
		// Montando o hash de verifica��o
		$strHash = ' :#@$CSJDD9*%$@'. $strVars .'w :drw '. $intExpire .'DD9:'. $strId .'v422: '. $intTime .' 344a4'. $strIp .'32d';
		
		// Criando o hash completo (HASH|TIME|EXPIRE|VARS)
		return base64_encode(md5($strHash, true) . pack("NN", $intTime, $intExpire) . $binVars);
	}
	
	/**
	 * M�todo que converte uma string codificada no array que a gerou
	 * Esse m�todo pode retornar false caso n�o consiga converter
	 *
	 * @access public
	 * @param string $strHash
	 * @param string $strId
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function decode($strHash, $strId, $bolIpSecurity=false) {
		
		// Decodificando a string para bin�rio
		$binHash = base64_decode($strHash);
		
		// Verificando o tamanho m�nimo do hash
		if (strlen($binHash) > 24) {
			
			// Separando os elementos do hash
			$arrHash = unpack("H32md5/Ntime/Nexpire/A*vars", $binHash);
			
			// Descomprimindo as vari�veis usando o GZip INFLATE
			$strVars   = @gzinflate($arrHash["vars"]);
			$intExpire = $arrHash["expire"];
			$intTime   = $arrHash["time"];
			$strMd5    = $arrHash["md5"];
			$strIp     = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
			
			// Montando o hash de verifica��o
			$strHash = ' :#@$CSJDD9*%$@'. $strVars .'w :drw '. $intExpire .'DD9:'. $strId .'v422: '. $intTime .' 344a4'. $strIp .'32d';
			
			// Calculando o md5 novamente para valida��o da integridade da informa��o
			if (md5($strHash) == $strMd5) {
				
				// Verificando se o tempo de expira��o foi atingido
				if ($intExpire != 0 && ($intTime + $intExpire) < time()) return false;
				
				// Verificando se � um array com o separador
				if (strpos($strVars, chr(1)) !== false) {
					
					// Deserializando o array
					$mixVars = array();
					$arrVars = explode(chr(1), $strVars);
					foreach ($arrVars as $strVar) $mixVars[] = unserialize($strVar);
				}
				else $mixVars = unserialize($strVars);
				
				// Retornando a vari�vel
				return $mixVars;
			}
		}
		return false;
	}
	
}
?>
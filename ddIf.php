<?php
/**
 * @name ddIf.php
 * @version 1.1 (2012-04-05)
 * 
 * @desc This snippet compares different values and returns required chunk or string.
 * 
 * @uses The library modx.ddTools 0.10 (if additional data transfer is required).
 * 
 * @param operand1 {string} - The first operand for comparing. @required
 * @param operand2 {string} - The second operand for comparing. Default: ''.
 * @param operator {r; !r; b; m; mr; br; bool; inarray} - Comparing operator. Valid values: =(r), !=(!r), >(b), <(m), <=(mr), >=(br), bool, inarray. Default: 'r'.
 * @param trueString {string} - This string is returning if result is true. Default: ''.
 * @param falseString {string} - This string is returning if result is false. Default: ''.
 * @param trueChunk {string: chunkName} - This value is returning if result is true (chunk). Default: ''.
 * @param falseChunk {string: chunkName} - This value is returning if result is false (chunk). Default: ''.
 * @param placeholders {separated string} - Additional data which is required to transfer to chunk. It`s a string separating by '::' between key-value pair and '||' between pairs. Default: ''.
 * 
 * @link http://code.divandesign.biz/modx/ddif/1.1
 * 
 * @copyright 2012, DivanDesign
 * http://www.DivanDesign.biz
 */

//Если передано, что сравнивать
if (isset($operand1)){
	//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
	$operand2 = isset($operand2) ? $operand2 : '';
	
	//Булевое значение истинности сравнения
	$boolOut = '';
	//Выбираем сравнение в зависимости от оператора
	switch ($operator){
		case '!r':
			$boolOut = ($operand1 != $operand2) ? true : false;
		break;
		case 'b':
			$boolOut = ($operand1 > $operand2) ? true : false;
		break;
		case 'm':
			$boolOut = ($operand1 < $operand2) ? true : false;
		break;
		case 'br':
			$boolOut = ($operand1 >= $operand2) ? true : false;
		break;
		case 'mr':
			$boolOut = ($operand1 <= $operand2) ? true : false;
		break;
		case 'bool':
			$boolOut = ($operand1) ? true : false;
		break;
		case 'inarray':
			$operand2 = explode(',',$operand2);
			$boolOut = in_array($operand1, $operand2) ? true : false;
		break;
		case 'r':
		default:
			$boolOut = ($operand1 == $operand2) ? true : false;
	}
	
	$result = array();
	
	//Если есть дополнительные данные
	if (isset($placeholders)){
		//Подключаем modx.ddTools
		require_once $modx->config['base_path'].'assets/snippets/ddTools/modx.ddtools.class.php';
		
		//Разбиваем их
		$result = ddTools::explodeAssoc($placeholders);
	}
	
	//Если значение истино
	if($boolOut){
		//Возвращаем чанк или строку
		if(isset($trueChunk)){
			return $modx->parseChunk($trueChunk, $result, '[+','+]');
		}else{
			return isset($trueString) ? $trueString : '';
		}
	//Если значение ложно
	}else{
		//Возвращаем чанк или строку
		if(isset($falseChunk)){
			return $modx->parseChunk($falseChunk, $result, '[+','+]');
		}else{
			return isset($falseString) ? $falseString : '';
		}
	}
}
?>
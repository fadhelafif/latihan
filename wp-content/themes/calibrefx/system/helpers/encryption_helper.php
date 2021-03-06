<?php defined('CALIBREFX_URL') OR exit();
/**
 * CalibreFx Framework
 *
 * WordPress Themes Framework by CalibreFx Team
 *
 * @package     CalibreFx
 * @author      CalibreFx Team
 * @authorlink  http://www.calibrefx.com
 * @copyright   Copyright (c) 2012-2013, CalibreWorks. (http://www.calibreworks.com/)
 * @license     GNU GPL v2
 * @link        http://www.calibrefx.com
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This define the framework constants
 *
 * @package CalibreFx
 */

 
/**
 * Encryption Helper
 *
 * CalibreFx Encryption Helper Function
 *
 * @package		CalibreFx
 * @subpackage	Helper
 * @category	encryption helper
 * @author		CalibreFx Team
 * @link		http://www.calibreFx.com
 */
// ------------------------------------------------------------------------

/**
 * Reverseable Encryptor
 *
 * This is the encryptor function of 2 way encryption
 *
 * @param	string data to encrypt
 * @param	string secret hash key
 * @param	method encryption method
 * @return	string encrypted data
 */
function calibrefx_rev_encrypt($message, $key = '09cfb0c36eaa081', $chiper=MCRYPT_RIJNDAEL_256){
	global $calibrefx;
	$calibrefx->load->library('encrypt');
	
	if (empty($message) || empty($key)) {
		return null;
	}

	if (is_object($message))
		$message = (array) $message;

	$calibrefx->encrypt->set_cipher($chiper);

	if (is_array($message)) {
		$message = array_map(create_function('$key, $value', 'return $key.":".$value."|";'), array_keys($message), array_values($message));
		$message = implode($message);
	}

	return $calibrefx->encrypt->encode($message, $key);
}

/**
 * Reverseable Decryptor
 *
 * This is the decryptor function of 2 way encryption
 *
 * @param	string data to encrypt
 * @param	string secret hash key
 * @param	method encryption method
 * @return	string decrypted data
 */
function calibrefx_rev_decrypt($message, $key = '09cfb0c36eaa081', $chiper=MCRYPT_RIJNDAEL_256){
	global $calibrefx;
	$calibrefx->load->library('encrypt');

	if (empty($message) || empty($key)) {
		return null;
	}

	$calibrefx->encrypt->set_cipher($chiper);

	$decrypted_message = $calibrefx->encrypt->decode($message, $key);

	if (strpos($decrypted_message, '|') !== false) {
		$decrypted_message = explode('|', $decrypted_message);
		$temp_stack = array();
		foreach ($decrypted_message as $item) {
			$temp = explode(':', $item);
			if (count($temp) > 1) {
				$temp_stack[$temp[0]] = $temp[1];
			}
		}
		$decrypted_message = $temp_stack;
	}

	if ($decrypted_message)
		return $decrypted_message;
	else
		return $message; //if failed to decrypt then it probably not encrypted, return the original message
}
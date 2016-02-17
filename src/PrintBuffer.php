<?php
namespace Flypay\Escpos;

use Exception;

interface PrintBuffer {
	/**
	 * Cause the buffer to send any partial input and wait on a newline.
	 * If the printer is already on a new line, this does nothing.
	 */
	function flush();

	/**
	 * Used by Escpos to check if a printer is set.
	 */
	function getPrinter();

	/**
	 * Used by Escpos to hook up one-to-one link between buffers and printers.
	 * 
	 * @param Escpos $printer New printer
	 */
	function setPrinter(Escpos $printer = null);

	/**
	 * Accept UTF-8 text for printing.
	 * 
	 * @param string $text Text to print
	 */
	function writeText($text);

	/**
	 * Accept 8-bit text in the current encoding and add it to the buffer.
	 * 
	 * @param string $text Text to print, already the target encoding.
	 */
	function writeTextRaw($text);
}
?>
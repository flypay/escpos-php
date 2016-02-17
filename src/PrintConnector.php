<?php
namespace Flypay\Escpos;

use Exception;

interface PrintConnector {
	/**
	 * Print connectors should cause a NOTICE if they are deconstructed
	 * when they have not been finalized.
	 */
	public function __destruct();

	/**
	 * Finish using this print connector (close file, socket, send
	 * accumulated output, etc).
	 */
	public function finalize();

	/**
	 * @param string $data
	 * @return Data read from the printer, or false where reading is not possible.
	 */
	public function read($len);
	
	/**
	 * @param string $data
	 */
	public function write($data);
}

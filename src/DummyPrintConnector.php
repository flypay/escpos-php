<?php
namespace Flypay\Escpos;

use Exception;

final class DummyPrintConnector implements PrintConnector
{
    /**
     * @var array Buffer of accumilated data.
     */
    private $buffer;

    /**
     * @var string data which the printer will provide on next read
     */
    private $readData;

    /**
     * Create new print connector
     */
    public function __construct()
    {
        $this->buffer = array();
    }

    public function __destruct()
    {
        if ($this->buffer !== null) {
            trigger_error("Print connector was not finalized. Did you forget to close the printer?", E_USER_NOTICE);
        }
    }

    public function finalize()
    {
        $this->buffer = null;
    }

    /**
     * @return string Get the accumulated data that has been sent to this buffer.
     */
    public function getData()
    {
        return implode($this->buffer);
    }

    /* (non-PHPdoc)
     * @see PrintConnector::read()
     */
    public function read($len)
    {
        return $len >= strlen($this->readData) ? $this->readData : substr($this->readData, 0, $len);
    }

    public function write($data)
    {
        $this->buffer[] = $data;
    }
}

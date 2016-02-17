<?php
namespace Flypay\Escpos;

use Exception;

abstract class AbstractCapabilityProfile
{
    /**
     * Sub-classes must be retrieved via getInstance(), so that validation
     * can be attached to guarantee that dud profiles are not used on an Escpos object.
     */
    final protected function __construct()
    {
        // This space intentionally left blank.
    }

    /**
     * If getSupportedCodePages contains custom code pages, their character maps must be provided here.
     */
    abstract public function getCustomCodePages();

    /**
     * Return a map of code page numbers to names for this printer. Names
     * should match iconv code page names where possible (non-matching names will not be used).
     */
    abstract public function getSupportedCodePages();

    /**
     * True to support barcode "function b", false to use only function A.
     */
    abstract public function getSupportsBarcodeB();

    /**
     * True for bitImage support, false for no bitImage support.
     */
    abstract public function getSupportsBitImage();

    /**
     * True for graphics support, false for no graphics support.
     */
    abstract public function getSupportsGraphics();

    /**
     * True for 'STAR original' commands, false for standard ESC/POS only.
     */
    abstract public function getSupportsStarCommands();

    /**
     * True if the printer renders its own QR codes, false to send an image.
     */
    abstract public function getSupportsQrCode();

    /**
     * @return AbstractCapabilityProfile Instance of sub-class.
     */
    final public static function getInstance()
    {
        static $profile = null;
        if ($profile === null) {
            $profile = new static();
        }
        return $profile;
    }
}

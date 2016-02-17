<?php
namespace Flypay\Escpos;

use Exception;

class SimpleCapabilityProfile extends DefaultCapabilityProfile
{
    public function getSupportedCodePages()
    {
        /* Use only CP437 output */
        return array(0 => CodePage::CP437);
    }
    
    public function getSupportsGraphics()
    {
        /* Ask the driver to use bitImage wherever possible instead of graphics */
        return false;
    }
}

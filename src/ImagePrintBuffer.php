<?php
namespace Flypay\Escpos;

use Exception;

class ImagePrintBuffer implements PrintBuffer
{
    private $printer;
    
    public function __construct()
    {
        if (!EscposImage::isImagickLoaded()) {
            throw new Exception("ImagePrintBuffer requires the imagick extension");
        }
    }

    public function flush()
    {
        if ($this->printer == null) {
            throw new LogicException("Not attached to a printer.");
        }
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function setPrinter(Escpos $printer = null)
    {
        $this->printer = $printer;
    }

    public function writeText($text)
    {
        if ($this->printer == null) {
            throw new LogicException("Not attached to a printer.");
        }
        if ($text == null) {
            return;
        }
        $text = trim($text, "\n");
        /* Create Imagick objects */
        $image = new Imagick();
        $draw = new ImagickDraw();
        $color = new ImagickPixel('#000000');
        $background = new ImagickPixel('white');

        /* Create annotation */
        //$draw->setFont('Arial');// (not necessary?)
        $draw->setFontSize(24); // Size 21 looks good for FONT B
        $draw->setFillColor($color);
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);
        $metrics = $image->queryFontMetrics($draw, $text);
        $draw->annotation(0, $metrics['ascender'], $text);

        /* Create image & draw annotation on it */
        $image->newImage($metrics['textWidth'], $metrics['textHeight'], $background);
        $image->setImageFormat('png');
        $image->drawImage($draw);
        //$image->writeImage("test.png");

        /* Save image */
        $escposImage = new EscposImage();
        $escposImage->readImageFromImagick($image);
        $size = Escpos::IMG_DEFAULT;
        $this->printer->bitImage($escposImage, $size);
    }

    public function writeTextRaw($text)
    {
        if ($this->printer == null) {
            throw new LogicException("Not attached to a printer.");
        }
        $this->printer->getPrintConnector()->write($data);
    }
}

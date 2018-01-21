<?php
namespace weesee\pdflabel;

/**
 * PDFLabel
 * 
 */
use yii\base\Component;
use yii\helpers\Html;
use Uskur\PdfLabel\PdfLabel as BasePdfLabel;

class TCPDFLabel extends BasePdfLabel
{
    
	public function addExtendedHtmlLabel($html,$border=false)
    {
        list ($width, $height) = $this->newLabelPosition();
        $this->writeHTMLCell($width, $height, null, null, $html, $border, 0, false);
        //$this->writeHTMLCell($width, $height, null, null, $html);
    }
    
    public function addExtendedLabel($text,$border=false)
    {
        list ($width, $height) = $this->newLabelPosition();
        $this->MultiCell($width, $height, $text, $border, 'L');
    }
		
}
<?php

/**
 * TCPDFLabel
 *
 * @link https://github.com/WeeSee/yii2-pdflabel
 * @copyright Copyright (c) 2018 WeeSee
 * @license  https://github.com/WeeSee/yii2-pdflabel/blob/master/LICENSE
 */

namespace weesee\pdflabel;

use Uskur\PdfLabel\PdfLabel as BasePdfLabel;

/**
 * This is a proxy class for Uskur\PdfLabel\PdfLabel.
 * It is used to directly access TCPDF for setting borders.
 *
 * @author WeeSee <weesee@web.de>
 */
class TCPDFLabel extends BasePdfLabel
{
    /**
     * add one Label using HTML format
     * @param string $html
     * @param bool $border
     */
	public function addExtendedHtmlLabel($html,$border=false)
    {
        list ($width, $height) = $this->newLabelPosition();
        $this->writeHTMLCell($width, $height, null, null, $html, $border, 0, false);
    }
    
	/**
     * add one Label using plain text format
     * @param string $text
     * @param bool $border
     */
    public function addExtendedLabel($text,$border=false)
    {
        list ($width, $height) = $this->newLabelPosition();
        $this->MultiCell($width, $height, $text, $border, 'L');
    }
		
}
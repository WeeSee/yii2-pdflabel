<?php
namespace weesee\pdflabel;

/**
 * PDFLabel
 * 
 */
use yii\base\Component;
use yii\helpers\Html;
use Uskur\PdfLabel\PdfLabel as UskurPdfLabel;

class PdfLabel extends Component
{
	
	/* Output destination:
	 * I: send the file inline to the browser (default).
	 *    The plug-in is used if available.
	 *    The name given by name is used when one selects
	 *    the "Save as" option on the link generating the PDF.
	 * D: send to the browser and force a file download
	 *     with the name given by name.
	 * F: save to a local server file with the name given
	 *    by name.
	 * S: return the document as a string (name is ignored)
	 * FI: equivalent to F + I option
	 * FD: equivalent to F + D option
	 * E: return the document as base64 mime multi-part
	 *    email attachment (RFC 2045)
	 */
	const OUTPUT_BROWSER_INLINE = 'I';  
	const OUTPUT_BROWSER_DOWNLOAD = 'D';
	const OUTPUT_SAVE_FILE = 'F';
	const OUTPUT_STRING = 'S';
	const OUTPUT_SAVE_FILE_AND_BROWSER_INLINE = 'FI';
	const OUTPUT_SAVE_FILE_AND_BROWSER_DOWNLOAD = 'FD';
	const OUTPUT_BASE64 = 'E';
	
	public $font = 'times';
	public $size = 10;
	public $downloadFilename = "output.pdf";
	
	public $labels;

	protected $pdfLabel;
	
	public function init()
	{
		$this->pdfLabel = new UskurPdfLabel("5160");
		$this->pdfLabel->AddPage();
		$this->pdfLabel->SetFont($this->font, '', $this->size);
		if (is_array($this->labels))
			foreach($this->labels as $label)
				$this->addLabel($label);
	}
	
	public function addLabel($content)
	{
		$this->pdfLabel->addLabel($content);
	}
	
	public function render()
	{	
		$this->pdfLabel->Output($this->downloadFilename,self::OUTPUT_BROWSER_INLINE);
	}
}
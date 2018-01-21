<?php

/**
 * PDFLabel
 * 
 * @link https://github.com/WeeSee/yii2-pdflabel
 * @copyright Copyright (c) 2018 WeeSee
 * @license  https://github.com/WeeSee/yii2-pdflabel/blob/master/LICENSE
 */

namespace weesee\pdflabel;

use yii\base\Component;
use yii\helpers\Html;
use weesee\pdflabel\TCPDFLabel;

class PdfLabel extends Component
{
	
	/**
	 * Label name type to print labels on
	 * @var string
	 */
	public $labelName;
	
	/**
     * List of label formats extending Uskur/PdfLabel
     * The key is the label name
     * Use getLabelName() to get all labels
     *
     * @var array
     */
	const LABEL_FORMATS = [
		// define your own labels here
		/*
		'Avery 9999' => [
			'paper-size' => 'A4',
			'unit' => 'mm',
			'marginLeft' => 1.762,
			'marginTop' => 10.7,
			'NX' => 3,
			'NY' => 10,
			'SpaceX' => 3.175,
			'SpaceY' => 0,
			'width' => 66.675,
			'height' => 25.4
		],
		*/
	];
	
	/**
	 * Output destination:
	 * for details, see https://github.com/tecnickcom/TCPDF/blob/95c5938aafe4b20df1454dbddb3e5005c0b26f64/tcpdf.php#L7548
	 * @var string
	 */
	public $output = self::OUTPUT_BROWSER_INLINE;
	const OUTPUT_BROWSER_INLINE = 'I';  
	const OUTPUT_BROWSER_DOWNLOAD = 'D';
	const OUTPUT_SAVE_FILE = 'F';
	const OUTPUT_STRING = 'S';
	const OUTPUT_SAVE_FILE_AND_BROWSER_INLINE = 'FI';
	const OUTPUT_SAVE_FILE_AND_BROWSER_DOWNLOAD = 'FD';
	const OUTPUT_BASE64 = 'E';

	/*
	 * Filename is file is downloaded or saved
	 * @var string
	 */
	public $downloadFilename = "output.pdf";

	/**
	 * Font for label content
	 * For default fonts see https://tcpdf.org/docs/fonts/
	 * @var string 
	 */
	public $font = 'courier';
	
	/**
	 * Font size
	 * @var integer 
	 */
	public $size = 10;
	
	/**
	 * The number of empty labels to start with
	 * @var integer 
	 */
	public $offsetEmptyLabels;
	
	/**
	 * DataProvider for the models to print on labels.
	 * This property is required.
     * @var \yii\data\DataProviderInterface 
     */
	public $dataProvider;
	
	/**
	 * @var callable Closure to render one cell label
	 * The signature of the function should be the following:
	 *  `function ($model, $key, $index)`.
     * Where `$model`, `$key`, and `$index` refer to the model,
     * key and index of the label currently being rendered
     */
	public $renderLabel;
	
	/**
	 * @var string creator as meta data in PDF document
	 * false set Yii2 application name
	 */
	public $creator = false;
	
	/**
	 * @param bool $asHtml print $content with HTML tags
	 */
	public $asHtml = false;

	/**
	 * @var string author as meta data in PDF document
	 */
	public $author = 'weesee';
	
	/**
	 * @var string title as meta data in PDF document
	 */
	public $title = 'Labels';
	
	/**
	 * @var string subject as meta data in PDF document
	 */
	public $subject = 'Labels';
	
	/**
	 * @var string keywords as meta data in PDF document
	 */
	public $keywords = '';
	
	/**
	 * @var UskurPdfLabel Handle to access PfdfLabel
     */
	protected $pdfLabel;
	
	/**
	 * @var bool Print border to tes new label formats
     */
	public $border = false;
	
	
	/**
     * Initialize the class with options from user
     * The options are set using Yii2 init mechanism for Components
     * Options:
     * - labelType: string (e.g. "5160") or array with format spec
     * - font, size
     * - author, creator, title, keywords, subject: 
     * - offsetEmptyLabels: integer. How many labels to skip at the beginning
     */
	public function init()
	{
		parent::init();
		// user provides a custom label type
		if (is_array($this->labelName))
			$format = $this->labelName;
		// a lable type from this class?
		elseif (isset(self::LABEL_FORMATS[$this->labelName]))
			$format = self::LABEL_FORMATS[$this->labelName];
		// or a label type from PdfLabel class?
		elseif (isset(TCPDFLabel::LABELS[$this->labelName]))
			$format = $this->labelName; 
		else
			throw new \yii\base\InvalidConfigException('The "labelType" property must be set.');
	    if ($this->dataProvider === null) {
             throw new \yii\base\InvalidConfigException('The "dataProvider" property must be set.');
         }
	    if (!is_callable($this->renderLabel)) {
             throw new \yii\base\InvalidConfigException('The "renderLabel" property must be set.');
         }
	    $this->pdfLabel = new TCPDFLabel($format);
	    $this->pdfLabel->AddPage();
	    $this->pdfLabel->SetFont($this->font, '', $this->size);
	    $this->pdfLabel->SetCreator($this->creator?:\Yii::$app->name);
	    $this->pdfLabel->SetAuthor($this->author);
	    $this->pdfLabel->SetTitle($this->title);
	    $this->pdfLabel->SetSubject($this->subject);
	    $this->pdfLabel->SetKeywords($this->keywords);
		for ($i=$this->offsetEmptyLabels;$i>0;$i--)
			$this->addLabel('');
	}
	
	/**
     * Get all label formats
     * @param string $pageFormat the page format ('*','A4','letter')
     * @return array label format list
     */
	public static function getLabelNames($pageFormat="A4")
	{
		$labelNames = [];
		// Label names for PdfLabel-Library
		$pdfLabelNames = [
			'3422' => 'Avery 3422 (A4)',
			'5160' => 'Avery 5160 (letter)',
			'5161' => 'Avery 5161 (letter)',
			'5162' => 'Avery 5162 (letter)',
			'5163' => 'Avery 5163 (letter)',
			'5164' => 'Avery 5164 (letter)',
			'L7161' => 'Avery L7161 (A4)',
			'L7163' => 'Avery L7163 (A4)',
			'8600' => '8600  (letter)',
			'NewPrint4005' => '2x4 (A4)',
		];
		$allLabels = TCPDFLabel::LABELS + self::LABEL_FORMATS;
		foreach($allLabels as $name => $label) {
			if (!preg_match("/$pageFormat/",$label['paper-size']))
				continue;
			$newName = isset($pdfLabelNames[$name])
				? $pdfLabelNames[$name] : $name;
			$labelNames[$name] = $newName;
		}
		return $labelNames;
	}
	
	/**
     * Adds a new label 
     * @param string $content the content for the label. Lines can be 
     * separated by \n
     * IMPORTANT: The HTML must be well formatted - try to clean-up it using an
     * application like HTML-Tidy before submitting. Supported tags are: a, b,
     * blockquote, br, dd, del, div, dl, dt, em, font, h1, h2, h3, h4, h5, h6,
     * hr, i, img, li, ol, p, pre, small, span, strong, sub, sup, table,
     * tcpdf, td, th, thead, tr, tt, u, ul
     * NOTE: all the HTML attributes must be enclosed in double-quote.
     * @return object to concantenate as addlabel(...)->addLabel(...)
     */
	public function addLabel($content)
	{
		if ($this->asHtml)
			$this->pdfLabel->addExtendedHtmlLabel($content,$this->border);
		else
			$this->pdfLabel->addExtendedLabel($content,$this->border);
		return $this;
	}
	
	/**
     * Adds labels for all models from given dataProvider 
     */
	protected function renderModels()
	{
	   if ($this->dataProvider->count > 0) {
	   	$models = array_values($this->dataProvider->getModels());
	   	$keys = $this->dataProvider->getKeys();
	   	foreach ($models as $index => $model) {
			$key = $keys[$index];
			if (is_callable($this->renderLabel)) {
				$label = call_user_func($this->renderLabel, $model, $key, $index);
			} else
				$label = "";
			$this->pdfLabel->addLabel($label);
	   	}
	   }
	}

	/**
     * Renders the page with the all labels
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the rendered pdf as response object
     */
	public function render()
	{
	   if ($this->dataProvider)
	   	$this->renderModels();
	   return \Yii::$app->response->sendContentAsFile(
	   	$this->pdfLabel->Output('',self::OUTPUT_STRING),
	   	$this->downloadFilename,
	   	[
	   	   'inline' => true,
	   	   'mimeType' => 'application/pdf',
	   	]
	   );
	}
	
}
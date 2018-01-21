Yii2-PdfLabel
=============

Yii2 Widget to print labels on PDF

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist weesee/yii2-pdflabel "*"
```

or add

```
"weesee/yii2-pdflabel": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by:

View:

```php 
<?php
    echo Html::a("Download Label-PDF",['site/downloadpdf']);
?>
```

Controller:

    use weesee\pdflabel\PdfLabel;
    ...
    public function actionPdfLabelDownload()
    $pdfLabel = new PdfLabel([
        'labelType' => '5160',
        'dataProvider' => $labelDataProvider,
        'renderLabel' => function($model, $key, $index) {
            return $model["name"]."\n".$model["town"];
        },
    ]);
    return $pdfLabel->render();
        

Author & Licence
----------------

WeeSee <weesee@web.de>

GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007

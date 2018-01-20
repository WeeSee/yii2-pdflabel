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

Once the extension is installed, simply use it in your code by  :

```php 
<?php
    use weesee\pdflabel\PdfLabelWidget;

    echo Html::a("Label-PDF",PdfLabelWidget::widget([
        'labels' => ["hello world"],
    ]));
?>
```

Author & Licence
----------------

WeeSee <weesee@web.de>

GNU GENERAL PUBLIC LICENSE, Version 3, 29 June 2007

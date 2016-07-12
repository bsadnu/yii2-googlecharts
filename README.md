Google Charts Extension for Yii 2
===============================

[![Latest Stable Version](https://poser.pugx.org/bsadnu/yii2-googlecharts/v/stable)](https://packagist.org/packages/bsadnu/yii2-googlecharts) [![Total Downloads](https://poser.pugx.org/bsadnu/yii2-googlecharts/downloads)](https://packagist.org/packages/bsadnu/yii2-googlecharts) [![Latest Unstable Version](https://poser.pugx.org/bsadnu/yii2-googlecharts/v/unstable)](https://packagist.org/packages/bsadnu/yii2-googlecharts) [![License](https://poser.pugx.org/bsadnu/yii2-googlecharts/license)](https://packagist.org/packages/bsadnu/yii2-googlecharts)

This extension contains a lot of chart widgets based on [Google Charts API](https://developers.google.com/chart/).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bsadnu/yii2-googlecharts "*"
```

or add

```json
"bsadnu/yii2-googlecharts": "*"
```

to the require section of your composer.json.

Usage
-----

To use any of these widgets,  simply add the following code in your view.

### Column Chart Example
```php
...
use bsadnu\googlecharts\ColumnChart;
...
```

```php
<?= ColumnChart::widget([
    'id' => 'my-column-chart-id',
    'data' => [
        ['Year', 'Sales', 'Expenses'],
        ['2013',  1000,      400],
        ['2014',  1170,      460],
        ['2015',  660,       1120],
        ['2016',  1030,      540]
    ],
    'options' => [
        'fontName' => 'Verdana',
        'height' => 400,
        'fontSize' => 12,
        'chartArea' => [
        	'left' => '5%',
        	'width' => '90%',
        	'height' => 350
        ],
        'tooltip' => [
        	'textStyle' => [
        		'fontName' => 'Roboto',
        		'fontSize' => 13
        	]
        ],
        'vAxis' => [
        	'title' => 'Sales and Expenses',
        	'titleTextStyle' => [
        		'fontSize' => 13,
        		'italic' => false
        	],
        	'gridlines' => [
        		'color' => '#e5e5e5',
        		'count' => 10
        	],            	
        	'minValue' => 0
        ],
        'legend' => [
        	'position' => 'top',
        	'alignment' => 'center',
        	'textStyle' => [
        		'fontSize' => 12
        	]
        ]            
    ]
]) ?>
```

## License

**yii2-googlecharts** is released under the BSD 2-Clause License. See the bundled [LICENSE](https://github.com/bsadnu/yii2-googlecharts/blob/master/LICENSE) for details.

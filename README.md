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
Simple Column Chart

![demo](https://dl.dropboxusercontent.com/u/94373707/ColumnChartSimple.png)
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
        		'fontName' => 'Verdana',
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

Stacked Column Chart

![demo](https://dl.dropboxusercontent.com/u/94373707/ColumnChartStacked.png)
```php
<?= ColumnChart::widget([
	'id' => 'my-stacked-column-chart-id',
    'data' => [
		['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General', 'Western', 'Literature'],
		['2000', 20, 30, 35, 40, 45, 30],
		['2005', 14, 20, 25, 30, 48, 30],
		['2010', 10, 24, 20, 32, 18, 5],
		['2015', 15, 25, 30, 35, 20, 15],
		['2020', 16, 22, 23, 30, 16, 9],
		['2025', 12, 26, 20, 40, 20, 30],
		['2030', 28, 19, 29, 30, 12, 13]
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
        'isStacked' => true,
        'tooltip' => [
        	'textStyle' => [
        		'fontName' => 'Verdana',
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

### Bar Chart Example
```php
...
use bsadnu\googlecharts\BarChart;
...
```
Simple Bar Chart

![demo](https://dl.dropboxusercontent.com/u/94373707/BarChart.png)
```php
<?= BarChart::widget([
	'id' => 'my-bar-chart-id',
    'data' => [
        ['Year', 'Sales', 'Expenses'],
        ['2004',  1000,      400],
        ['2005',  1170,      460],
        ['2006',  660,       1120],
        ['2007',  1030,      540]
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
        		'fontName' => 'Verdana',
        		'fontSize' => 13
        	]
        ],
        'vAxis' => [
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

Stacked Bar Chart

![demo](https://dl.dropboxusercontent.com/u/94373707/BarChartStacked.png)
```php
<?= BarChart::widget([
	'id' => 'my-stacked-bar-chart-id',
    'data' => [
		['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General', 'Western', 'Literature'],
		['2000', 20, 30, 35, 40, 45, 30],
		['2005', 14, 20, 25, 30, 48, 30],
		['2010', 10, 24, 20, 32, 18, 5],
		['2015', 15, 25, 30, 35, 20, 15],
		['2020', 16, 22, 23, 30, 16, 9],
		['2025', 12, 26, 20, 40, 20, 30],
		['2030', 28, 19, 29, 30, 12, 13]
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
        'isStacked' => true,
        'tooltip' => [
        	'textStyle' => [
        		'fontName' => 'Verdana',
        		'fontSize' => 13
        	]
        ],
        'hAxis' => [
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

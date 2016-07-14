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
1) Simple Column Chart

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

2) Stacked Column Chart

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
1) Simple Bar Chart

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

2) Stacked Bar Chart

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

### Histogram Example
```php
...
use bsadnu\googlecharts\Histogram;
...
```
![demo](https://dl.dropboxusercontent.com/u/94373707/Histogram.png)
```php
<?= Histogram::widget([
	'id' => 'my-simple-histogram-id',
	'data' => [
		['Dinosaur', 'Length'],
		['Acrocanthosaurus (top-spined lizard)', 12.2],
		['Albertosaurus (Alberta lizard)', 9.1],
		['Allosaurus (other lizard)', 12.2],
		['Apatosaurus (deceptive lizard)', 22.9],
		['Archaeopteryx (ancient wing)', 0.9],
		['Argentinosaurus (Argentina lizard)', 36.6],
		['Baryonyx (heavy claws)', 9.1],
		['Brachiosaurus (arm lizard)', 30.5],
		['Ceratosaurus (horned lizard)', 6.1],
		['Coelophysis (hollow form)', 2.7],
		['Compsognathus (elegant jaw)', 0.9],
		['Deinonychus (terrible claw)', 2.7],
		['Diplodocus (double beam)', 27.1],
		['Dromicelomimus (emu mimic)', 3.4],
		['Gallimimus (fowl mimic)', 5.5],
		['Mamenchisaurus (Mamenchi lizard)', 21.0],
		['Megalosaurus (big lizard)', 7.9],
		['Microvenator (small hunter)', 1.2],
		['Ornithomimus (bird mimic)', 4.6],
		['Oviraptor (egg robber)', 1.5],
		['Plateosaurus (flat lizard)', 7.9],
		['Sauronithoides (narrow-clawed lizard)', 2.0],
		['Seismosaurus (tremor lizard)', 45.7],
		['Spinosaurus (spiny lizard)', 12.2],
		['Supersaurus (super lizard)', 30.5],
		['Tyrannosaurus (tyrant lizard)', 15.2],
		['Ultrasaurus (ultra lizard)', 30.5],
		['Velociraptor (swift robber)', 1.8]
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
	    	'title' => 'Dinosaur length',
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
	    'hAxis' => [
	    	'gridlines' => [
	    		'color' => '#e5e5e5'
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

### Combo Chart Example
```php
...
use bsadnu\googlecharts\ComboChart;
...
```
![demo](https://dl.dropboxusercontent.com/u/94373707/ComboChart.png)
```php
<?= ComboChart::widget([
	'id' => 'my-combo-chart-id',
	'data' => [
		['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
		['2004/05',  165,      938,         522,             998,           450,      614.6],
		['2005/06',  135,      1120,        599,             1268,          288,      682],
		['2006/07',  157,      1167,        587,             807,           397,      623],
		['2007/08',  139,      1110,        615,             968,           215,      609.4],
		['2008/09',  136,      691,         629,             1026,          366,      569.6]
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
	    'seriesType' => 'bars',
		'series' => [
			5 => [
				'type' => 'line',
				'pointSize' => 5
			]
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

## License

**yii2-googlecharts** is released under the BSD 2-Clause License. See the bundled [LICENSE](https://github.com/bsadnu/yii2-googlecharts/blob/master/LICENSE) for details.

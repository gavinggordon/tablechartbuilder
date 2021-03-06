# TableChartBuilder v1.0.6

[![Build Status](https://travis-ci.org/gavinggordon/tablechartbuilder.svg?branch=master)](https://travis-ci.org/gavinggordon/tablechartbuilder)

----------

## Description
This php class package allows you to create dynamic HTML tables that can calculate column data, like Excel, and look good doing it. Although it is compatible with CSS Bootstrap 3+, Bootstrap is not required for the resulting table to be both responsive, as well as styled beautifully.

### How to Use

#### Install
```
	$ composer require gavinggordon/tablechartbuilder
```

#### Autoload
``` php
	include( 'vendor/autoload.php' );
```

#### Insantiate
``` php
	$table = new GGG\Html\Builders\TableChartBuilder();
```

#### Configure
``` php
	$table->configure( [
		'title' => '',
		'headers' => [
			'Q1', 'Q2', 'Q3', 'Q4'
		],
		'data' => [
			[ 10000, 5000, 7500, 5000 ],
			[ 13000, 1600, 2500, 8000 ],
			[ 15000, 7400, 3600, 2500 ]
		],
		'equation' => [
			'total', 'average', 'lowest', 'highest'
		]
	] );
```

#### Render
``` php
	$html = $table->render();
	echo $html;
```

--------------

#### More Information

##### PHP Innovation Award

This [class](http://www.phpclasses.org/package/10069.html) has been awarded a PHP Innovation Award, provided by [PHPClasses.org](http://www.phpclasses.org). My other PHP classes are accessible online via my [GitHub profile](https://github.com/gavinggordon) or [PHPClasses.org profile](http://www.phpclasses.org/browse/author/1348645.html).

--------------
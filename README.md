# AdminUI plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require lubos/cakephp-admin-ui
```

Load plugin in bootstrap.php file

```
bin/cake plugin load AdminUI
```

## Usage

### Filters

Basic example

```
<?php
$this->Html->css('AdminUI.admin.min', ['block' => true]);
echo $this->element('AdminUI.filters', [
    'sort' => [
        ['name', 'Name A-Z', ['direction' => 'asc']],
        ['name', 'Name Z-A', ['direction' => 'desc']],
    ],
    'fields' => [
        'q' => [
            'placeholder' => 'Filter by title'
        ],
    ],
]); 
?>
```

## Bugs & Features

If you want to help, pull requests are welcome.  

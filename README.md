# Bitcms plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require gijsjager/bitcms
```

## Configurations

Copy the file `config/bitcms.example.php` to your local config directory and rename the file to 'bitcms.php'.
Adjust configurations like the modules need to to be loaded and more.

## Dashboard widgets
Create your own personal widget by adding a template too the following directory:
```php
# left wide column widget
templates/element/dashboard/wide.php
# right small column widget
templates/element/dashboard/small.php
```

## Content blocks
```
# Load items
[load ...]

# Load cell
[cell ...]
```

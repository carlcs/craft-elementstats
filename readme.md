# Element Stats widget for Craft CMS

![Element Stats](https://github.com/carlcs/craft-elementstats/blob/master/resources/screenshot.png)

## Installation

The plugin is available on Packagist and can be installed using Composer. You can also download the [latest release][0] and copy the files into craft/plugins/elementstats/.

```
$ composer require carlcs/craft-elementstats
```

## Configuration

To configure the plugin you need to create a file named elementstats.php in the craft/config/ folder. This is where you configure the stats available in your widgets.

Place all of your stats configurations in a nested array with the key `stats`. The configurations themselves have to be arrays with an unique array key which will be used to identify the stat. Within that array you can use the following stat config settings:

- **`name`** – What the stat will be called in the widget.
- **`link`** – Where the link in your widget will lead. The setting expects a Control Panel URI.
- **`elementType`** – What element type to fetch elements.
- **`criteria`** – An array of element criteria parameters used to filter the elements.
- **`dateColumn`** – What database column should be used for the time axis in the chart.
- **`total`** – Allows you to manually set the value returned to the widgets.
- **`numberFormat`** – How the value should be formatted in the widgets.

Element Stats widget comes with an [example configuration file][1] to give you a better idea of what types of data you can use and how to configure the stats configurations.

Here’s a very basic example:

```php
return [
    'stats' => [
        'all-entries' => [
            'name'        => 'All Entries',
            'link'        => 'entries',
            'elementType' => 'Entry',
        ],
        'sports-news' => [
            'name'        => 'Sports News',
            'link'        => 'entries/news',
            'elementType' => 'Entry',
            'criteria'    => [
                'section' => 'news',
                'type'    => 'sports',
            ],
        ],
    ],
];
```

## Requirements

- PHP 5.4 or later
- Craft CMS 2.6 or later


  [0]: https://github.com/carlcs/craft-elementstats/releases/latest
  [1]: _examples/

# Contao Progress Bar Widget Bundle

This bundle offers a dynamic progress bar widget for the Contao CMS.

## Features

- adds a progress bar widget (currently for the backend only)
- ajax support (self-auto-updating)

## Impressions

![The progress bar widget included in an example data container array](docs/img/widget.png "The progress bar widget included in an example data container array")

## Installation

1. Install via composer: `composer require heimrichhannot/contao-progress-bar-widget-bundle`.

## Usage

```php
'importProgress'                 => [
    'inputType' => 'huhProgressBar',
    'eval' => [
        'description' => $GLOBALS['TL_LANG']['tl_entity_import_config']['reference']['importProgressDescription'],
        'totalCountField' => 'importProgressTotal',
        'currentProgressField' => 'importProgressCurrent',
        'skippedField' => 'importProgressSkipped'
    ]
],
```

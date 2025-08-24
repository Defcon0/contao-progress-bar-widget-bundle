<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ProgressBarWidgetBundle\EventListener\Contao;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use HeimrichHannot\UtilsBundle\Util\Utils;

#[AsHook('loadDataContainer')]
class LoadDataContainerListener
{
    protected Utils $utils;

    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }

    public function __invoke(string $table): void
    {
        if ($this->utils->container()->isBackend()) {
            $GLOBALS['TL_CSS']['contao-progress-bar-widget-bundle-be'] = 'bundles/heimrichhannotprogressbarwidget/css/contao-progress-bar-widget-bundle-be.min.css|static';
            $GLOBALS['TL_JAVASCRIPT']['contao-progress-bar-widget-bundle'] = 'bundles/heimrichhannotprogressbarwidget/js/contao-progress-bar-widget-bundle-be.min.js|static';
        }
    }
}

<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\EntityImportBundle\Widget;

use Contao\System;
use Contao\Widget;

class ImportProgress extends Widget
{
    protected $blnForAttribute = true;
    protected $strTemplate = 'be_widget';

    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        $twig = System::getContainer()->get('twig');

        return $twig->render('@HeimrichHannotContaoEntityImport/widget/be_import_progress.html.twig');
    }
}

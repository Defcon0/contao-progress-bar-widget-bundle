<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ProgressBarWidgetBundle\Widget;

use Contao\Controller;
use Contao\Environment;
use Contao\System;
use Contao\Widget;
use HeimrichHannot\ProgressBarWidgetBundle\Controller\AjaxController;
use HeimrichHannot\UtilsBundle\Model\ModelUtil;
use HeimrichHannot\UtilsBundle\Url\UrlUtil;

class ProgressBar extends Widget
{
    const STATE_SUCCESS = 'success';
    const STATE_FAILED = 'failed';
    const STATE_IN_PROGRESS = 'in_progress';

    protected $blnForAttribute = true;
    protected $strTemplate = 'be_widget_chk'; // hide label

    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        $twig = System::getContainer()->get('twig');
        $modelUtil = System::getContainer()->get(ModelUtil::class);
        $urlUtil = System::getContainer()->get(UrlUtil::class);
        $framework = System::getContainer()->get('contao.framework');

        $framework->getAdapter(Controller::class)->loadDataContainer($this->strTable);

        if (null === ($record = $modelUtil->findModelInstanceByPk($this->strTable, $this->dataContainer->id))) {
            return 'No record found.';
        }

        $dcaEval = $GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField]['eval'];

        $data = array_replace($dcaEval, [
            'state' => static::STATE_IN_PROGRESS,
            'progressUrl' => $urlUtil->addQueryString('field='.$this->strField,
                Environment::get('url').sprintf(AjaxController::PROGRESS_URI, $this->strTable, $record->id)
            ),
            'currentProgress' => $record->{$dcaEval['currentProgressField']} ?: 0,
            'totalCount' => $record->{$dcaEval['totalCountField']} ?: 0,
            'skippedCount' => $record->{$dcaEval['skippedField']} ?: 0,
        ]);

        return $twig->render('@HeimrichHannotProgressBarWidget/widget/progress_bar.html.twig', $data);
    }
}

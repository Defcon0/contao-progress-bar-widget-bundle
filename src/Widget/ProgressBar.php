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
use HeimrichHannot\ProgressBarWidgetBundle\Event\LoadProgressEvent;
use HeimrichHannot\UtilsBundle\Model\ModelUtil;
use HeimrichHannot\UtilsBundle\Url\UrlUtil;
use HeimrichHannot\UtilsBundle\Util\Utils;

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
        $utils = System::getContainer()->get(Utils::class);
        $framework = System::getContainer()->get('contao.framework');
        $eventDispatcher = System::getContainer()->get('event_dispatcher');

        $framework->getAdapter(Controller::class)->loadDataContainer($this->strTable);

        if (null === ($record = $utils->model()->findModelInstanceByPk($this->strTable, $this->dataContainer->id))) {
            return 'No record found.';
        }

        $dcaEval = $GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField]['eval'];

        /** @var LoadProgressEvent $event */
        $event = $eventDispatcher->dispatch(new LoadProgressEvent([], $this->strTable, $this->dataContainer->id, [
            'field' => $this->strField,
        ]), LoadProgressEvent::NAME);

        $data = $event->getData();

        if (empty($data)) {
            $data = [
                'totalCount' => 100,
                'currentProgress' => 50,
                'skippedCount' => 1
            ];
        }

        $parameters = array_replace($dcaEval, [
            'state' => static::STATE_IN_PROGRESS,
            'progressUrl' => $utils->url()->addQueryStringParameterToUrl('field='.$this->strField,
                Environment::get('url').sprintf(AjaxController::PROGRESS_URI, $this->strTable, $record->id)
            ),
            'data' => $data,
        ]);

        return $twig->render('@HeimrichHannotProgressBarWidget/widget/progress_bar.html.twig', $parameters);
    }
}

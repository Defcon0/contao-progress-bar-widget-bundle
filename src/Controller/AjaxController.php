<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ProgressBarWidgetBundle\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use HeimrichHannot\ProgressBarWidgetBundle\Event\LoadProgressEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route(defaults={"_scope" = "frontend"})
 */
class AjaxController
{
    const PROGRESS_URI = '/huh_progress_bar_widget/progress/%s/%s';

    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @var ContaoFramework
     */
    private $framework;

    public function __construct(
        ContaoFramework $framework,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->framework = $framework;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Asynchronously load progress.
     *
     * @return Response
     *
     * @Route("/huh_progress_bar_widget/progress/{table}/{id}")
     */
    public function progressAction(Request $request, string $table, int $id)
    {
        $this->framework->initialize();

        $data = [];
        $options = [];

        if ($request->get('field')) {
            $options['field'] = $request->get('field');
        }

        /** @var LoadProgressEvent $event */
        $event = $this->eventDispatcher->dispatch(new LoadProgressEvent($data, $table, $id, $options), LoadProgressEvent::NAME);

        return new JsonResponse($event->getData());
    }
}

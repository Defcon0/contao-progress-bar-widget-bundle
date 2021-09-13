<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ProgressBarWidgetBundle\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use HeimrichHannot\UtilsBundle\Database\DatabaseUtil;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_scope" = "frontend"})
 */
class AjaxController
{
    protected ContaoFramework $framework;
    protected DatabaseUtil    $databaseUtil;

    public function __construct(ContaoFramework $framework, DatabaseUtil $databaseUtil)
    {
        $this->framework = $framework;
        $this->databaseUtil = $databaseUtil;
    }

    /**
     * @return Response
     *
     * @Route("/api/project")
     */
    public function projectAction(Request $request)
    {
        $this->framework->initialize();

        return new JsonResponse(
        );
    }
}

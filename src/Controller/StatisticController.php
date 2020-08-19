<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ShortUrlRepository;
use App\Service\Statistic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic/short-url", methods={"POST"}, name="short_url")
     */
    public function getStatisticShortUrl(Request $request, ShortUrlRepository $shortUrlRepository): Response
    {
        $numVisit = (new Statistic($request, $shortUrlRepository))->getNumVisit();

        return new JsonResponse(['number_visit' => $numVisit]);
    }
}
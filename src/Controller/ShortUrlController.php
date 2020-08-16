<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api", name="api_")
 */
class ShortUrlController extends AbstractController
{
    /**
     * @Route("/short-url", methods={"POST"}, name="short_url")
     */
    public function generateShortUrl()
    {
        return new Response('api');
    }

    /**
     * @Route("/statistic", methods={"POST"}, name="statistic")
     */
    public function getStatistic()
    {
        return new Response('statistic');
    }
}
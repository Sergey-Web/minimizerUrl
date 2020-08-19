<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ShortUrlRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Statistic implements StatisticInterface
{
    private string $shortUrl;

    private ShortUrlRepository $shortUrlRepository;

    public function __construct(Request $request, ShortUrlRepository $shortUrlRepository)
    {
        $data = json_decode($request->getContent());
        $this->checkRequiredParameters($data);

        $this->shortUrlRepository = $shortUrlRepository;
        $this->shortUrl = $data->short_url;
    }

    public function getNumVisit(): int
    {
        $data = $this->shortUrlRepository->findShortUrl($this->shortUrl);

        if (empty($data)) {
            throw new NotFoundHttpException('Short url not found');
        }

        return (int) $data[0]['numberVisit'];
    }

    private function checkRequiredParameters(\stdClass $data)
    {
        if(empty($data->short_url)) {
            throw new BadRequestHttpException('Error, short url for statistics is not set');
        }

    }
}
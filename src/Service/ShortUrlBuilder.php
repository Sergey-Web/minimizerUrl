<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;

use DateInterval;
use DateTime;
use LogicException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShortUrlBuilder implements ShortUrlBuilderInterface
{
    private string $url;

    private ShortUrl $shortUrl;

    private ShortUrlRepository $shortUrlRepository;

    private int $lifetime;

    public function __construct(Request $request, ShortUrlRepository $shortUrlRepository)
    {
        $data = json_decode($request->getContent());

        $this->checkRequiredParameters($data);

        $this->url = $data->url;
        $this->lifetime = $data->lifetime ?? 3600;
        $this->shortUrl = new ShortUrl();
        $this->shortUrlRepository = $shortUrlRepository;
    }

    public function build(): ShortUrl
    {
        $currentDate = new DateTime();
        $expiresDate = new DateTime();

        return $this->shortUrl
            ->setCode($this->getCode(3))
            ->setUrl($this->url)
            ->setCreatedAt($currentDate)
            ->setExpiresAt(DateTimeHelper::getInterval($this->lifetime, $expiresDate));
    }

    private function checkRequiredParameters(stdClass $data): void
    {
        if(empty($data->url)) {
            throw new BadRequestHttpException('Error, "url" not passed to create short url');
        }

        if (!filter_var($data->url, FILTER_VALIDATE_URL)) {
            throw new BadRequestHttpException('Error, is not a valid URL');
        }
    }

    private function getCode(int $attempts): string
    {
        $code = AliasGenerator::generate();

        do {
            $res = $this->shortUrlRepository->findBy(['code' => $code]);
            if (empty($res)) {
                break;
            }
            --$attempts;
        } while($attempts > 0);

        if (!empty($res)) {
            throw new LogicException('Exhausted attempts to generate an code', 500);
        }

        return $code;

    }
}
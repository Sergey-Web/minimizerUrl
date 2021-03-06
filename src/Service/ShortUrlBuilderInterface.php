<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShortUrl;

interface ShortUrlBuilderInterface
{
    function build(): ShortUrl;
}
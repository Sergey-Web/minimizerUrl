<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MainController extends AbstractController
{
    /**
     * @Route("/{code}")
     * @ParamConverter("post", options={"id" = "post_id"})
     */
    public function forwardShortUrl(ShortUrl $shortUrl)
    {
        $this->redirect();
    }
}
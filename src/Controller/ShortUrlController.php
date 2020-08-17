<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;
use App\Service\ShortUrlBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ShortUrlController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/short-url", methods={"POST"}, name="short_url")
     */
    public function generateShortUrl(Request $request, ShortUrlRepository $shortUrlRepository, RequestContext $requestContext): Response
    {
        $shortUrl = (new ShortUrlBuilder($request, $shortUrlRepository))->build();
        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();

        return new JsonResponse([
            'short_url' => $request->getSchemeAndHttpHost() . '/' . $shortUrl->getCode(),
            'expires_at' => $shortUrl->getExpiresAt()->format('Y-m-d H:i:s')
        ]);
    }
}
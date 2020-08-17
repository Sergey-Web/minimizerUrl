<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ShortUrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MainController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{code}", name="render-minimizer-url")
     */
    public function forwardShortUrl(string $code, ShortUrlRepository $shortUrlRepository): RedirectResponse
    {
        $shortUrlData = $shortUrlRepository->getUrl($code);

        if (empty($shortUrlData)) {
            throw new NotFoundHttpException('Short url not found or expired');
        }

        $shortUrl = $shortUrlRepository->find($shortUrlData[0]['id']);
        $shortUrl->setNumberVisit($shortUrlData[0]['numberVisit']+1);

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();

        return $this->redirect($shortUrlData[0]['url'], 302);
    }
}
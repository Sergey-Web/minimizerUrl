<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ShortUrlStatisticRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity(repositoryClass=ShortUrlStatisticRepository::class)
 */
class ShortUrlStatistic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * One Cart has One Customer.
     * @OneToOne(targetEntity="App\Entity\ShortUrl", inversedBy="shortUrlStatistic")
     * @JoinColumn(name="short_url_id", referencedColumnName="id")
     */
    private ShortUrl $shortUrl;

    /**
     * @ORM\Column(type="integer")
     */
    private int $counterVisit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCounterVisit(): int
    {
        return $this->counterVisit;
    }

    public function setCounterVisit(int $counterVisit): self
    {
        $this->counterVisit = $counterVisit;

        return $this;
    }
}

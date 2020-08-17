<?php

namespace App\Repository;

use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[]    findAll()
 * @method ShortUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function getUrl(string $code): array
    {
        return $this->createQueryBuilder('su')
            ->select('su.id, su.url, su.numberVisit')
            ->andWhere("su.code = '$code'")
            ->andWhere("su.expiresAt > CURRENT_TIMESTAMP()")
            ->getQuery()
            ->getResult()
            ;
    }

    public function findShortUrl(string $shortUrl): array
    {
        $code = explode('/',trim($shortUrl, '/'));

        return $this->createQueryBuilder('su')
            ->select('su.numberVisit')
            ->andWhere("su.code = '$code[3]'")
            ->getQuery()
            ->getResult()
            ;
    }
}

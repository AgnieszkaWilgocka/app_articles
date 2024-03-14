<?php

namespace App\Repository;

use App\Entity\Author;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    
    public function topThreeAuthors(): array
    {
        $now = new DateTimeImmutable();
        $now = $now->setTime(23, 59, 59);
        $start = $now->modify(' -6 days')->setTime(0, 0, 0);

        $qb = $this->createQueryBuilder('author');

        $qb
        ->addSelect('COUNT(article.id) AS articlesTotal')
        ->leftJoin('author.articles', 'article')
        ->andWhere('article.createdAt BETWEEN :start AND :now')
        ->setParameter('start', $start)
        ->setParameter('now', $now)
        ->addGroupBy('author.id')
        ->orderBy('articlesTotal', 'DESC')
        ->setMaxResults(3);

        $query = $qb->getQuery();

        return $query->getResult();
    }
    

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

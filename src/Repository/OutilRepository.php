<?php

namespace App\Repository;

use App\Entity\Outil;
use App\Form\SearchType;
use App\model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @extends ServiceEntityRepository<Outil>
 *
 * @method Outil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Outil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Outil[]    findAll()
 * @method Outil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Outil::class);
    }

    public function paginationQuery()
    {
        return $this->createQueryBuilder('o')
            ->where('o.statut = :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('o.PublishedAt');
    }

    public function findBySearch(
        SearchData $searchData
    ): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
            ->where('p.statut LIKE :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('p.PublishedAt', 'DESC');

        if (!empty($searchData->q)) {
            $data = $data
                ->andWhere('p.nom LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }

        $data = $data
            ->getQuery()
            ->getResult();

        $outil = $this->PaginatorInterface ->paginate($data, $searchData->page, 5);

        return $outil;
    }

//    /**
//     * @return Outil[] Returns an array of Outil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Outil
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

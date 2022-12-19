<?php

namespace App\Repository;

use App\Entity\Animals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animals>
 *
 * @method Animals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animals[]    findAll()
 * @method Animals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animals::class);
    }

    public function findAnimalsPaginated(int $page, string $slug, int $limit = 6): array
    {
        // On transforme les valeurs négatives en posititves
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('r', 'a')
            ->from('App\Entity\Animals', 'a')
            ->join('a.races', 'r')
            ->where("r.slug = '$slug'")
            ->setMaxResults($limit)
            // On definie quel est le premier élément affiché par page , si on a 2 elements par page , a la page 2 on retrouvera le 4eme resultat, donc le resultat a l'index 3 en premier , donc 2x2 - 2 = 2, l'index 2 renvoie bien au 3eme résultat
            ->setFirstResult(($page * $limit) - $limit);

            $paginator = new Paginator($query);
            $data = $paginator->getQuery()->getResult();

            // On vérifie qu'on a des données
            if(empty($data))
            {
                return $result;
            }
        
            // On calcule le nombre de pages
            $pages = ceil($paginator->count() / $limit);
            // On remplit le tableau
            $result['data'] = $data;
            $result['pages'] = $pages;
            $result['page'] = $page;
            $result['limit'] = $limit;

        return $result;
    }

    public function save(Animals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Animals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Animals[] Returns an array of Animals objects
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

//    public function findOneBySomeField($value): ?Animals
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

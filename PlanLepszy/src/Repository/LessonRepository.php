<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lesson>
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function deleteAllNotUpdated(): void
    {
        $entityManager = $this->getEntityManager();

//        $query = $entityManager->createQuery(
//            'DELETE
//            FROM lesson
//            WHERE is_updated == false'
//        );
//        $query->execute();

        $qb = $this->createQueryBuilder('lesson')
            ->delete()
            ->where('lesson.is_updated = false');
        $query = $qb->getQuery();
        $query->execute();

        $qb = $this->createQueryBuilder('lesson')
            ->update()
            ->set('lesson.is_updated', 0)
            ->where('lesson.is_updated = true');
        $query = $qb->getQuery();
        $query->execute();

//        $query = $entityManager->createQuery(
//            'UPDATE
//            lesson
//            SET is_updated = false
//            WHERE true'
//        );
//        $query->execute();
        return;
    }

    //    /**
    //     * @return Lesson[] Returns an array of Lesson objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Lesson
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

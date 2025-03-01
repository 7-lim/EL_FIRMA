<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }
    public function findMessagesByDiscussion($discussionId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.discussion = :discussionId')
            ->setParameter('discussionId', $discussionId)
            ->getQuery()
            ->getResult();
    }

    public function findMessagesByDiscussionOrderedByLikes(int $discussionId)
{
    return $this->createQueryBuilder('m')
        ->leftJoin('m.likes', 'l') // Jointure avec la table "likes"
        ->where('m.discussion = :discussionId')
        ->setParameter('discussionId', $discussionId)
        ->groupBy('m.id')
        ->orderBy('COUNT(l.id)', 'DESC') // Trie par nombre de likes décroissant
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return Message[] Returns an array of Message objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Message
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    //    /**
    //     * @return Account[] Returns an array of Account objects
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

       public function findOneById($value): ?Account
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.id = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

       public function findOneByWorkerId($value): ?Account
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.worker_id = :val')
               ->setParameter('val', $value)
               ->andWhere('a.status = :status')
                ->setParameter('status', 'Processing')
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

    public function findLastActiveAccountsLoginAndPassword(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'Active')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(10)
            ->select('a.login', 'a.password','a.id','a.state')
            ->getQuery()
            ->getResult();
    }

    public function assignWorkerId(Account $account, int $workerId): void
    {
        $account->setWorkerId($workerId);
        $account->setStatus('Processing');
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    }

    public function deactivateAccount(Account $account, string $status){

        $account->setStatus($status);
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();

    }
}

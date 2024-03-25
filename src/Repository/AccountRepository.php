<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Driver\Connection;
use DateTime; 
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
    

    public function filterByState(string $state): array
       {
           return $this->createQueryBuilder('a')
               ->andWhere('a.status = :status')
               ->setParameter('status', 'Active')
               ->andWhere('a.state = :state')
               ->setParameter('state',$state)
               ->orderBy('a.id', 'DESC')
               ->setMaxResults(10)
               ->select('a.login', 'a.password','a.id','a.state')
               ->getQuery()
               ->getResult();
       }
    public function findLastActiveAccountsLoginAndPassword(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'Active')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(500)
            ->select('a.login', 'a.password','a.id','a.state')
            ->getQuery()
            ->getResult();
    }

    public function findLastClosedAccounts( ) {

        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'Closed')
            ->andWhere('a.admin_event != :event')
            ->setParameter('event', 'Sold')
            ->orderBy('a.id', 'DESC')
            
            ->select('a')
            ->getQuery()
            ->getResult();
    }
    public function findLastSoldAccounts( ) {

        return $this->createQueryBuilder('a')
             
            ->andWhere('a.admin_event = :event')
            ->setParameter('event', 'Sold')
            ->orderBy('a.id', 'DESC')
            
            ->select('a')
            ->getQuery()
            ->getResult();
    }
    public function findAwaitedAccountsForUser(int $id ) {

        return $this->createQueryBuilder('a')
            ->andWhere('a.admin_event = :status')
            ->setParameter('status', 'Await')
            ->andWhere('a.worker_id = :id')
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC')
            
            ->select('a')
            ->getQuery()
            ->getResult();
    }

    public function DeleteAccountByID(int $accountId) {
        $entityManager = $this->getEntityManager();
        $account = $this->find($accountId);

        if ($account) {
            $entityManager->remove($account);
            $entityManager->flush();
        }
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
        if ($status == 'Closed') {
            $account->setCreatedAt(date('Y-m-d'));
            $account->setAdminEvent('Await');
        }
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();

    }

    public function deactivateAccountByAdmin(Account $account, string $status){

        
        $account->setAdminEvent($status);
         
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();

    }

    public function findOneByAdminId($value): ?Account
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.admin_id = :val')
            ->setParameter('val', $value)
            ->andWhere('a.admin_event = :status')
            ->setParameter('status', 'In progress')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function assignAdminId(Account $account, int $workerId): void
    {
        $account->setAdminId($workerId);
        $account->setAdminEvent('In progress');
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    }
     public function getAccountDetailsByDate($connection, $date)
    {
        $sql = '
            SELECT 
                u.username AS username,
                a.day,
                a.worker_id,
                a.amount_of_barcodes,
                a.total_price
            FROM (
                SELECT 
                    worker_id,
                    created_at AS day,
                    COALESCE(SUM(CASE WHEN barcode1 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode2 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode3 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode4 IS NOT NULL THEN 1 ELSE 0 END), 0) AS amount_of_barcodes,
                    SUM(CASE WHEN barcode1 IS NOT NULL OR barcode2 IS NOT NULL THEN price ELSE 0 END)
                    + SUM(CASE WHEN barcode3 IS NOT NULL OR barcode4 IS NOT NULL THEN price2 ELSE 0 END) AS total_price
                FROM 
                    account
                WHERE
                    created_at = :date
                GROUP BY 
                    worker_id
            ) AS a
            JOIN user AS u ON u.id = a.worker_id
        ';

        $stmt = $connection->prepare($sql);
        $stmt = $stmt->execute(['date' => $date]); 
        $results = $stmt->fetchAllAssociative();

        return $results; 
}

public function getAccountDetailsByDateAndWorkID($connection, $date, $workerId)
    {
        $sql = '
             SELECT 
                
                SUM(a.amount_of_barcodes) as amount_of_barcodes ,
                SUM(a.total_price) as total_price
            FROM (
                SELECT 
                    worker_id,
                    DATE(created_at) AS day,
                    COALESCE(SUM(CASE WHEN barcode1 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode2 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode3 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode4 IS NOT NULL THEN 1 ELSE 0 END), 0) AS amount_of_barcodes,
                    SUM(CASE WHEN barcode1 IS NOT NULL OR barcode2 IS NOT NULL THEN price ELSE 0 END)
                    + SUM(CASE WHEN barcode3 IS NOT NULL OR barcode4 IS NOT NULL THEN price2 ELSE 0 END) AS total_price
                FROM 
                    account
                WHERE
                    created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL (DAYOFWEEK(CURRENT_DATE()) + 5) % 7 DAY) AND
                    created_at < DATE_ADD(DATE_SUB(CURRENT_DATE(), INTERVAL (DAYOFWEEK(CURRENT_DATE()) + 5) % 7 DAY), INTERVAL 7 DAY) AND
                    worker_id =  :worker_id
                GROUP BY 
                    worker_id, DATE(created_at)
            ) AS a
            JOIN user AS u ON u.id = a.worker_id
            WHERE 
                a.worker_id = :worker_id
            ORDER BY day ASC
             
        ';

        $stmt = $connection->prepare($sql);
        $stmt = $stmt->execute([ 'worker_id' => $workerId, ]); 
        
        $results = $stmt->fetchAllAssociative();

        return $results; 
}


public function GetGraphData($connection){
            // Calculate the start and end dates of the current week
        $startDate = date('Y-m-d', strtotime('last Monday'));
        $endDate = date('Y-m-d', strtotime('next Sunday'));

        // Initialize an array to hold the results
        $results = [];

        $sql = '
            SELECT 
                DATE(created_at) AS day,
                SUM(price + price2) as total_price
            FROM 
                account
            WHERE 
                created_at >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
            GROUP BY 
                DATE(created_at)
            ORDER BY 
                DATE(created_at) ASC;
        ';
        $stmt = $connection->prepare($sql);
        $stmt = $stmt->execute(); 
        $queryResults = $stmt->fetchAllAssociative();

        // Process the query results
        foreach ($queryResults as $row) {
            $results[$row['day']] = [
                'total_price' => $row['total_price'],
                 
            ];
        }

        // Fill in the missing dates with zeros
        $currentDate = new DateTime($startDate);
        $endDateObj = new DateTime($endDate);
        while ($currentDate <= $endDateObj) {
            $currentDateString = $currentDate->format('Y-m-d');
            if (!isset($results[$currentDateString])) {
                $results[$currentDateString] = [
                    'total_price' => 0,
                   
                ];
            }
            $currentDate->modify('+1 day');
        }

        // Sort the results by date
        ksort($results);

        return $results;
    }

    public function getProfileWeekProgrees($connection, $workerId)
    {
        $sql = '
                SELECT 
                u.username AS username,
                DATE(a.day) AS day,
                a.worker_id,
                a.amount_of_barcodes,
                a.total_price
            FROM (
                SELECT 
                    worker_id,
                    DATE(created_at) AS day,
                    COALESCE(SUM(CASE WHEN barcode1 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode2 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode3 IS NOT NULL THEN 1 ELSE 0 END), 0) 
                    + COALESCE(SUM(CASE WHEN barcode4 IS NOT NULL THEN 1 ELSE 0 END), 0) AS amount_of_barcodes,
                    SUM(CASE WHEN barcode1 IS NOT NULL OR barcode2 IS NOT NULL THEN price ELSE 0 END)
                    + SUM(CASE WHEN barcode3 IS NOT NULL OR barcode4 IS NOT NULL THEN price2 ELSE 0 END) AS total_price
                FROM 
                    account
                WHERE
                    created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL (DAYOFWEEK(CURRENT_DATE()) + 5) % 7 DAY) AND
                    created_at < DATE_ADD(DATE_SUB(CURRENT_DATE(), INTERVAL (DAYOFWEEK(CURRENT_DATE()) + 5) % 7 DAY), INTERVAL 7 DAY) AND
                    worker_id =  :worker_id
                GROUP BY 
                    worker_id, DATE(created_at)
            ) AS a
            JOIN user AS u ON u.id = a.worker_id
            WHERE 
                a.worker_id = :worker_id
            ORDER BY day ASC
        ';

        $stmt = $connection->prepare($sql);
        $stmt = $stmt->execute([ 'worker_id' => $workerId, ]); 
        
        $results = $stmt->fetchAllAssociative();

        return $results; 
    }


    public function removeOldAccounts(): void
    {
        $entityManager = $this->getEntityManager();

        // Calculate the date one month ago
        $oneMonthAgo = new \DateTime();
        $oneMonthAgo->modify('-1 month');

        // Query accounts older than one month
        $oldAccounts = $this->createQueryBuilder('a')
            ->andWhere(' a.createdAt  < :oneMonthAgo')
            ->setParameter('oneMonthAgo', $oneMonthAgo->format('Y-m-d'))
            ->andWhere(' a.admin_event  = :event')
            ->setParameter('event', 'Sold')
            ->getQuery()
            ->getResult();

        // Remove the old accounts
        foreach ($oldAccounts as $account) {
            $entityManager->remove($account);
        }
        
        // Flush changes to the database
        $entityManager->flush();
    }
}

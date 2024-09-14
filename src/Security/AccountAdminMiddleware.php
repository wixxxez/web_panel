<?php 

namespace App\Security; 

use App\Repository\AccountRepository;
use App\Repository\UserRepository;
use App\Entity\Account; 

class AccountAdminMiddleware 
{

    private $account; 
    public function __construct(Account $account, AccountRepository $account_repo,  int $user_id) 
    {

        // $this->user_repo = $user_repo;
        $this->account_repo = $account_repo;
        $this->user_id = $user_id;
        $this->account = $account;
    }

    public function isAdminHaveAccount(): bool{
        $account = $this->account_repo->findOneByAdminId($this->user_id);
         
        if ($account) {
            return True;
        }
        return False; 
    }

    public function checkAccess($id): bool {

        
        $account = $this->account_repo->findOneById($id);

        
        return $account->getAdminId() == $this->user_id;
    }
}
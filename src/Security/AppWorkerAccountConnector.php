<?php

namespace App\Security;

use App\Repository\AccountRepository;
use App\Repository\UserRepository;

class AppWorkerAccountConnector {


    private $user_id; 
    public function __construct(int $user_id, AccountRepository $account_repo,  ) 
    {

        // $this->user_repo = $user_repo;
        $this->account_repo = $account_repo;
        $this->user_id = $user_id;
    }

    public function isUserHaveAccount(): bool{
        $account = $this->account_repo->findOneByWorkerId($this->user_id);
         
        if ($account) {
            return True;
        }
        return False; 
    }

    public function checkAccess($id): bool {

        
        $account = $this->account_repo->findOneById($id);

        
        return $account->getWorkerId() == $this->user_id;
    }
}
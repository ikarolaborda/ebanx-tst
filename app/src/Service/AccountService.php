<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Repository\AccountRepository;
use phpDocumentor\Reflection\Types\False_;

class AccountService
{
    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deposit(int $destination, float $amount): Account
    {
        $account = $this->repository->find($destination);
        if(!$account) {
            $account = new Account();
            $account->setId($destination)
                ->setBalance($amount);

            $this->repository->add($account, true);
        }else {
            $account->setBalance($account->getBalance() + $amount);
            $this->repository->update($account);
        }

        return $account;

    }

    public function withdraw(int $origin, float $amount)
    {
        try {
            $account = $this->repository->find($origin);
            if($account) {
                $account->setBalance($account->getBalance() - $amount);
                $this->repository->update($account);
                return $account;
            }

            return false;

        }catch (\Exception $error) {
            echo $error->getMessage();
            return false;
        }
    }

    public function transfer(int $origin, int $destination, float $amount)
    {
        $originAccount = $this->repository->find($origin);
        if(!$originAccount) {
            return false;
        }
        $destinationAccount = $this->repository->find($destination);
        if(!$destinationAccount) {
            $originAccount->setBalance($originAccount->getBalance() - $amount);
            $this->repository->update($originAccount);

            $newDestinationAccount = new Account();
            $newDestinationAccount->setId($destination)
                ->setBalance($amount);

            $this->repository->add($newDestinationAccount, true);

            return true;
        }else {
            $originAccount->setBalance($originAccount->getBalance() - $amount);
            $this->repository->update($originAccount);
            $destinationAccount->setBalance($destinationAccount->getBalance() + $amount);
            $this->repository->update($destinationAccount);

            return true;
        }



    }

    public function retrieveAccount(int $accountId): Account
    {
        return $this->repository->find($accountId);
    }

}
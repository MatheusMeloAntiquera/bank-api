<?php

namespace App\Infra\Services;

use Exception;
use App\Domain\User\User;
use App\Domain\Store\Store;
use App\Exceptions\TransactionException;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\Store\StoreRepositoryInterface;
use App\Domain\Transaction\DtoTransactionExecute;
use App\Infra\Repositories\NotifyServiceRepository;
use App\Exceptions\TransactionNotAuthorizedException;
use App\Domain\Transaction\TransactionServiceInterface;
use App\Domain\Transaction\TransactionRepositoryInterface;
use App\Infra\Repositories\AuthorizationServiceRepository;

abstract class TransactionServiceBase implements TransactionServiceInterface
{
    protected User $sender;
    protected User|Store $recipient;
    protected UserRepositoryInterface $userRepository;
    protected StoreRepositoryInterface $storeRepository;
    protected TransactionRepositoryInterface $transactionRepository;
    protected AuthorizationServiceRepository $authorizationServiceRepository;
    protected NotifyServiceRepository $notifyServiceRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        StoreRepositoryInterface $storeRepository,
        TransactionRepositoryInterface $transactionRepository,
        AuthorizationServiceRepository $authorizationServiceRepository,
        NotifyServiceRepository $notifyServiceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->storeRepository = $storeRepository;
        $this->transactionRepository = $transactionRepository;
        $this->authorizationServiceRepository = $authorizationServiceRepository;
        $this->notifyServiceRepository = $notifyServiceRepository;
    }

    abstract protected function setSender(string|int $id): void;
    abstract protected function setRecipient(int|string $id): void;
    abstract protected function updateBalances(float $value): void;
    abstract protected function startTransaction(): void;
    abstract protected function rollbackTransaction(): void;

    public function execute(DtoTransactionExecute $dtoCreate)
    {
        $this->setSender($dtoCreate->senderId);
        $this->checkIfSenderHasSufficientBalance($dtoCreate->value);

        $this->setRecipient($dtoCreate->recipientId);

        try {
            $this->startTransaction();

            $transaction = $this->transactionRepository->registerNewTransaction(
                $this->sender,
                $this->recipient,
                $dtoCreate->value
            );

            $this->updateBalances($dtoCreate->value);

            $this->checkAuthorizationOnExternalService();

        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }

        $this->notifyServiceRepository->sendMessageToRecipient($this->recipient, $transaction);

        return $transaction;
    }

    private function checkAuthorizationOnExternalService()
    {
        if ($this->authorizationServiceRepository->isAuthorized() === false) {
            throw new TransactionNotAuthorizedException(
                "The external service did not authorized this transaction"
            );
        }
    }

    private function checkIfSenderHasSufficientBalance($value)
    {
        if (($this->sender->balance - $value) < 0) {
            throw new TransactionNotAuthorizedException(
                "The sender don't have sufficient balance to execute this transfer"
            );
        }
    }
}

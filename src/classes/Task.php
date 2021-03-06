<?php

namespace taskForce\classes;


use taskForce\exception\CheckParamException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_PERFORMED = 'performed';
    const STATUS_FAILED = 'failed';

    public $idCustomer = null;
    public $idExecutor = null;
    public $currentStatus = null;
    public $idCurrentUser = 1;

    public function __construct(int $idCustomer, ?int $idExecutor = null)
    {
        $this->idCustomer = $idCustomer;
        $this->idExecutor = $idExecutor;

    }

    /**
     * Получить статус после выполнения указанного действия
     * @param string $action Действие
     * @return string Статус
     * @throws CheckParamException
     */
    public function getStatus(string $action): string
    {
        switch ($action) {
            case PublishAction::getName():
                if (PublishAction::verify($this->idCustomer, $this->idExecutor, $this->idCurrentUser)) {
                    return self::STATUS_NEW;
                }

            case CancelAction::getName() :
                if (CancelAction::verify($this->idCustomer, $this->idExecutor, $this->idCurrentUser)) {
                    return self::STATUS_CANCELED;
                }

            case SelectAction::getName() :
                if (SelectAction::verify($this->idCustomer, $this->idExecutor, $this->idCurrentUser)) {
                    return self::STATUS_IN_WORK;
                }

            case PerformAction::getName() :
                if (PerformAction::verify($this->idCustomer, $this->idExecutor, $this->idCurrentUser)) {
                    return self::STATUS_PERFORMED;
                }
                break;
            case FailAction::getName() :
                if (FailAction::verify($this->idCustomer, $this->idExecutor, $this->idCurrentUser)) {
                    return self::STATUS_FAILED;
                }
            default:
                throw new CheckParamException("Нет такого действия");
        }

        return $this->currentStatus;
    }

    /**
     * Получить названия статусов
     * @return array Ассоциативный массив названий статусов
     */
    public function mapStatus(): array
    {

        return [
            self::STATUS_NEW => "Новое",
            self::STATUS_CANCELED => "Отменено",
            self::STATUS_IN_WORK => "В работе",
            self::STATUS_PERFORMED => "Выполнено",
            self::STATUS_FAILED => "Провалено"
        ];
    }

    /**
     * Получить названия действий
     * @return array Ассоциативный массив названий действий
     */
    public function mapActions(): array
    {

        return [
            PublishAction::getName() => PublishAction::getTitle(),
            CancelAction::getName() => CancelAction::getTitle(),
            SelectAction::getName() => SelectAction::getTitle(),
            PerformAction::getName() => PerformAction::getTitle(),
            FailAction::getName() => FailAction::getTitle()
        ];
    }

    /**
     * Получить доступные действия
     * @param string $status Статус
     * @return array массив действий
     * @throws CheckParamException
     */
    public function getAvailableActions(string $status): array
    {
        if (!array_key_exists($status, self::mapStatus())) {
            throw new CheckParamException("Нет такого статуса");
        }
        switch ($status) {
            case self::STATUS_NEW :
                return [CancelAction::ACTION_CANCEL, SelectAction::ACTION_ARTIST_SELECTION];
            case self::STATUS_IN_WORK :
                return [FailAction::ACTION_FAIL, PerformAction::ACTION_PERFORM];
        }

        return [];
    }
}


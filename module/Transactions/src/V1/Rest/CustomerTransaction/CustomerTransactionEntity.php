<?php
namespace Transactions\V1\Rest\CustomerTransaction;

use Application\Models\GlobalHelper;

class CustomerTransactionEntity
{
    private static ?string $currency;

    private int $transaction_id;
    private int $customer_id;
    private string $amount;
    private string $type;
    private string $source;

    /**
     * @param mixed $currency
     */
    public static function setCurrency(?string $currency = null): void
    {
        self::$currency = $currency;
    }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transaction_id;
    }

    /**
     * @param $transaction_id
     * @return void
     */
    public function setTransactionId($transaction_id): void
    {
        $this->transaction_id = (int)$transaction_id;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        if (isset(self::$currency)) {
            $data = GlobalHelper::currencyConverter(self::$currency, $this->amount);
            $data = @json_decode($data, 1);
            if(isset($data['rates'][self::$currency])) {
                $this->amount = $data['rates'][self::$currency]['rate_for_amount'];
            }
        }
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = number_format($amount, '2', '.', '');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    /**
     * @param $customer_id
     * @return void
     */
    public function setCustomerId($customer_id): void
    {
        $this->customer_id = (int)$customer_id;
    }
}

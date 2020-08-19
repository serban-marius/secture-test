<?php


namespace App\Service;


class PlayersService
{
    private $urlUsdValue = "https://api.exchangeratesapi.io/latest?base=EUR&symbols=USD";

    private $usdValue;

    public function __construct()
    {
        $this->usdValue = $this->getUsdValue();
    }

    /**
     * @param $price
     * @return float
     */
    public function getValueInUsd($price): float
    {
        return $price * $this->usdValue;
    }

    /**
     * @return float
     */
    public function getUsdValue(): float
    {
        $rates = json_decode(file_get_contents($this->urlUsdValue), true);
        return $rates['rates']['USD'];
    }

    public function getValueByCurrency($price, $currency)
    {
        switch ($currency){
            case "USD":
                return $this->getValueInUsd($price);
            default:
                return $price;
        }
    }
}
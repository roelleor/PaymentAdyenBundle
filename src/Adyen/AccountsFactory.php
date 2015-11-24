<?php

namespace Ruudk\Payment\AdyenBundle\Adyen;

/**
 * Factory is needed to inject accounts in Api, instances of objects cannot be injected due to logging exception
 * Class AccountsFactory
 * @package Ruudk\Payment\AdyenBundle\Adyen
 */
class AccountsFactory
{

    /**
     * @var array
     */
    protected $accountsParameters;


    /**
     * @param array $accountsParameters
     */
    public function __construct($accountsParameters)
    {
        $this->accountsParameters = $accountsParameters;
    }

    /**
     * @return Account[]
     */
    public function create()
    {
        $accounts = [];
        foreach ($this->accountsParameters as $accountParameters) {
            $account = new Account();
            $account->setShopperLocale($accountParameters['shopper_locale']);
            $account->setMerchantAccount($accountParameters['merchant_account']);
            $account->setSecretKey($accountParameters['secret_key']);
            $account->setSkinCode($accountParameters['skin_code']);
            $account->setMethods($accountParameters['methods']);

            $accounts[] = $account;
        }

        return $accounts;
    }

}

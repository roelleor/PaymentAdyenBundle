<?php

namespace Ruudk\Payment\AdyenBundle\Adyen;

class Account implements AccountInterface
{

    /**
     * @var string
     */
    protected $merchantAccount;

    /**
     * @var string
     */
    protected $skinCode;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $shopperLocale;

    /**
     * @var array
     */
    protected $methods;

    /**
     * @param string $merchantAccount
     */
    public function setMerchantAccount($merchantAccount)
    {
        $this->merchantAccount = $merchantAccount;
    }

    /**
     * @return string
     */
    public function getMerchantAccount()
    {
        return $this->merchantAccount;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param null|string $shopperLocale
     */
    public function setShopperLocale($shopperLocale)
    {
        $this->shopperLocale = $shopperLocale;
    }

    /**
     * @return null|string
     */
    public function getShopperLocale()
    {
        return $this->shopperLocale;
    }

    /**
     * @param string $skinCode
     */
    public function setSkinCode($skinCode)
    {
        $this->skinCode = $skinCode;
    }

    /**
     * @return string
     */
    public function getSkinCode()
    {
        return $this->skinCode;
    }

    /**
     * @param array $methods
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

}

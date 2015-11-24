<?php

namespace Ruudk\Payment\AdyenBundle\Adyen;

interface AccountInterface
{

    /**
     * @param string $merchantAccount
     */
    public function setMerchantAccount($merchantAccount);

    /**
     * @return string
     */
    public function getMerchantAccount();

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey);

    /**
     * @return string
     */
    public function getSecretKey();

    /**
     * @param null|string $shopperLocale
     */
    public function setShopperLocale($shopperLocale);

    /**
     * @return null|string
     */
    public function getShopperLocale();

    /**
     * @param string $skinCode
     */
    public function setSkinCode($skinCode);

    /**
     * @return string
     */
    public function getSkinCode();

    /**
     * @param array $methods
     */
    public function setMethods($methods);

    /**
     * @return array
     */
    public function getMethods();

}

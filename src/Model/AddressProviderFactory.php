<?php
namespace CoolBlue\Model;

use CoolBlue\Model\Csv\CsvAddressProvider;

class AddressProviderFactory
{
    public static function createProvider(array $apiConfig)
    {
        $providerOptions = $apiConfig['storages'][$apiConfig['currentStorageFormat']];

        if ('csv' == $apiConfig['currentStorageFormat']) {
            return new CsvAddressProvider($providerOptions);
        } // elseif (<some other provider e.g. mysql, redis etc>)

        return null;
    }
}
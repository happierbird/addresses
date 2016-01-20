<?php
namespace CoolBlue\Model;

class AddressEntityValidator
{
    /**
     * @param AddressEntity $address
     *
     * @return bool
     */
    public static function validateEntityPhysicalAddress(AddressEntity $address)
    {
        // any logic to validate address string
        return preg_match('/^[a-zA-Z0-9_ ]+$/', $address->getEntityPhysicalAddress());
    }

    /**
     * @param AddressEntity $address
     *
     * @return bool
     */
    public static function validateEntityName(AddressEntity $address)
    {
        // any logic to validate person name
        return preg_match('/^[a-zA-Z ]+$/', $address->getEntityName());
    }

    /**
     * @param AddressEntity $address
     *
     * @return bool
     */
    public static function validateEntityPhone(AddressEntity $address)
    {
        // any logic to validate person phone
        return preg_match('/^[\d]+$/', $address->getEntityPhone());
    }

    /**
     * @param AddressEntity $address
     *
     * @return bool
     */
    public static function isValid(AddressEntity $address) {
        return self::validateEntityName($address) &&
        self::validateEntityPhone($address) &&
        self::validateEntityPhysicalAddress($address);
    }
}


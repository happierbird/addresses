<?php
namespace CoolBlue\Model;

class AddressEntity
{
    /**
     * Contains person name
     * @var string
     */
    private $entityName = null;

    /**
     * Contains entity contact phone
     * @var string
     */
    private $entityPhone = null;

    /**
     * Contains entity physical address
     * @var string
     */
    private $entityPhysicalAddress = null;

    public function __construct($entityName, $entityPhone, $entityPhysicalAddress)
    {
        $this->entityName = $entityName;
        $this->entityPhone = $entityPhone;
        $this->entityPhysicalAddress = $entityPhysicalAddress;
    }

    /**
     * @param string $entityPhysicalAddress
     */
    public function setEntityPhysicalAddress($entityPhysicalAddress)
    {
        $this->entityPhysicalAddress = $entityPhysicalAddress;
    }

    /**
     * @return string
     */
    public function getEntityPhysicalAddress()
    {
        return $this->entityPhysicalAddress;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityPhone
     */
    public function setEntityPhone($entityPhone)
    {
        $this->entityPhone = $entityPhone;
    }

    /**
     * @return string
     */
    public function getEntityPhone()
    {
        return $this->entityPhone;
    }

    public function toArray() {
        return array(
            'entityName' => $this->entityName,
            'entityPhone' => $this->entityPhone,
            'entityPhysicalAddress' => $this->entityPhysicalAddress,
        );
    }
}


<?php
namespace CoolBlue\Model\Csv;

use CoolBlue\Model\AddressEntity;


class CsvAddressProvider
{
    private $csvManager = null;

    public function __construct(array $options)
    {
        $this->csvManager = new CsvManager($options['path']);
    }

    public function findAddress($id) {
        if (FALSE === $line = $this->csvManager->read($id)) {
            return null;
        }
        if (empty($line)) {
            return null;
        }
        $addressArray = explode(',', $line);

        return new AddressEntity($addressArray[0], $addressArray[1], $addressArray[2]);
    }

    public function addAddress(AddressEntity $address)
    {
        $newLine = "\r\n" . implode(',', $address->toArray());

        return $this->csvManager->create($newLine);
    }

    public function deleteAddress($id) {
        if ($line = $this->csvManager->read($id)) {
            return $this->csvManager->delete($line);
        }

        return false;
    }

    public function setAddress($id, AddressEntity $address) {
        if ($line = $this->csvManager->read($id)) {
            return $this->csvManager->update($line, implode(',', $address->toArray()));
        }

        return false;
    }
}

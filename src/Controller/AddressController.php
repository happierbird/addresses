<?php
namespace CoolBlue\Controller;

use CoolBlue\Controller\BaseController;
use CoolBlue\Model\AddressEntityValidator;
use CoolBlue\Model\AddressProviderFactory;
use CoolBlue\Model\AddressEntity;
use CoolBlue\Request\Request;
use CoolBlue\Response\Response;

class AddressController extends BaseController
{
    protected $dataProvider = null;
    private $request = null;

    public function __construct(Request $request) {
        parent::__construct();
        $this->dataProvider = AddressProviderFactory::createProvider($this->config);
        $this->request = $request;
    }

    public function getAction($id, $format)
    {
        /** @var AddressEntity **/
        $address = $this->dataProvider->findAddress($id);

        return new Response($address->toArray(), parent::HTTP_STATUS_OK, $format);
    }

    public function addAction()
    {
        $postData = $this->request->getPost();
        if (!isset($postData['name']) ||
            !isset($postData['phone']) ||
            !isset($postData['address'])) {

            return new Response(array(), parent::HTTP_STATUS_BAD_REQUEST);
        } else {

            $address = new AddressEntity($postData['name'], $postData['phone'], $postData['address']);

            if (AddressEntityValidator::isValid($address)) {
                $this->dataProvider->addAddress($address);

                return new Response(array(), parent::HTTP_STATUS_CREATED);
            } else {
                return new Response(array(), parent::HTTP_STATUS_BAD_REQUEST);
            }
        }
    }

    public function deleteAction($id)
    {
        // Any logic can be added here before actual delete
        $this->dataProvider->deleteAddress($id);

        return new Response(array(), parent::HTTP_STATUS_NO_CONTENT);
    }

    public function updateAction($id)
    {
        /** @var AddressEntity **/
        $address = $this->dataProvider->findAddress($id);
        parse_str($this->request->getContent(), $requestData);
        if (!empty($requestData['name'])) {
            $address->setEntityName($requestData['name']);
        }
        if (!empty($requestData['phone'])) {
            $address->setEntityPhone($requestData['phone']);
        }
        if (!empty($requestData['address'])) {
            $address->setEntityPhysicalAddress($requestData['address']);
        }

        if (AddressEntityValidator::isValid($address)) {
            $this->dataProvider->setAddress($id, $address);

            return new Response(array(), parent::HTTP_STATUS_CREATED);
        } else {
            return new Response(array(), parent::HTTP_STATUS_BAD_REQUEST);
        }
    }

}

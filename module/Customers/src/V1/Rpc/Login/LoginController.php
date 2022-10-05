<?php
namespace Customers\V1\Rpc\Login;

use Customers\V1\Rest\Customer\CustomerMapper;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
{
    private CustomerMapper $mapper;
    private array $request_body;

    /**
     * @param CustomerMapper $mapper
     * @param array $request_body
     */
    public function __construct(CustomerMapper $mapper, array $request_body)
    {
        $this->mapper = $mapper;
        $this->request_body = $request_body;
    }

    /**
     * @return array|ApiProblemResponse
     */
    public function loginAction()
    {
        $data = $this->mapper->login($this->request_body);
        if (empty($data)) {
            return new ApiProblemResponse(new ApiProblem(404, 'Oops User not found'));
        }

        return $data;
    }
}

<?php
namespace Transactions\V1\Rest\CustomerTransaction;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Paginator\Adapter\Callback;
use Laminas\Stdlib\Parameters;

class CustomerTransactionResource extends AbstractResourceListener
{
    private CustomerTransactionMapper $mapper;
    private ?array $request_body;

    /**
     * @param CustomerTransactionMapper $mapper
     * @param array $request_body
     */
    public function __construct(CustomerTransactionMapper $mapper, ?array $request_body = null)
    {
        $this->mapper = $mapper;
        $this->request_body = $request_body;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $entity = new CustomerTransactionEntity();
        $hydrator = new ClassMethodsHydrator();
        $oauth_data = $this->getIdentity()->getAuthenticationIdentity();
        $entity->setCustomerId($oauth_data['user_id']);
        $hydrator->hydrate($this->request_body, $entity);
        $this->mapper->create($entity);
        return $entity;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $limit = $this->request_body['page_size'] ?? 20;
        $offset = (($this->request_body['page'] ?? 1) - 1) * $limit;
        $oauth_data = $this->getIdentity()->getAuthenticationIdentity();
        $data = $this->mapper->fetchAll($limit, $offset, [
            'customer_id' => $oauth_data['user_id'],
        ]);
        CustomerTransactionEntity::setCurrency($this->request_body['currency'] ?? null);
        $adapter = $this->processResponse($data['data'], $data['data_count']);
        return new CustomerTransactionCollection($adapter);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    /**
     * @param array $result
     * @param int $count
     * @return Callback
     */
    private function processResponse(array $result, int $count): Callback
    {
        $hydrator  = new ClassMethodsHydrator();
        $entity = new CustomerTransactionEntity();
        return new Callback(function() use ($result, $hydrator, $entity) {
            $final_data = [];
            foreach ($result as $data) {
                $final_data[] = $hydrator->hydrate($data, $entity);
            }
            return $final_data;
        }, function() use ($count){
            return $count;
        });
    }
}

<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Responders\Api;

trait ApiResponder
{
    /**
     * @var int
     */
    protected $statusCode = 200;
   
    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found.')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message'     => $message,
                'status_code' => $this->getStatusCode(),
            ],
        ]);
    }

    /**
     * @param       $data
     *
     * @return mixed
     */
    public function respond($data)
    {
//        header('Content-Type: application/json;charset=utf-8');

        exit(json_encode($data));
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondUnprocessableEntity($message = 'Parameters validation failed.')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondTokenExpired($message = 'Token Expired')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondTokenInvalid($message = 'Invalid Token.')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondInternalServerError($message = 'Internal Server Error.')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }


    public function respondUnauthenticated($message = 'Authentication required.')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    public function respondUnauthorized($message = 'Authorization required.')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function respondWithSuccess($data)
    {
        return $this->respond([
            'status_code' => $this->getStatusCode(),
            'data'        => $data,
        ]);
    }

    public function respondApiLimitExceeded($message = 'Too many API calls.')
    {
        return $this->setStatusCode(429)->respondWithError($message);
    }

    private function respondTokenMissing($message = 'Token is missing.')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }
}
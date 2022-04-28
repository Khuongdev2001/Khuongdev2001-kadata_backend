<?php

namespace app\helpers;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\rest\Serializer;
use yii\data\DataProviderInterface;
use yii\web\HttpException;

class ResponseBuilder
{

    /**
     * @param bool $status
     * @param mixed|null $data
     * @param string|null $message
     * @param int $code
     * @return array
     * @throws HttpException
     */
    #[ArrayShape(["status" => "bool", "data" => "mixed", "message" => "null|string", "code" => "int"])] public static function responseJson(bool $status = true, mixed $data = null, string|null $message = "", int $code = 200): array
    {
        if ($code != 200) {
            throw new HttpException($code, $message, $code);
        }
        if ($data instanceof DataProviderInterface) {
            $serializer = new Serializer(['collectionEnvelope' => 'items']);
            $data = $serializer->serialize($data);
        }
        return [
            "status" => $status,
            "data" => $data,
            "message" => $message,
            "code" => $code
        ];
    }
}

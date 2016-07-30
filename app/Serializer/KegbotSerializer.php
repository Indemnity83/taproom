<?php

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class KegbotSerializer extends ArraySerializer
{

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return ['object' => $data, 'meta' => ['status' => 'ok']];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return ['object' => $data, 'meta' => ['status' => 'ok']];
    }
}

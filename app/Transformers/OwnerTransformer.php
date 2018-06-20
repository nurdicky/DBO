<?php

namespace App\Transformers;

use App\Owner;
use League\Fractal\TransformerAbstract;

class OwnerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Owner $owner)
    {
        return [
            'id'        => $owner->id,
            'nama'      => $owner->owner_name,
            'nomor_ktp' => $owner->owner_identity_number,
            'alamat'    => $owner->owner_address,
            'image'     => $owner->owner_avatar,
        ];
    }
}

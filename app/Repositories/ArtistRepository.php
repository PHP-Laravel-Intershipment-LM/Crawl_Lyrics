<?php

namespace App\Repositories;

use App\Models\Artist;
use InfyOm\Generator\Common\BaseRepository;

class ArtistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'wid',
        'name',
        'link'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Artist::class;
    }
}

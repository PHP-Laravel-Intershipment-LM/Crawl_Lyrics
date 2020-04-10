<?php

namespace App\Repositories;

use App\Models\Song;
use InfyOm\Generator\Common\BaseRepository;

class SongRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'wid',
        'name',
        'links',
        'lyric'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Song::class;
    }
}

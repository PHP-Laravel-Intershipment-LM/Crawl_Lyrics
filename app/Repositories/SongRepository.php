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
        'title',
        'artist',
        'duration',
        'listen',
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

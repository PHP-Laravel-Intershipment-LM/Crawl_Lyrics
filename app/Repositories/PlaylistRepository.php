<?php

namespace App\Repositories;

use App\Models\Playlist;
use InfyOm\Generator\Common\BaseRepository;

class PlaylistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'wid',
        'sid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Playlist::class;
    }
}

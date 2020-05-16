<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Song",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sid",
 *          description="sid",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="lyric",
 *          description="lyric",
 *          type="string"
 *      )
 * )
 */
class Song extends Model
{
    use SoftDeletes;

    public $table = 'songs';
    

    protected $dates = ['deleted_at'];


    public $timestamps = false;


    public $fillable = [
        'id',
        'wid',
        'title',
        'artist',
        'duration',
        'listen',
        'lyric'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'lyric' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}

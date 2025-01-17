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
 *          property="links",
 *          description="links",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="lyric",
 *          description="lyric",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Song extends Model
{
    use SoftDeletes;

    public $table = 'songs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'wid',
        'name',
        'links',
        'lyric'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'links' => 'string',
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

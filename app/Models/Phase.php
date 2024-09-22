<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Phase
 * @package App\Models
 * @version July 20, 2023, 1:03 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $timesheets
 * @property string $name
 * @property string $details
 * @property string $amounts
 */
class Phase extends Model
{

    use HasFactory;

    public $table = 'phases';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'details',
        'amounts',
        'completion'
    ];

    const COMPLETION_OPTIONS = [
        0 => '0%',
        15 => '15%',
        30 => '30%',
        100 => '100%',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'details' => 'string',
        'amounts' => 'string',
        'completion' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'details' => 'required|string',
        'amounts' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'completion' => 'nullable|integer|in:0,15,30,45,60,75,90,100'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

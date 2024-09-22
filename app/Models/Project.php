<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Project
 * @package App\Models
 * @version July 20, 2023, 1:02 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $timesheets
 * @property string $name
 */
class Project extends Model
{

    use HasFactory;

    public $table = 'projects';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'completion',
        'payment_status'    
    ];

    const COMPLETION_OPTIONS = [
        0 => '0%',
        15 => '15%',
        30 => '30%',
        100 => '100%',
    ];

    const PAYMENT_STATUS_OPTIONS = [
        'Paid' => 'Paid',
        'Pending' => 'Pending',
        'Overdue' => 'Overdue',
        'Not Applicable' => 'Not Applicable',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'completion' => 'integer',
        'payment_status' => 'string'    
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'completion' => 'nullable|integer|in:0,15,30,45,60,75,90,100',
        'payment_status' => 'nullable|string|in:Paid,Pending,Overdue,Not Applicable',    
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function phases()
    {
        return $this->hasMany(Phase::class);
    }
}

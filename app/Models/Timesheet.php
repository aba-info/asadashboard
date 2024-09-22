<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Timesheet
 * @package App\Models
 * @version July 20, 2023, 1:03 pm UTC
 *
 * @property \App\Models\Phase $phase
 * @property \App\Models\Project $project
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $phase_id
 * @property string $details
 * @property number $time_spent
 */
class Timesheet extends Model
{

    use HasFactory;

    public $table = 'timesheets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'project_id',
        'phase_id',
        'details',
        'time_spent_hours',
        'time_spent_minutes',
        'start_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'project_id' => 'string',
        'phase_id' => 'string',
        'details' => 'string',
        'time_spent_hours' => 'integer',
        'time_spent_minutes' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'project_id' => 'required',
        'phase_id' => 'required',
        'details' => 'required|string',
        'time_spent_hours' => 'required|numeric',
        'time_spent_minutes' => 'required|numeric',
        'start_date' => 'required|date_format:Y-m-d',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Accessor for the 'time' attribute.
     *
     * @return string
     */
    public function getTimeAttribute()
    {
        $hours = $this->time_spent_hours;
        $minutes = $this->time_spent_minutes;

        // Combine hours and minutes and format as a two-digit string
        $time = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $time;
    }

    /**
     * Accessor for the 'formatted_start_date' attribute.
     *
     * @return string
     */
    public function getFormattedStartDateAttribute()
    {
        $start_date_f = $this->attributes['start_date'];
        $dateComponents = explode('-', $start_date_f);

        if (count($dateComponents) === 3) {
            list($year, $month, $day) = $dateComponents;
            return sprintf('%02d/%02d/%04d', $month, $day, $year);
        }

        return $start_date_f;
    }
}

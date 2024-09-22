<?php

namespace App\Repositories;

use App\Models\Timesheet;
use App\Repositories\BaseRepository;

/**
 * Class TimesheetRepository
 * @package App\Repositories
 * @version July 20, 2023, 1:03 pm UTC
*/

class TimesheetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'project_id',
        'phase_id',
        'details',
        'time_spent'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Timesheet::class;
    }
}

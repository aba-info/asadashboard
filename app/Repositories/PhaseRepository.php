<?php

namespace App\Repositories;

use App\Models\Phase;
use App\Repositories\BaseRepository;

/**
 * Class PhaseRepository
 * @package App\Repositories
 * @version July 20, 2023, 1:03 pm UTC
*/

class PhaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'details',
        'amounts'
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
        return Phase::class;
    }
}

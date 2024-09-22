<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTimesheetRequest;
use App\Http\Requests\UpdateTimesheetRequest;
use App\Repositories\TimesheetRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Helpers\DatabaseHelper;

use Google_Service_Exception;
use Illuminate\Http\JsonResponse;

use App\Models\Timesheet;

class TimesheetController extends AppBaseController
{
    /** @var TimesheetRepository $timesheetRepository*/
    private $timesheetRepository;
    private $googleSheetController;

    public function __construct(TimesheetRepository $timesheetRepo, GoogleSheetController $googleSheetController)
    {
        $this->timesheetRepository = $timesheetRepo;
        $this->googleSheetController = $googleSheetController;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Timesheet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $query = Timesheet::query();
        $query = $this->filter($query, $request);

        $timesheets = $query->get();
        
        $projects = $this->googleSheetController->fetchProjectsNamesFromGoogleSheets();
        $phasesNames = $this->googleSheetController->fetchPhasesNamesFromGoogleSheets();
        if (!empty($request->input("project_search")))
            $phases = $this->googleSheetController->fetchPhasesFromGoogleSheets($request->input("project_search"));
        else
            $phases = array();


        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');


        return view('timesheets.index')
            ->with('timesheets', $timesheets)
            ->with('users', $users)
            ->with('phases', $phases)
            ->with('phasesNames', $phasesNames)
            ->with('projects', $projects);
    }

    /**
     * Display a listing of the Timesheet grouped by project
     *
     * @return Response
     */
    public function showbyproject()
    {
        $timesheets = $this->timesheetRepository->all();

        $groupedTimesheets = [];

        foreach ($timesheets as $timesheet) {
            $projectName = $timesheet->project_id;

            if (!isset($groupedTimesheets[$projectName])) {
                $groupedTimesheets[$projectName] = [];
            }

            $groupedTimesheets[$projectName][$timesheet->phase_id][] = $timesheet;
            $phaseCompletion = $this->googleSheetController->fetchPhaseCompletionFromGoogleSheets($projectName, $timesheet->phase_id);
            $phasesCompletions[$projectName][$timesheet->phase_id] =  is_array($phaseCompletion) && !empty($phaseCompletion[25]) ? $phaseCompletion[25] : '0';
        }

        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');

        $projects = $this->googleSheetController->fetchProjectsFromGoogleSheets();

        return view('timesheets.byproject')
            ->with('groupedTimesheets', $groupedTimesheets)
            ->with('phasesCompletions', $phasesCompletions)
            ->with('projects', $projects)
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new Timesheet.
     *
     * @return Response
     */
    public function create()
    {

        $projects = $this->googleSheetController->fetchProjectsNamesFromGoogleSheets();
        $phases = array(); //hasn't been chosen yet
        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');

        $lastUsedStartDate = null;

        if (auth()->check()) {
            $lastUsedStartDate = Timesheet::where('user_id', auth()->user()->id)
                ->orderBy('start_date', 'desc')
                ->value('start_date');
        }

        return view('timesheets.create', compact('projects', 'users', 'phases', 'lastUsedStartDate'));
    }

    /**
     * Store a newly created Timesheet in storage.
     *
     * @param CreateTimesheetRequest $request
     *
     * @return Response
     */
    public function store(CreateTimesheetRequest $request)
    {
        $input = $request->all();

        $timesheet = $this->timesheetRepository->create($input);

        Flash::success('Timesheet saved successfully.');

        return redirect(route('timesheets.index'));
    }

    /**
     * Display the specified Timesheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $timesheet = $this->timesheetRepository->find($id);
        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');

        if (empty($timesheet)) {
            Flash::error('Timesheet not found');

            return redirect(route('timesheets.index'));
        }
        return view('timesheets.show', compact('timesheet', 'users'));
    }

    /**
     * Show the form for editing the specified Timesheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {


        $timesheet = $this->timesheetRepository->find($id);
        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');
        $projects = $this->googleSheetController->fetchProjectsNamesFromGoogleSheets();
        $phases = $this->googleSheetController->fetchPhasesFromGoogleSheets($timesheet->project_id);

        if (empty($timesheet)) {
            Flash::error('Timesheet not found');

            return redirect(route('timesheets.index'));
        }

        return view('timesheets.edit', compact('phases', 'projects', 'users', 'timesheet'));
    }

    /**
     * Update the specified Timesheet in storage.
     *
     * @param int $id
     * @param UpdateTimesheetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTimesheetRequest $request)
    {
        $timesheet = $this->timesheetRepository->find($id);

        if (empty($timesheet)) {
            Flash::error('Timesheet not found');

            return redirect(route('timesheets.index'));
        }

        $timesheet = $this->timesheetRepository->update($request->all(), $id);

        Flash::success('Timesheet updated successfully.');

        return redirect(route('timesheets.index'));
    }

    /**
     * Remove the specified Timesheet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $timesheet = $this->timesheetRepository->find($id);

        if (empty($timesheet)) {
            Flash::error('Timesheet not found');

            return redirect(route('timesheets.index'));
        }

        $this->timesheetRepository->delete($id);

        Flash::success('Timesheet deleted successfully.');

        return redirect(route('timesheets.index'));
    }

    public function fetchPhases(Request $request)
    {
        try {
            $projectName = $request->input('projectName');

            $phases = $this->googleSheetController->fetchPhasesFromGoogleSheets($projectName);

            return response()->json($phases);
        } catch (Google_Service_Exception  $e) {
            $errorMessage = "no available phases for the project";
            return array($errorMessage);
        }
    }

    public function filter($query, Request $request)
    {

        // Filter by project
        if ($request->has('project_search')  && !empty($request->input('project_search'))) {
            $projectId = $request->input('project_search');
            $query->where('project_id', $projectId);
        }

        // Filter by phase
        if ($request->has('phase_id')  && !empty($request->input('phase_id'))) {
            $phaseId = $request->input('phase_id');
            $query->where('phase_id', $phaseId);
        }

        // Filter by user
        if ($request->input('user') !== 'all') {
            $query->where('user_id', $request->input('user') ?? auth()->user()->id);
        }

        // Filter by details
        if ($request->has('details') && !empty($request->input('details'))) {
            $detailsKeyword = $request->input('details');
            $query->where('details', 'like', '%' . $detailsKeyword . '%');
        }

        // Apply date filter if provided
        // Apply date range filter if provided
        if (
            $request->has('start_date') && $request->has('end_date') &&
            !empty($request->input('start_date')) && !empty($request->input('end_date'))
        ) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereDate('start_date', '>=', $startDate)
                ->whereDate('start_date', '<=', $endDate);
        } elseif (!empty($request->input('start_date'))) {
            $query->whereDate('start_date', '>=', $request->input('start_date'));
        } elseif (!empty($request->input('end_date'))) {
            $query->whereDate('start_date', '<=', $request->input('end_date'));
        } else {
            $query->whereDate('start_date', '>=', now()->subMonths(1));
        }

        return $query->orderBy('start_date', 'desc');
    }
}

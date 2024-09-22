<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Repositories\PhaseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PhaseController extends AppBaseController
{
    /** @var PhaseRepository $phaseRepository*/
    private $phaseRepository;
    private $googleSheetController;

    public function __construct(PhaseRepository $phaseRepo, GoogleSheetController $googleSheetController)
    {
        $this->phaseRepository = $phaseRepo;
        $this->googleSheetController = $googleSheetController;
        $this->middleware('auth');   
    }

    /**
     * Display a listing of the Phase.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $phases = $this->phaseRepository->all();

        return view('phases.index')
            ->with('phases', $phases);
    }

    /**
     * Show the form for creating a new Phase.
     *
     * @return Response
     */
    public function create()
    { 
        return view('phases.create');
    }

    /**
     * Store a newly created Phase in storage.
     *
     * @param CreatePhaseRequest $request
     *
     * @return Response
     */
    public function store(CreatePhaseRequest $request)
    {
        $input = $request->all();

        try {
            $projectName = $request->input('project');
            $phaseName = $request->input('name');

            $phases = $this->googleSheetController->addPhaseToGoogleSheets($projectName, $phaseName);

            if( response()->json($phases) )
                return redirect(route('closeTab'));
        } catch (Google_Service_Exception  $e) {
            $errorMessage = "no available phases for the project";
            return array($errorMessage);
        }

    }

    /**
     * Display the specified Phase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $phase = $this->phaseRepository->find($id);

        if (empty($phase)) {
            Flash::error('Phase not found');

            return redirect(route('phases.index'));
        }

        return view('phases.show')->with('phase', $phase);
    }

    /**
     * Show the form for editing the specified Phase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit()
    {
        //$phase = $this->phaseRepository->find($id);

        $project = $_GET['project'];
        $phase = $_GET['phase'];
        
        if (empty($project) || empty($phase)) {
            Flash::error('Phase not found');

            return redirect(route('phases.index'));
        }

        $phase = $this->googleSheetController->fetchPhaseCompletionFromGoogleSheets($project,$phase);        

        return view('phases.edit')->with('phase', $phase);
    }

    /**
     * Update the specified Phase in storage.
     *
     * @param int $id
     * @param UpdatePhaseRequest $request
     *
     * @return Response
     */
    public function update(UpdatePhaseRequest $request)
    {
        //$phase = $this->phaseRepository->find($id);

        if (empty($_POST["name"])) {
            Flash::error('Phase not found');

            return redirect(route('showbyproject'));
        }

       // $phase = $this->phaseRepository->update($request->all(), $id);

        if($this->googleSheetController->updatePhase($_POST["name"],$_POST["project"],$_POST["completion"]))
            Flash::success('Phase successfully updated.');

        return redirect(route('showbyproject'));
    }

    /**
     * Remove the specified Phase from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $phase = $this->phaseRepository->find($id);

        if (empty($phase)) {
            Flash::error('Phase not found');

            return redirect(route('phases.index'));
        }

        $this->phaseRepository->delete($id);

        Flash::success('Phase deleted successfully.');

        return redirect(route('phases.index'));
    }
}

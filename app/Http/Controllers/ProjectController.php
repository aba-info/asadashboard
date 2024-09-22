<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\ProjectRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Helpers\TimesheetsHelper;

class ProjectController extends AppBaseController
{
    /** @var ProjectRepository $projectRepository*/
    private $projectRepository;
    private $googleSheetController;

    public function __construct(ProjectRepository $projectRepo, GoogleSheetController $googleSheetController)
    {
        $this->projectRepository = $projectRepo;
        $this->googleSheetController = $googleSheetController;
        $this->middleware('auth');   
    }

    /**
     * Display a listing of the Project.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
//        $projects = $this->projectRepository->all(); DATABASE VERSION
        $projects = $this->googleSheetController->fetchProjectsNamesFromGoogleSheets();

        return view('projects.index')
            ->with('projects', $projects);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return Response
     */
    public function create()
    {               
        $projects = $this->googleSheetController->fetchProjectsFromGoogleSheets();
        
        $project = TimesheetsHelper::projectByName($projects,$_GET['project']);

        return view('projects.create')
        ->with('project',$project);
    }

    /**
     * Store a newly created Project in storage.
     *
     * @param CreateProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        $input = $request->all();
        
        //$project = $this->projectRepository->create($input);
        if($this->googleSheetController->updateProject($input["name"],$input["completion"],$input["payment"]))
            Flash::success('Project successfully updated.');

        return redirect(route('showbyproject'));
    }

    /**
     * Display the specified Project.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        return view('projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        return view('projects.edit')->with('project', $project);
    }

    /**
     * Update the specified Project in storage.
     *
     * @param int $id
     * @param UpdateProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectRequest $request)
    {
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        $project = $this->projectRepository->update($request->all(), $id);

        Flash::success('Project updated successfully.');

        return redirect(route('projects.index'));
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('projects.index'));
        }

        $this->projectRepository->delete($id);

        Flash::success('Project deleted successfully.');

        return redirect(route('projects.index'));
    }
}

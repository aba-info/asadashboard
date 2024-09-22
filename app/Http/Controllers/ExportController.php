<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Helpers\TimesheetsHelper;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use PDF;

class ExportController extends AppBaseController
{
    private $timesheetController;

    public function __construct(TimesheetController $timesheetController)
    {
        $this->timesheetController = $timesheetController;
    }


    public function timesheetsExportCSV(Request $request)
    {

        $query = Timesheet::query();

        $query = $this->timesheetController->filter($query, $request);

        $timesheets = $query->get();

        $csv = Writer::createFromString('');
        $csv->insertOne(['User Id', 'Project', 'Phase', 'Details', 'Task Start Date', 'Time Spent']);

        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');

        //TODO: unify this function
        $totalHours = 0;
        $totalMinutes = 0;

        foreach ($timesheets as $timesheet) {
            $csv->insertOne([
                $users[$timesheet->user_id],
                $timesheet->project_id,
                $timesheet->phase_id,
                $timesheet->details,
                $timesheet->getFormattedStartDateAttribute() ,
                $timesheet->time,
            ]);

            // Calculate total hours and minutes
            $totalHours += $timesheet->time_spent_hours;
            $totalMinutes += $timesheet->time_spent_minutes;

        }
        
        $csv->insertOne(['Task Duration:', TimesheetsHelper::calculateTime($totalHours, $totalMinutes)]);

        $csvFileName = now()->format('Y-m-d') . '_' . strtolower(str_replace(" ", "_", auth()->user()->name)) . '_timesheets_export.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        // Save the CSV to a temporary file and return it as a download
        $csvContents = $csv->getContent();
        $tempFilePath = tempnam(sys_get_temp_dir(), 'timesheets_export');
        file_put_contents($tempFilePath, $csvContents);

        return response()->download($tempFilePath, $csvFileName, $headers);
    }

    public function timesheetsExportPDF(Request $request)
    {
        // Retrieve and filter timesheet data
        $query = Timesheet::query();
        $query = $this->timesheetController->filter($query, $request);
        $timesheets = $query->get();

        // Load other necessary data

        $users = DatabaseHelper::pluckFromDatabase('users', 'name', 'id');

        // Create a PDF instance using dompdf
        $pdf = PDF::loadView('pdf.timesheets', compact('timesheets','users'));

        // Set PDF filename
        $pdfFileName = now()->format('Y-m-d') . '_' . strtolower(str_replace(" ", "_", auth()->user()->name)) . '_timesheets_export.pdf';

        // Return the PDF as a download response
        return $pdf->download($pdfFileName);
    }
}

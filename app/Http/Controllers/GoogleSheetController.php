<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Google_Service_Sheets_AddSheetRequest;
use Google_Service_Sheets_SheetProperties;


class GoogleSheetController extends Controller
{
    //TODO: move to .env files this data
    const PROJECT_SPREADSHEET_ID = "151-a8h4D1yRKg_rpj-LllUVpzKQHyN8-CfYqZP3hBQw";
    const PROJECT_SPREADSHEET_SHEET = "PROJECTS";
    const PHASES_SPREADSHEET_SHEET = "PHASES";
    const PHASE_SPREADSHEET_ID = "1qqy42v4EcTk6SaPmaGCDDibp1kL_IXDXNnoK7q2GXps";

    /**
     * Initialize and return a Google Sheets service client.
     *
     * @return Google_Service_Sheets
     */
    private function initializeGoogleSheetsClient()
    {
        $client = new \Google_Client();

        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('../storage/googleapicredentials.json');

        return new Google_Service_Sheets($client);
    }

    /**
     * Check if a row toexists.
     *
     * @param string $sheetName
     * @return bool
     */
    private function checkSheetExistence($sheetNameToCheck)
    {
        $service = $this->initializeGoogleSheetsClient();
        $spreadsheetId = self::PHASE_SPREADSHEET_ID;
        $result = false;
        try {
            $spreadsheet = $service->spreadsheets->get($spreadsheetId);

            foreach ($spreadsheet->getSheets() as $sheet) {
                if ($sheet->properties->title === $sheetNameToCheck) {
                    $result = true;
                    break;
                }
            }

            return $result;
        } catch (Google_Service_Exception $e) {
            return $result;
        }
    }

    /**
     * Create a new tab.
     *
     * @param string $newSheetTitle
     * @return bool
     */
    private function createSheet($newSheetTitle)
    {
        $service = $this->initializeGoogleSheetsClient();
        $spreadsheetId = self::PHASE_SPREADSHEET_ID;
        $result = false;

        try {

            $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(
                array(
                    'requests' => array(
                        'addSheet' => array(
                            'properties' => array(
                                'title' => $newSheetTitle
                            )
                        )
                    )
                )
            );

            $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            if ($response->getReplies()[0]->getAddSheet()->getProperties()->getTitle() === $newSheetTitle) {

                $result = true;
            }
            return $result;
        } catch (Google_Service_Exception $e) {
            return $result;
        }
    }

    /**
     * Add a new row to the end of a Google Sheets spreadsheet.
     *
     * @param string $spreadsheetId
     * @param string $sheetName
     * @param array $rowData
     * @return bool
     */
    private function addRowToEndOfGoogleSheets($spreadsheetId, $sheetName, $rowData)
    {
        try {
            $service = $this->initializeGoogleSheetsClient();

            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues([$rowData]);

            if (!self::checkSheetExistence($sheetName))
                self::createSheet($sheetName);

            $range = $sheetName . "!A:A";

            $valueRange->setMajorDimension("ROWS");

            // APPEND option
            $insertOption = [
                "insertDataOption" => "INSERT_ROWS",
            ];
            $params = [
                "valueInputOption" => "RAW",
            ];
            $result = $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $params, $insertOption);

            // Check if the row was successfully added
            if ($result->getUpdates()->getUpdatedRows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Google_Service_Exception $e) {
            return false;
        }
    }

    /**
     * Fetch projects from Google Sheets
     *
     * @return array
     */
    public function fetchProjectsFromGoogleSheets()
    {
        $service = $this->initializeGoogleSheetsClient();

        $spreadsheetId = self::PROJECT_SPREADSHEET_ID;
        $projectsRange = self::PROJECT_SPREADSHEET_SHEET . "!A:C";

        // Request to get data from spreadsheet.
        $projectsReq = $service->spreadsheets_values->get($spreadsheetId, $projectsRange);

        return $projectsReq->values;
    }

    /**
     * Fetch phases from Google Sheets
     *
     * @return array
     */
    public function fetchPhasesFromDataGoogleSheets()
    {
        $service = $this->initializeGoogleSheetsClient();

        $spreadsheetId = self::PROJECT_SPREADSHEET_ID;
        $projectsRange = self::PHASES_SPREADSHEET_SHEET . "!A:C";

        // Request to get data from spreadsheet.
        $projectsReq = $service->spreadsheets_values->get($spreadsheetId, $projectsRange);

        return $projectsReq->values;
    }

    /**
     * Fetch projects names from Google Sheets
     * TODO: we could call just the first column 
     * @return array
     */
    public function fetchProjectsNamesFromGoogleSheets()
    {
        return array_column(self::fetchProjectsFromGoogleSheets(), 0);
    }

    /**
     * Fetch projects names from Google Sheets
     * TODO: we could call just the first column 
     * @return array
     */
    public function fetchPhasesNamesFromGoogleSheets()
    {
        return array_column(self::fetchPhasesFromDataGoogleSheets(), 0);
    }

    /**
     * Fetch phases from Google Sheets
     *
     * @return array
     */
    public function fetchPhaseCompletionFromGoogleSheets($project, $phase)
    {
        $service = $this->initializeGoogleSheetsClient();

        $spreadsheetId = self::PHASE_SPREADSHEET_ID;
        $phasesCompletionRange = $project . "!A:Z";

        $i = 0;
        $phaseSearch = null;

        if (self::checkSheetExistence($project)) {
            // Request to get data from spreadsheet.
            $phasesReq = $service->spreadsheets_values->get($spreadsheetId, $phasesCompletionRange);
            $everyPhase = $phasesReq->values;

            while ($i < count($everyPhase) && $phaseSearch == null) {
                if (!empty($everyPhase[$i][0]) && $everyPhase[$i][0] == $phase)
                    $phaseSearch = $everyPhase[$i];
                $i++;
            }
        }

        return $phaseSearch;
    }

    /**
     * Fetch phases from Google Sheets based on a project name.
     *
     * @param string $projectName
     * @return array|null
     */
    public function fetchPhasesFromGoogleSheets($projectName)
    {

        $service = $this->initializeGoogleSheetsClient();

        $spreadsheetId = self::PHASE_SPREADSHEET_ID;
        $phasesRange = $projectName . "!A:A";
        $phases = array("no available phases for the project");
        
        if ( $this->checkSheetExistence($projectName) ) {
            $phasesReq = $service->spreadsheets_values->get($spreadsheetId, $phasesRange);
            $values = $phasesReq->getValues();

            if (!empty($values))
                $phases = array_column($phasesReq->getValues(), 0);
        }

        return $phases;
    }

    /**
     * Add phase to Google Sheets
     *
     * @param string $phaseName
     * @return boolean
     */
    public function addPhaseToGoogleSheets($projectName, $phaseName)
    {
        $result = false;
        $spreadsheetId = self::PHASE_SPREADSHEET_ID;
        $sheetName = $projectName;
        $rowData = [
            $phaseName
        ];

        if ($this->addRowToEndOfGoogleSheets($spreadsheetId, $sheetName, $rowData)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Update a a project in Google Sheets
     *
     * @param string $name
     * @param string $completion
     * @param string $payment
     * @return boolean
     */
    public function updateProject($name, $completion, $payment)
    {
        $result = false;

        if (self::updateSheetColumn("project", $name, $completion, "B") && self::updateSheetColumn("project", $name, $payment, "C"))
            $result = true;

        return $result;
    }

    /**
     * Update a a phase in Google Sheets
     *
     * @param string $phase
     * @param string $project
     * @param string $completion
     * @return boolean
     */
    public function updatePhase($phase, $project, $completion)
    {
        $result = false;

        if (self::updateSheetColumn("phase", $phase, $completion, "Z", $project))
            $result = true;

        return $result;
    }

    /**
     * Update data to Projects on Google Sheets
     *
     * @param string $type // project or phase, the two main project objects
     * @param string $projectName
     * @param string $value
     * @return boolean
     */
    public function updateSheetColumn($type, $projectName, $value, $column, $sheet = null)
    {
        $result = false;

        $service = $this->initializeGoogleSheetsClient();

        if ($type == "project") {
            $spreadsheetId = self::PROJECT_SPREADSHEET_ID;
            $sheetName = self::PROJECT_SPREADSHEET_SHEET;
        } else {
            $spreadsheetId = self::PHASE_SPREADSHEET_ID;
            $sheetName = $sheet;
        }

        $searchColumnIndex = 0;
        $searchValue = $projectName;
        $valueToAdd = $value;

        $response = $service->spreadsheets_values->get($spreadsheetId, $sheetName);
        $values = $response->getValues();

        $rowToUpdate = null;
        foreach ($values as $index => $row) {
            if (isset($row[$searchColumnIndex]) && $row[$searchColumnIndex] === $searchValue) {
                $rowToUpdate = $index;
                break;
            }
        }

        if ($rowToUpdate !== null) {
            $rangeToUpdate = $sheetName . '!' . $column . ($rowToUpdate + 1);

            $valuesToUpdate = [
                [$valueToAdd]
            ];

            $body = new Google_Service_Sheets_ValueRange([
                'values' => $valuesToUpdate
            ]);

            $params = [
                'valueInputOption' => 'RAW'
            ];

            if ($service->spreadsheets_values->update($spreadsheetId, $rangeToUpdate, $body, $params))
                $result = true;
        }

        return $result;
    }
}

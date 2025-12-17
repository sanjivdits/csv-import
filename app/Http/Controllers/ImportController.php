<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use Illuminate\Http\Request;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function parseImport(CsvImportRequest $request)
    {
        $headings = (new HeadingRowImport)->toArray($request->file('csv_file'));

        $fileName = time().'.'.$request->csv_file->extension();  
        $request->csv_file->move(storage_path().'/csv/', $fileName);
        $file_path = storage_path() .'/csv/'. $fileName;

        $csvData = fopen($file_path, 'r');
        $transRow = true;
        $data =[];
        while (($dataRow = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                $data[] = $dataRow;
            }
            $transRow = false;
        }
        fclose($csvData);


        if (count($data) > 0) {
            $csv_data = array_slice($data, 0, 1);
        } else {
            return redirect()->back();
        }

        return view('import_fields', [
            'headings' => $headings,
            'csv_data' => $csv_data,
            'csv_data_file' => $file_path
        ]);
    }

    public function processImport(Request $request)
    {

        print_r($request->all()); die;
       

        $csvData = fopen($request->csv_data_file_id, 'r');
        $transRow = true;
        $csv_data =[];
        while (($dataRow = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                $csv_data[] = $dataRow;
            }
            $transRow = false;
        }
        fclose($csvData);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            
            foreach (config('app.db_fields') as $index => $field) {
                $keyIndex = array_search($field, $request->fields);
                if($keyIndex != ''){

                    $contact->$field = $row[$keyIndex];
                }
                
            }
            $contact->user_id =  Auth::id();
            $contact->save();
        }

        //delete file from server
        unlink($request->csv_data_file_id);
        $message = count($csv_data).' records saved with list of records of current user.';
        return redirect()->route('contacts.index')->with('success', $message);
    }
}
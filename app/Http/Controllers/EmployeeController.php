<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EmployeeModel;
use Illuminate\Http\Request;
use App\Models;
use Carbon\Carbon;
use Session;

class EmployeeController extends Controller
{

    public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()    
    {  
        $data=  EmployeeModel::query()->get();

        return view('HR.employees.index')->with("data",$data);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('HR.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['employment_id' => 'required', 'first_name' => 'required', 'last_name' => 'required', 'date_of_birth' => 'required', 'gender' => 'required', 'maratial_status' => 'required', 'father_name' => 'required', 'nationality' => 'required', 'passport_number' => 'required', 'photo' => 'required', 'photo_a_path' => 'required', 'present_address' => 'required', 'city' => 'required', 'country_id' => 'required', 'mobile' => 'required', 'phone' => 'required', 'email' => 'required', 'designations_id' => 'required', 'joining_date' => 'required', 'status' => 'required', ]);

        EmployeeModel::create($request->all());

        Session::flash('flash_message', 'Employee added successfully!');

        return redirect('view_employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tblemployee = EmployeeModel::findOrFail($id);

        return view('crud.tblemployee.show', compact('tblemployee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tblemployee = EmployeeModel::findOrFail($id);

        return view('crud.tblemployee.edit', compact('tblemployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['employment_id' => 'required', 'first_name' => 'required', 'last_name' => 'required', 'date_of_birth' => 'required', 'gender' => 'required', 'maratial_status' => 'required', 'father_name' => 'required', 'nationality' => 'required', 'passport_number' => 'required', 'photo' => 'required', 'photo_a_path' => 'required', 'present_address' => 'required', 'city' => 'required', 'country_id' => 'required', 'mobile' => 'required', 'phone' => 'required', 'email' => 'required', 'designations_id' => 'required', 'joining_date' => 'required', 'status' => 'required', ]);

        $tblemployee = EmployeeModel::findOrFail($id);
        $tblemployee->update($request->all());

        Session::flash('flash_message', 'TblEmployee updated!');

        return redirect('tblemployee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        EmployeeModel::destroy($id);

        Session::flash('flash_message', 'TblEmployee deleted!');

        return redirect('tblemployee');
    }


    public function search(Request $request) {
        // $this->log_query();
        $table = (new EmployeeModel)->getTable();
        $table = '`' . str_replace("'", "", $table) . '`';
        // get column info from table
        $column_query = collect(\DB::select(\DB::raw("show full columns from " . $table)));
        //pick only the field and type
        $column_type_info = $column_query->pluck('Type', 'Field');

        // print_r($column_type_info['id']);
        $len = $request['length'];
        $start = $request['start'];
        $search_item = $request['search']['value'];
        // $query = \DB::table(\DB::raw($table));
        $query = EmployeeModel::query();
       //add columns to search
        foreach ($request['columns'] as $key => $column) {
            if ($column['searchable'] == "true") {
                if (str_contains($column_type_info[$column['data']], "blob") == false) {
                    $query->orWhere($column['data'], 'like', '%' . trim($search_item) . '%');
                }
            }
        }
        //add order to search by
        foreach ($request['order'] as $key => $value) {
            //get info abt column being used for ordering from requests["columns"]
            $request_column = $request["columns"][$value['column']];
            if ($request_column['orderable'] == "true") {
                $query->orderBy($request_column['data'], $value['dir']);

            }
        }

        // $total_table_records = \DB::table(\DB::raw($table))->count();
        $total_table_records = EmployeeModel::count();
        $query_results_total = $query->count();
        $query_results = $query->take($len)->skip($start)->get();
        $query_results = $query_results->toArray();
        // print_r($query_results);
        foreach ($query_results as $keys => $item) {
            foreach ($item as $key => $value) {
            //check for blob type in the search results and set it to empty string so it doesnt mess up the results with binary data
                if (str_contains($column_type_info[$key], "blob") == true) {
                    $query_results[$keys][$key] = "";
                }
                //highlight the search item in the results .
                $query_results[$keys][$key] = $this->color_search_results($search_item, $query_results[$keys][$key]);
            }
            //add the counter column to help with numbering
            $query_results[$keys]["thecounter"] = $keys + $start + 1;
            $query_results[$keys]["button_actions"] = $this->addButtonActions($query_results[$keys]['employee_id']);

        }

        $ret['data'] = $query_results;
        $ret['recordsTotal'] = $total_table_records;
        $ret['recordsFiltered'] = $query_results_total;
        $ret['draw'] = intval($request['draw']);

        return response()->json($ret);
    }

    public function addButtonActions($id) {
        $string = "<a href='" . route('tblemployee.edit', array($id)) . "' class='btn btn-primary btn-xs'>Edit</a>&nbsp;";
        $string .= "<a href='" . url('tblemployee', array($id)) . "' class='btn btn-primary btn-xs'>View</a>&nbsp;";
        return $string;
    }


public function color_search_results($str1, $str2) {
        $kwicLen = strlen($str1);

        $kwicArray = array();
        $pos = 0;
        $count = 0;

        while ($pos !== FALSE) {
            $pos = stripos($str2, $str1, $pos);
            if ($pos !== FALSE) {
                $kwicArray[$count]['kwic'] = substr($str2, $pos, $kwicLen);
                $kwicArray[$count++]['pos'] = $pos;
                $pos++;
            }
        }

        for ($I = count($kwicArray) - 1; $I >= 0; $I--) {
            $kwic = '<span style="background-color:yellow;">' . $kwicArray[$I]['kwic'] . '</span>';
            $str2 = substr_replace($str2, $kwic, $kwicArray[$I]['pos'], $kwicLen);
        }

        return ($str2);
    }


}

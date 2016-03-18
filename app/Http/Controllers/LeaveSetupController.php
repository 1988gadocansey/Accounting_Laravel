<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\LeaveSetUpModel;
use Illuminate\Http\Request;
use App\Models;
use Carbon\Carbon;
use Session;

class LeaveSetupController extends Controller
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
            $table = (new LeaveSetUpModel)->getTable();
        $table = '`' . str_replace("'", "", $table) . '`';
        $query = \DB::select(\DB::raw("show full columns from " . $table));
        //add properties or attributes for datatables
        //each table column has four main properties a)searchable, orderable, visible take true/false
        //b) title is used as the display title for the column when shown in the age
        $data =array();
        foreach ($query as $key => $value) {
            $value->searchable = true;
            $value->orderable = true;
            $value->visible = true;
            $value->title = $value->Field;

            if(str_contains($value->Type,"blob")){
            $value->searchable = false;
            $value->orderable = false;            
            }
            $data[$value->Field] = $value;
        }

        //hide and make id column unsearchable
        @$data['id']->searchable = false;
        @$data['id']->visible = false;
 return view('HR.leave.view_setup')->with("data",$data);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('HR.leave.add_setup')->with('leave', $this->types());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['type' => 'required', 'duration' => 'required', 'pay' => 'required', 'qualify' => 'required', ]);

          
        $leave=new  LeaveSetUpModel();
      
        $leave->Type = $request->input('type');
        $leave->Paid = $request->input('pay');
        $leave->duration = $request->input('duration');
        $leave->Working_Days = $request->input('qualify');
        $leave->note = $request->input('note');
        if($leave->save()){
        Session::flash('success_message', 'Leave Setup added!');

        return redirect('view_leave_setup');
      }
      else {
          Session::flash('error_message', 'Leave Setup Item exist!');

        return redirect('view_leave_setup');
      }
    }
    public function types() {

        $type = \DB::table('tbl_leave_category')
                ->lists('category', 'id');
        return $type;
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
        $tblleavesetup = LeaveSetUpModel::findOrFail($id);

        return view('HR.leave.view_setup', compact('tblleavesetup'));
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
        $data = LeaveSetUpModel::find($id);

        return view('HR.leave.edit_setup')->with('data', $data)->with('leave', $this->types());
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
        
        $tblleavesetup = LeaveSetUpModel::findOrFail($id);
        $tblleavesetup->update($request->all());

        Session::flash('success_message', 'Leave Setup Item updated!');

       return redirect('view_leave_setup');
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
        LeaveSetUpModel::destroy($id);

        Session::flash('success_message', 'Leave Setup Item deleted!');

        return redirect('view_leave_setup');
    }


   
   public function search(Request $request) {
        // $this->log_query();
        $table = (new LeaveSetUpModel)->getTable();
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
        $query = LeaveSetUpModel::query();
       //add columns to search
        foreach ($request['columns'] as $key => $column) {
            if ($column['searchable'] == "true") {
                if (str_contains($column_type_info[$column['data']], "blob") == false) {
                    $query->orWhere($column['data'], 'like', '%' . trim($search_item) . '%');
                }
            }
        }
        //add order to search by
        if($request->has('order')){
        foreach ($request['order'] as $key => $value) {
            //get info abt column being used for ordering from requests["columns"]
            $request_column = $request["columns"][$value['column']];
            if ($request_column['orderable'] == "true") {
                $query->orderBy($request_column['data'], $value['dir']);

            }
        }
        }
        // $total_table_records = \DB::table(\DB::raw($table))->count();
        $total_table_records = LeaveSetUpModel::count();
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
            $query_results[$keys]["button_actions"] = $this->addButtonActions($query_results[$keys]['id']);

        }

        $ret['data'] = $query_results;
        $ret['recordsTotal'] = $total_table_records;
        $ret['recordsFiltered'] = $query_results_total;
        $ret['draw'] = intval($request['draw']);

        return response()->json($ret);
    }

    public function addButtonActions($id) {
        $string = "<a href='". route('view_leave_setup.edit', array($id)) . "' class='btn btn-success btn-xs'>Edit</a>&nbsp;";
    
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

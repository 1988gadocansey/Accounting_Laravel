<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

 
use Illuminate\Http\Request;
use App\Models\LeaveModel;
use App\Models\EmployeeModel;
use App\Models\LeaveSetUpModel;
use App\Models\LeaveApplicationModel;
use Carbon\Carbon;
use Session;

class LeaveController extends Controller
{

    public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }

    public function viewLeave() {
        
        $table = (new LeaveApplicationModel)->getTable();
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
        

        return view('HR.leave.view_leaves')->with("data",$data);   
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()    
    {  
        $table = (new LeaveModel)->getTable();
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

        return view('HR.leave.categories')->with("data",$data);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('HR.leave.create');
    }
    public function createLeave(Request $request,$id)
    {
        $employee=new DepartmentController();
        $leaveType=new LeaveSetupController();
        
          
        // employee is in session
       
        $request->session()->put('employee', $id);
        
        
        $gad= EmployeeModel::where('id', $id)->get();
         
        
        if($request->has('type')){
         $request->session()->put('type', $request->input('type'));
        
        
        $leaveDetails=LeaveSetUpModel::where('Type', $request->input('type'))->first();
        //dd($leaveDetails->duration);
        
        }
        return view('HR.leave.leave_application')->with('employee', $employee->employees())
                ->with('leaveDetails', @$leaveDetails)->with('person', @$gad)
                ->with('type', $leaveType->types())->with('duration', @$leaveDetails->duration)
                ->with('pay', @$leaveDetails->Paid)
                ->with('qualify', @$leaveDetails->Working_Days)
               ->with('note', @$leaveDetails->note);
         
    }

    public function storeLeave(Request $request)
    {
        $this->validate($request, ['type' => 'required', 'duration' => 'required', 'reasons' => 'required', 'start' => 'required','employee' => 'required' ]);

          
        $leave=new  LeaveApplicationModel();
      
        $type=$request->input('type');
        $leaveType=\DB::table('tbl_leave_setup')->where('id',"$type")->get();
      /*dd($leaveType);
        foreach ($leaveType as $row => $value) {
            
          
            $leaveType[$row]->$duration = $value->duration; 
             $leaveType[$row]->$qualify = $value->Working_Days;
        }
        
        */
        
        
        $leave->Type = $request->input('type');
        $leave->Employee = $request->input('employee');
        $leave->Start= $request->input('start');
        $leave->Duration = $request->input('duration');
        $leave->Reasons = $request->input('reasons');
        $leave->Due = $request->input('end');
        
        // processing leave
       /* $empDuration=$request->input('duration');
        $startDuration=$request->input('start');
        $leaveDuration= $leaveType[$row]->$duration;
        $oldDate = \Carbon::create($startDuration);
        $newDate = $oldDate->addDays($leaveDuration);
        
        
        $date1=strtotime($newDate);
        $date2=strtotime($empDuration);
         
        $report=$date1-$date2;
        $report=date("d/m/Y",$report);
        
        */
        if($leave->save()){
        Session::flash('success_message', 'You will be reporting on  if your leave is approved');

        return redirect('view_leaves');
      }
      else {
          Session::flash('error_message', 'Error processing Leave Request!');

        return redirect('view_leaves');
      }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['category' => 'required', 'note' => 'required', ]);

        LeaveModel::create($request->all());

        Session::flash('success_message', 'Leave Category added!');

        return redirect('view_leave_category');
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
        $tblleavecategory = LeaveModel::findOrFail($id);

        return view('crud.tblleavecategory.show', compact('tblleavecategory'));
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
        $data = LeaveModel::findOrFail($id);

        return view('HR.leave.category_edit', compact('data'));
    }
    public function showLeaveEdit($id)
    {
        $data = LeaveApplicationModel::findOrFail($id);

        return view('HR.leave.edit_request', compact('data'));
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
        $this->validate($request, ['category' => 'required', 'note' => 'required', ]);

        $tblleavecategory = LeaveModel::findOrFail($id);
        $tblleavecategory->update($request->all());

        Session::flash('success_message', 'Leave Category updated!');

         return redirect('view_leave_category');
    }

    
    public function LeaveEdit($id, Request $request)
    {
        $this->validate($request, ['type' => 'required', 'duration' => 'required', 'reasons' => 'required', 'start' => 'required','employee' => 'required' ]);

        $leave = LeaveApplicationModel::findOrFail($id);
        $leave->update($request->all());

        Session::flash('success_message', 'Leave Request updated!');

         return redirect('view_leaves');
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
        LeaveModel::destroy($id);

        Session::flash('success_message', 'Leave Category deleted!');

         return redirect('view_leave_category');
    }

    
    public function destroyLeave($id)
    {
        LeaveApplicationModel::destroy($id);

        Session::flash('success_message', 'Leave Request deleted!');

         return redirect('view_leaves');
    }
    
    
    
     public function searchLeave(Request $request) {
            $table = (new LeaveApplicationModel)->getTable();
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
        $query = LeaveApplicationModel::query();
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
        $total_table_records = LeaveApplicationModel::count();
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
                $query_results[$keys][$key] = $this->color_search_results2($search_item, $query_results[$keys][$key]);
            }
            //add the counter column to help with numbering
            $query_results[$keys]["thecounter"] = $keys + $start + 1;
            $query_results[$keys]["button_actions"] = $this->addButtonActions2($query_results[$keys]['id']);

        }

        $ret['data'] = $query_results;
        $ret['recordsTotal'] = $total_table_records;
        $ret['recordsFiltered'] = $query_results_total;
        $ret['draw'] = intval($request['draw']);

        return response()->json($ret);
    }

    public function addButtonActions2($id) {
        $string = "<a href='" . url('edit_leaves/'.$id.'/edit') . "' class='btn btn-primary btn-xs'>Edit</a>&nbsp;";
        $string .= "<a onclick=\"return confirm('Are you sure you want to approve this leave')\" href='" . url('edit_leaves/'.$id.'/approve') . "' class='btn btn-success btn-xs'>Approve</a>&nbsp;";
      
        $string .= "<a onclick=\"return confirm('Are you sure you want to reject this leave')\" href='" . url('edit_leaves/'.$id.'/reject') . "' class='btn btn-danger btn-xs'>Reject</a>&nbsp;";
      
        
        return $string;
    }


public function color_search_results2($str1, $str2) {
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
    
    
    
    
    
    
    
    
    
    
    
    
   public function search(Request $request) {
        // $this->log_query();
        $table = (new LeaveModel)->getTable();
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
        $query = LeaveModel::query();
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
        $total_table_records = LeaveModel::count();
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
        $string = "<a href='" . route('view_leave_category.edit', array($id)) . "' class='btn btn-success btn-xs'>Edit</a>&nbsp;";
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

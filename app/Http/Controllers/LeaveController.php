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
        
          @$leave=$leaveType->types();
        // employee is in session
       
        $request->session()->put('employee', $id);
        
        
        $gad= EmployeeModel::where('id', $id)->get();
         
        
        if($request->has('type')){
         $request->session()->put('type', $request->input('type'));
        
         foreach($leave as $r){
             @$tt= $r;
         }
         
        $leaveDetails=LeaveSetUpModel::where('Type', $request->input('type'))->first();
        //dd($leaveDetails->duration);
        
        }
         
        return view('HR.leave.leave_application')->with('employee', $employee->employees())
                ->with('leaveDetails', @$leaveDetails)->with('person', @$gad)
                ->with('type', $leaveType->types())->with('duration', @$leaveDetails->duration)
                ->with('pay', @$leaveDetails->Paid)
                ->with('qualify', @$leaveDetails->Working_Days)
               ->with('note', @$leaveDetails->note)
                ->with('occurance', @$leaveDetails->occurance)
                ->with('leave',@$tt);
                 
         
    }

    public function storeLeave(Request $request)
    {
        $this->validate($request, ['type' => 'required', 'duration' => 'required', 'reasons' => 'required', 'start' => 'required','employee' => 'required' ]);

          
        $leave=new  LeaveApplicationModel();
      
        $type=$request->input('type');
        $leaveType=\DB::table('tbl_leave_setup')->where('id',"$type")->get();
     
        
        // first get info about employee 
        $emp=  $this->employee($request->input('employee'));
        foreach($emp as $ob=>$row){
            @$lastLeave=$row->last_leave_date;
            $status=$row->leaves;
        }
        // first check if employee is at post
       if($status=='on duty'){
           // second check wheather days between last leave and 
           // current leave is more than a 
         
         // difference between last leave and start of current leave is equal
         // to occurance then valid for processing
        
         $occurance= $request->input('occurance');
        // @$difference=  @$this->diffDays(  @$lastLeave,$request->input('start'));
         if($lastLeave==""){
             $leave->Type = $request->session()->get('type');
        $leave->Employee = $request->input('employee');
        $leave->Start= $request->input('start');
        $leave->Duration = $request->input('duration');
        $leave->Reasons = $request->input('reasons');
        
        $leave->Employee_Replaced_By = $request->input('replace');
         $dueDate=   Carbon::createFromFormat('d/m/Y', $request->input('start'));
         
         $dueDate->toDateTimeString();            // 2012-01-31 00:00:00

         $dueDate->addDays($request->input('duration')); 
         
         $leave->Due = $dueDate->format('d/m/Y');
        
        
            $report=$dueDate->format('d/m/Y');
         if($leave->save()){
             
         // update last leave on employee table
                    $employ = EmployeeModel::find($request->input('employee'));

                    $employ->last_leave_date = $report;
                    
                    $employ->save();
                    Session::flash('success_message', "You will be reporting on  <b>". $report. " </b> if your leave is approved");

           return redirect('view_leaves')->with('report',$report);
         }
         }
         else{
        
            @$today_dt = new \DateTime($request->input('start'));
            @$expire_dt = new \DateTime($lastLeave);

        // check so that employee does reply for leave while 
        // current leave is pending
        if ($today_dt < $expire_dt  ) { 
                
                 
        $leave->Type = $request->session()->get('type');
        $leave->Employee = $request->input('employee');
        $leave->Start= $request->input('start');
        $leave->Duration = $request->input('duration');
        $leave->Reasons = $request->input('reasons');
        
        $leave->Employee_Replaced_By = $request->input('replace');
         $dueDate=   Carbon::createFromFormat('d/m/Y', $request->input('start'));
         
         $dueDate->toDateTimeString();            // 2012-01-31 00:00:00

         $dueDate->addDays($request->input('duration')); 
         
         $leave->Due = $dueDate->format('d/m/Y');
        
        
            $report=$dueDate->format('d/m/Y');
         if($leave->save()){
             
         // update last leave on employee table
                    $employ = EmployeeModel::find($request->input('employee'));

                    $employ->last_leave_date = $report;
                    
                    $employ->save();
                    Session::flash('success_message', "You will be reporting on  <b>". $report. " </b> if your leave is approved");

           return redirect('view_leaves')->with('report',$report);
         }
            }
            else {
          Session::flash('error_message', 'Your leave cannot be process because you have a leave pending!');

        return redirect('view_leaves');
      }
       }
       
    }
      else {
          Session::flash('error_message', 'Your leave cannot be process because is invalid!');

        return redirect('view_leaves');
      }
    }
    function addDays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL) {
     $dueDate=   Carbon::createFromFormat('d/m/Y', $timestamp);
         
         $dueDate->toDateTimeString();            // 2012-01-31 00:00:00

        $dueDate->addDays($days); 
         $timestamp = $dueDate->format('Y-m-d');
      //echo $timestamp17=$timestamp1->date; 
      $i = 1;

        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
            if ( (in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates)) )
            {
                $days++;
            }
            $i++;
        }

       return date("d/m/Y",$timestamp);
    }
    
    public function diffDays($start1,$end1){
       $start1= new Carbon($start1);
        $end1=new Carbon($end1);
        if(!empty($end1)){
        @$start = new Carbon($start1);
        @$end = new Carbon($end1);
        @$difference = ($end->diff($start)->days < 1);
           if($difference>0){
         return $end->diffForHumans($start);
           }
           else{
               return 0;
           }
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
     public function approveLeave($approve, Request $request)
    {
            $employ = LeaveApplicationModel::find($approve);

            $employ->Status ='Approved';
            
            $employee=$employ->Employee;
            $employ->save();
            $employeeInfo=EmployeeModel::find($employee);
            $employeeInfo->leaves='On Leave';
            if($employeeInfo->save()){
           
                $sms=new SMSController();
                $message="Hi $employeeInfo->title $employeeInfo->Name $employeeInfo->surname your leave has been approved"
                        . "\n Starting on $employ->Start and Return date is $employ->Due. Thanks ";
                $sms->send_sms($employeeInfo->phone, $message);
                return redirect('view_leaves')->with('success_message', 'Leave has been approved and sms sent to employee');
            }
            else{
              return redirect('view_leaves')->with('error_message', 'Error in processing leave');
            }
             
    }
    public function rejectLeave($reject, Request $request)
    {
            $employ = LeaveApplicationModel::find($reject);

            $employ->Status ='Rejected';

            $employ->save();
            $employee=$employ->Employee;
            $employeeInfo=EmployeeModel::find($employee);
            $employeeInfo->leaves='on duty';
            if($employeeInfo->save()){
           
                $sms=new SMSController();
                $message="Hi $employeeInfo->title $employeeInfo->Name $employeeInfo->surname your leave has been rejected"
                        . "\n Contact HR for more clarification. Thanks ";
                $sms->send_sms($employeeInfo->phone, $message);
                return redirect('view_leaves')->with('success_message', 'Leave has been rejected');
            }
            else{
              return redirect('view_leaves')->with('error_message', 'Error in processing leave');
            }
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

    public function employee($id) {

        $employee = \DB::table('tbl_employee')
                ->where('id', $id)->get();
        return $employee;
    }
    
    public function destroyLeave($id)
    {
        LeaveApplicationModel::destroy($id);

        Session::flash('success_message', 'Leave Request deleted!');

         return redirect('view_leaves');
    }
    
    
    
     public function searchLeave(Request $request) {
         $this->log_query();
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
        $query->where(function($query) use($request,$column_type_info,$search_item){
            
             foreach ($request['columns'] as $key => $column) {
            if ($column['searchable'] == "true") {
                if (str_contains($column_type_info[$column['data']], "blob") == false) {
                    $query->orWhere($column['data'], 'like', '%' . trim($search_item) . '%');
                }
            }
        }
            
        });
       
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
       
        $query->with('employee','type','approval');
        $results = $query->get();
       \Log::info('a',array('as'=>$results));
         
       
        // $total_table_records = \DB::table(\DB::raw($table))->count();
        $total_table_records = LeaveApplicationModel::count();
        $query_results_total = $query->count();
        $query_results = $query->take($len)->skip($start)->get();
        $query_results = $query_results->toArray();
        // print_r($query_results);
        //dd($query_results);
        foreach ($query_results as $keys => $item) {
           
            foreach ($item as $key => $value) {
            //check for blob type in the search results and set it to empty string so it doesnt mess up the results with binary data
                if (isset($column_type_info[$key]) && !is_array($column_type_info[$key]) && str_contains($column_type_info[$key], "blob") == true) {
                    $query_results[$keys][$key] = "";
                }
                //highlight the search item in the results .
                if(!is_array($query_results[$keys][$key])){
                $query_results[$keys][$key] = $this->color_search_results2($search_item, $query_results[$keys][$key]);
            }
            }
            $query_results[$keys]["Employee"] = $query_results[$keys]["employee"]['Name']." ".$query_results[$keys]["employee"]['othernames'].' '.$query_results[$keys]["employee"]['surname'];
             
             $query_results[$keys]["Approved_By"] = $query_results[$keys]["employee"]['Name']." ".$query_results[$keys]["employee"]['othernames'].' '.$query_results[$keys]["employee"]['surname'];
          
             $query_results[$keys]["Employee_Replaced_By"] = $query_results[$keys]["employee"]['Name']." ".$query_results[$keys]["employee"]['othernames'].' '.$query_results[$keys]["employee"]['surname'];
          
            
            $query_results[$keys]["Type"] = $query_results[$keys]["type"]['category'] ;
          
             
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
        //$string = "<a href='" . url('edit_leaves/'.$id.'/edit') . "' class='btn btn-primary btn-xs'>Edit</a>&nbsp;";
        $string= "<a onclick=\"return confirm('Are you sure you want to approve this leave')\" href='" . url('check_leaves/'.$id.'/approve') . "' class='btn btn-success btn-xs'>Approve</a>&nbsp;";
      
        $string .= "<a onclick=\"return confirm('Are you sure you want to reject this leave')\" href='" . url('check_leaves/'.$id.'/reject') . "' class='btn btn-danger btn-xs'>Reject</a>&nbsp;";
      
        
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

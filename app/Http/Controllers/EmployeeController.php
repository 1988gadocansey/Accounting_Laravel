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
    public function index(Request $request)    
    {  
        
        $employee=  EmployeeModel::query() ;
        if ($request->has('search') && trim($request->input('search')) != "") {
           // dd($request);
            $employee->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
          }
          if ($request->has('department') && trim($request->input('department')) != "") {
                 $employee->where("department","LIKE","%".$request->input("department","")."%");
            }
            if ($request->has('grades') && trim($request->input('grades')) != "") {
                 $employee->where("grade","LIKE","%".$request->input("grades","")."%");
            }
            if ($request->has('position') && trim($request->input('position')) != "") {
                 $employee->where("position","=",$request->input("position",""));
            }
            if ($request->has('gender') && trim($request->input('gender')) != "") {
                 $employee->where("gender","=",$request->input("gender",""));
            }
            if ($request->has('leave') && trim($request->input('leave')) != "") {
                 $employee->where("leaves","=",$request->input("leave",""));
            }
             
            $data = $employee->paginate(100);
            \Session::put('employees', $data);
        return view('HR.employees.index')->with("data",$data)
                ->with('country', $this->countries())
                ->with('positions', $this->position())
                ->with('grades', $this->grades())
                ->with('departments', $this->department())
                ->with('designation', $this->designation());
        
    }
     
    public function sendSMS(Request $request){
        $query=\Session::get('employees');
        $sms= new SMSController();
        
        foreach($query as $rtmt=> $member) {
           
            
             if ($sms->sendSMS($member->phone, $request->input("id", ""), "Reminder")) {

                \Session::forget('employees');
            } else {
                return redirect("view_employees")->withErrors("SMS could not be sent.. please verify if you have sms data and internet access.");
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function countries() {

        $country = \DB::table('tbl_country')
                ->lists('Name', 'Name');
        return $country;
    }
    public function grades() {

         $grade=\DB::table('tbl_employee')->distinct()->where('grade','!=',"")->lists('grade','grade');
        return $grade ;
        
    }
     public function position() {

         $position=\DB::table('tbl_employee')->distinct()->where('position','!=',"")->lists('position','position');
        return $position ;
        
    }
    
     public function department() {

         $department=\DB::table('tbl_department')->lists('DEPARTMENT_NAME','ID');
        return $department ;
        
    }
    public function getLeave(Request $request){
           $employee=new DepartmentController();
        $leaveType=new LeaveSetupController();
         
        // employee is in session
        $request->session()->put('type', $request->input('type'));
        
        
        $type= Models\LeaveSetUpModel::where('Type', $request->input('type'))->first();
         
        redirect('apply_leave')->with('leaveDetails', $type);
     
        
    }

     
    public function designation() {

         $design=\DB::table('tbl_designation')->lists('designation','designation');
        return $design ;
        
    }
    public function create()
    {
         $employee=\DB::table('tbl_employee')->lists('staffID','id');
         
        return view('HR.employees.create')->with('country', $this->countries())
                ->with('department', $this->department())->with('designation', $this->designation())
                ->with('employee', $employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
         
        $this->validate($request, ['title' => 'required', 'fname' => 'required', 'surname' => 'required', 'position' => 'required', 'gender' => 'required', 'marital_status' => 'required', 'leave' => 'required', 'country' => 'required', 'ssnit' => 'required',  'education' => 'required', 'contact' => 'required', 'hometown' => 'required', 'dob' => 'required', 'phone' => 'required', 'email' => 'required', 'residence' => 'required','supervisor' => 'required' ]);

      $code=$this->getStaffID();
      $employee=new Models\EmployeeModel();
      $employee->staffID=date('Y').$code[0];
      $employee->title=$request->input('title');
      $employee->Name=$request->input('fname');
      $employee->surname=$request->input('surname');
      $employee->othernames=$request->input('othernames');
      $employee->position=$request->input('position');
      $employee->grade=$request->input('grade');
      $employee->ssnit=$request->input('ssnit');
      $employee->placeofresidence=$request->input('residence');
      $employee->address=$request->input('contact');
      $employee->phone=$request->input('phone');
      $employee->dob=$request->input('dob');
      $employee->email=$request->input('email');
      $employee->gender= $request->input('gender');
      $employee->grade= $request->input('grade');
      $employee->marital=$request->input('marital_status');
      $employee->nationality=$request->input('country','');
      $employee->dateHired=$request->input('hired');
      $employee->leaves=$request->input('leave');     
      $employee->hometown=$request->input('hometown'); 
      $employee->education=$request->input('education'); 
      $employee->department=$request->input('department'); 
      $employee->designation=$request->input('designation'); 
      
      $employee->supervisor=$request->input('supervisor');
      $employee->dependentsNo=$request->input('dependents');
      if($employee->save()){
          $valid_exts = array('jpeg', 'jpg'); // valid extensions
          $max_size = 400000; // max file size
          $photo=$request->file('files');
                    

               if (!empty($photo)) {
                // get uploaded file extension
                $ext = strtolower( $request->file('files')->getClientOriginalExtension());
                $photo = date('Y').$code[0] . '.' . $ext;
                $savepath = 'public/staffPics/';
               if (in_array($ext, $valid_exts)) {
                    if( $request->file('files')->move($savepath, $photo)){
                        \DB::table('codes')->increment('STAFF_ID');
                    }

               }
                
            }
            Session::flash('success_message', 'Employee added successfully!');
      }
      else{
          Session::flash('error_message', 'Error adding Employee!');
      }
      
        return redirect('view_employees');
    }
    public function getStaffID() {
       $code= \DB::table('codes')
                   
                    ->lists('STAFF_ID');
         return $code;
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

        return view('HR.employees.edit')->with('country', $this->countries())
                ->with('department', $this->department())->with('designation', $this->designation())
                ->with('employee', $tblemployee)
                ->with('supervisor', $this->getSupervisor());
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
        
       
      $this->validate($request, ['title' => 'required', 'fname' => 'required', 'surname' => 'required', 'position' => 'required', 'gender' => 'required', 'marital_status' => 'required', 'leave' => 'required', 'country' => 'required', 'ssnit' => 'required',  'education' => 'required', 'contact' => 'required', 'hometown' => 'required', 'dob' => 'required', 'phone' => 'required', 'email' => 'required', 'residence' => 'required','supervisor' => 'required' ]);

       
      $employee=EmployeeModel::findOrFail($id);
       
      $employee->title=$request->input('title');
      $employee->Name=$request->input('fname');
      $employee->surname=$request->input('surname');
      $employee->othernames=$request->input('othernames');
      $employee->position=$request->input('position');
      $employee->grade=$request->input('grade');
      $employee->ssnit=$request->input('ssnit');
      $employee->placeofresidence=$request->input('residence');
      $employee->address=$request->input('contact');
      $employee->phone=$request->input('phone');
      $employee->dob=$request->input('dob');
      $employee->email=$request->input('email');
      $employee->gender= $request->input('gender');
      $employee->grade= $request->input('grade');
      $employee->marital=$request->input('marital_status');
      $employee->nationality=$request->input('country','');
      $employee->dateHired=$request->input('hired');
      $employee->leaves=$request->input('leave');     
      $employee->hometown=$request->input('hometown'); 
      $employee->education=$request->input('education'); 
      $employee->department=$request->input('department'); 
      $employee->designation=$request->input('designation'); 
      
      $employee->supervisor=$request->input('supervisor');
      $employee->dependentsNo=$request->input('dependents');
      if($employee->save()){
          $valid_exts = array('jpeg', 'jpg'); // valid extensions
          $max_size = 400000; // max file size
          $photo=$request->file('files');
                    

               if (!empty($photo)) {
                // get uploaded file extension
                $ext = strtolower( $request->file('files')->getClientOriginalExtension());
                $photo =$employee->staffID . '.' . $ext;
                $savepath = 'public/staffPics/';
               if (in_array($ext, $valid_exts)) {
                    if( $request->file('files')->move($savepath, $photo)){
                        \DB::table('codes')->increment('STAFF_ID');
                    }

               }
                
            }
            Session::flash('success_message', 'Employee updated successfully!');
      }
      else{
          Session::flash('error_message', 'Error updating Employee!');
      }
      
        return redirect('view_employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        EmployeeModel::destroy($request->input("id"));

        Session::flash('success_message', ' Employee deleted!');

        return redirect('view_employees');
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

 public function picture($path,$target){
                if(file_exists($path)){
                        $mypic = getimagesize($path);

                 $width=$mypic[0];
                        $height=$mypic[1];

                if ($width > $height) {
                $percentage = ($target / $width);
                } else {
                $percentage = ($target / $height);
                }

                //gets the new value and applies the percentage, then rounds the value
                 $width = round($width * $percentage);
                $height = round($height * $percentage);

               return "width=\"$width\" height=\"$height\"";



            }else{}
        
       
        }
        
        
	public function pictureid($stuid) {

        return str_replace('/', '', $stuid);
    }
    public function getSupervisor(){
         $employee = \DB::table('tbl_employee')
                ->lists('staffID','Name');
        return $employee;
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\DepartmentModel;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models;
use Illuminate\Http\Request;

class DepartmentController extends Controller {

	 
    
    public function show_query() {

		\DB::listen(function ($sql, $binding, $timing) {
			print_r("<pre>");
			var_dump($sql);
			var_dump($binding);
		}
		);
	}
    
    public function create(){
        return view('HR.departments.create')->with('employee', $this->employees());
    }
    public function employees() {

        $employee = \DB::table('tbl_employee')
                ->lists('STAFFID', 'ID');
        return $employee;
    }
    
    public function store(Request $request){
        $this->validate($request, ['name' => 'required', 'phone' => 'required', 'hod' => 'required', ]);

          
         $department=new DepartmentModel();
      
         $department->DEPARTMENT_NAME=$request->input('name');
         $department->DEPARTMENT_HEAD=$request->input('hod');
         $department->DEPARTMENT_CONTACT=$request->input('phone');
         $department->NOTE=$request->input('note');
      if($department->save()){
        \Session::flash('success_message', 'Department added!');
        return redirect('view_departments');
      }
      else{
          \Session::flash('error_message', 'Error adding department!');
      }
        
    }
    public function index()    
    {  
        $table = (new DepartmentModel)->getTable();
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
            $value->title = studly_case($value->Field);

            if(str_contains($value->Type,"blob")){
            $value->searchable = false;
            $value->orderable = false;            
            }
            $data[$value->Field] = $value;
        }

        //hide and make id column unsearchable
        @$data['ID']->searchable = false;
        $data[$value->Field] = $value;
        
        @$data['ID']->visible = false;
        return view('HR.departments.index')->with("data",$data);    
    }
    public function search(Request $request){
         $table = (new  DepartmentModel)->getTable();
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
        $query = DepartmentModel::query();
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
        $total_table_records = DepartmentModel::count();
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
            $query_results[$keys]["button_actions"] = $this->addButtonActions($query_results[$keys]['ID']);

        }

        $ret['data'] = $query_results;
        $ret['recordsTotal'] = $total_table_records;
        $ret['recordsFiltered'] = $query_results_total;
        $ret['draw'] = intval($request['draw']);

        return response()->json($ret);
    }

    public function addButtonActions($id) {
        $string = "<a href='" . route('view_departments.edit', array($id)) . "' class='md-btn md-btn-primary md-btn-small'>Edit</a>&nbsp;";
        $string .= "<a href='" . url('view_departments', array($id)) . "' class='md-btn md-btn-success md-btn-small'>View</a>&nbsp;";
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


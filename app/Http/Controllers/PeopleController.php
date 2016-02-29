<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AccountModel;
use App\Http\Controllers\Controller;
use App\Models\PeopleModel;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //display people data here
        // $date=\date("t/m/Y");
         //$data= PeopleModel::paginate(1);
         // dd($request->input());
     //   \DB::listen(function($sql,$binding,$timing){
     //    print_r("<pre>");
     //    var_dump($sql);
     //    var_dump($binding);
     // }
     //  );
        


      //create query builder for model. this allows you to attach conditional or addtional queries as needed
        $people = PeopleModel::query();
        //check for search terms and attach as needed

        if ($request->has('type_search_query')) {
            $people->whereRaw(" BP_TYPE  LIKE     CONCAT('%',UPPER('" . $request->input("type_search_query", "") . "'), '%') ");
        }
        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $people->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }
        if ($request->has('order_from_date')) {
            $people->where("CREATED_AT", ">=", $request->input("order_from_date"));
        }
        if ($request->has('order_to_date')) {
            $people->where("CREATED_AT", "<=", $request->input("order_to_date"));
        }

        $data = $people->paginate(5);

        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("view_people"));


        return view("setup.people.view")->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\PeopleRequest $request)
    {
        //
        // insert into db here
        
       
      \DB::transaction(function() use($request)
        {
             $period=\date("t/m/Y");
            $year=(date("Y")) ."/". (date("Y") + 1);
          
        $people=PeopleModel::create([
            'BP_NAME'    => $request['name'],
            'BP_EMAIL'  => $request['email'],
            'BP_PHONE'    => $request['phone'],
            'BP_ADDRESS'    => $request['address'],
            'BP_TYPE'=> $request['person_type'],
            'BP_NOTE'=> $request['naration'],
            'BP_SINCE'=> $request['since'],
            'BP_PAYMENT_TERM'=> $request['term'],
            'BP_OPEN_BALANCE'=> $request['balance'],
            'PERIOD'    => $period,
            'YEAR'      => $year,
             
        ]);
         if($people){
                $account=new AccountController();
                $code=$account->getAccountCode();
                if($request['person_type']=="Customer"){
                   $person=2; 
                   $balance="Debit";
                }else{
                    $person=3;
                    $balance="Credit";
                }
                AccountModel::create([
                    'ACCOUNT_NAME'    => $request['name'],
                    'PARENT_ACCOUNT'  => $person,
                    'ACCOUNT_DESCRIPTION'    => $request['naration'],
                    'AFFECTS'      => "Balance Sheet",
                    'ACCOUNT_BALANCE' => $request['balance'],
                    'ACCOUNT_CODE'        => $code[0],
                    'BALANCE_TYPE'         => $balance,
                    
                    'PERIOD'    => $period,
                    'YEAR'      => $year,

                ]);
                \DB::table('account_code')->increment('NO');
            }
            
                
    });
                    $request->session()->flash('alert-success', 'Data successfully saved!');
                  return \Redirect::to('addPeople');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        return view('setup.people.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function print_all(Request $request) {
         
//create query builder for model. this allows you to attach conditional or addtional queries as needed
       $people= PeopleModel::query();
      //check for search terms and attach as needed
        
        if($request->has('type_search_query')){
        $people->whereRaw(" BP_TYPE  LIKE     CONCAT('%',UPPER('".$request->input("type_search_query","")."'), '%') ");
         }
         if($request->has('order_search_query') &&     trim($request->input('order_search_query') ) !="" ){
          $people->where($request->input('order_search_query_in'), "LIKE","%".$request->input("order_search_query", "")."%");
        }
        if($request->has('order_from_date')){
          $people->where("CREATED_AT",">=",$request->input("order_from_date"));
        }
         if($request->has('order_to_date')){
          $people->where("CREATED_AT","<=",$request->input("order_to_date"));
        }
         

         $data = $people->get();

        return view("setup.people.printpeople")->with('data',$data);

        //$pdf = \PDF::loadView('people.printpeople', array("data"=>$data));
        //return $pdf->download('invoice.pdf');
         //return $pdf->stream();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         // delete
       
//     the delete query is part of the query to get or find the model
        //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them
       
        $people =  PeopleModel::where('BP_ID',$request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if(empty($account)){
             \Session::flash('flash_message', 'Person not found!');

            return \redirect("view_people");
        }
        
//        $account->delete();
        
        
        \Session::flash('flash_message', 'Person successfully deleted!');

        return \redirect("view_people");
    }
}

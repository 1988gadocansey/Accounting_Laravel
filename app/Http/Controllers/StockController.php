<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockModel;
use App\Models\AccountModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StockController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
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
        $stock = StockModel::query();
        //check for search terms and attach as needed


        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $stock->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }


        $data = $stock->paginate(5);

        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("view_stock"));


        return view("setup.stock.view")->with('data', $data)->with("account", $this->accountList());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StockRequest $request) {
        //
        // insert into db here
        $code_ = \DB::table('codes')->lists('STOCK');
       
        $date = \date("t/m/Y");
        $code = substr(strtoupper($request['item']), 0, 3) . "/" . date("Y") . "/" . $code_[0];
         
        $rtmt=StockModel::create(['ITEM_CODE' => $code, 'ITEM_NAME' => $request['item'], 'ITEM_DESCRIPTION' => $request['description'], 'ITEM_UNIT_PRICE' => $request['price'], 'ITEM_ACCOUNT' => $request['account'], 'ITEM_RE_ORDER_LEVEL' => $request['reorder'], 'ITEM_QUANTITY' => $request['quantity'], 'ITEM_PERIOD' => $date,'DATE_PURCHASED'=>$request['date']]);
         
         if (!$rtmt) {
            $request->session()->flash('error_message', 'Stock not successfully saved!');
            return redirect("addstock")->withInput();
          }
          else{
              
                 \DB::table('codes')->increment('STOCK');
                $request->session()->flash('success_message', 'Stock successfully saved!');
                 return redirect("addstock");
            }
        
         
        
    }

    /* get the  stock account details 
     * this is based on relationship
     */

    public function accountList() {

        $parent = \DB::table('tbl_accounts')
                ->lists('ACCOUNT_NAME', 'ACCOUNT_ID');
        return $parent;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForm(Request $request, $id = null) {
        $parent = $this->accountList();

//        $stock = StockModel::find($request->input("id"));
        $stock = StockModel::find($id);

        $show = false;
        if (!empty($stock)) {
            $show = true;
        }
        return view('setup.stock.create')->with('show', $show)->with('stock', $stock)
                        ->with("parent", $parent);

        // return view('stock.create')->with("parent",$parent);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $stock = StockModel::find($id);
        $show = false;
        if (!empty($stock)) {
            $show = true;
        }
        return view('setup.stock.create')->with('show', $show)->with('stock', $stock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
           $stock = StockModel::find($id); //find the primary key of User table
     
    
            $ss=$stock->update(['ITEM_NAME' => $request['item'], 'ITEM_DESCRIPTION' => $request['description'], 'ITEM_UNIT_PRICE' => $request['price'], 'ITEM_ACCOUNT' => $request['account'], 'ITEM_RE_ORDER_LEVEL' => $request['reorder'], 'ITEM_QUANTITY' => $request['quantity'],'DATE_PURCHASED'=>$request['date']]);
        
            if (!$ss) {
            $request->session()->flash('error_message', 'Stock not successfully saved!');
            return redirect()->back();
            }
        
            $request->session()->flash('success_message', 'Stock successfully saved!');
 
            return redirect()->back();
    }

    public function print_all(Request $request) {

//create query builder for model. this allows you to attach conditional or addtional queries as needed
        $stock = StockModel::query();
        //check for search terms and attach as needed


        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $stock->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }



        $data = $stock->get();

        return view("setup.stock.printstock")->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        // delete
//     the delete query is part of the query to get or find the model
        //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them

        $stock = StockModel::where('ITEM_ID', $request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if (empty($stock)) {
            \Session::flash('flash_message', 'Stock not found!');

            return \redirect("view_stock");
        }

//        $account->delete();


        \Session::flash('flash_message', 'Stock successfully deleted!');

        return \redirect("view_stock");
    }

}

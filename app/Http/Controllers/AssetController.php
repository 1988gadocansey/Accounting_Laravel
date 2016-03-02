<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepreciationStoreModel;
use App\Models\DepreciationModel;
use App\Models\AssetModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
define('FINANCIAL_ACCURACY', 1.0e-6);
define('FINANCIAL_MAX_ITERATIONS', 100);

define('FINANCIAL_SECS_PER_DAY', 24 * 60 * 60);
define('FINANCIAL_HALF_SEC', 0.5 / FINANCIAL_SECS_PER_DAY);
class AssetController extends Controller
{
    public $accumulated_depreciation;
    public $cost;
    public $residual_value;
    public $useful_life;
    public $rate;
    public $method;
    public $asset_id;
    public $book_value;
    public $location;
    public function __construct( ) {
          ini_set('precision', '6');
    }
    public function DepreciableCost( ){
        return $this->cost-$this->residual_value;
    }
     

    public function YearlyRate(){
        if($this->method=='1'){
        $life=  $this->useful_life;
        return $per_year_rate= 1 / $life  * 100 . "%";
     
        }
    }
       /**
	* DDB
	* Returns the depreciation of an asset for a specified period using
	* the double-declining balance method or some other method you specify.
	* @param  float   $cost    is the initial cost of the asset.
	* @param  float   $salvage is the value at the end of the depreciation (sometimes called the salvage value of the asset).
	* @param  integer $life    is the number of periods over which the asset is being depreciated (sometimes called the useful life of the asset).
	* @param  integer $period  is the period for which you want to calculate the depreciation. Period must use the same units as life.
	* @param  float   $factor  is the rate at which the balance declines. If factor is omitted, it is assumed to be 2 (the double-declining balance method).
	* @return float   the depreciation of n periods.
	*/
       public function DDB($cost, $salvage, $life, $period, $factor = 2)
	{
		$x = 0;
		$n = 0;
		$life   = intval($life);
		$period = intval($period);
		while ($period > $n) {
			$x = $factor * $cost / $life;
			if (($cost - $x) < $salvage) $x = $cost- $salvage;
			if ($x < 0) $x = 0;
			$cost -= $x;
			$n++;
		}
		return $x;
	}
	
	/**
	* SLN
	* Returns the straight-line depreciation of an asset for one period.
	* @param  float   $cost    is the initial cost of the asset.
	* @param  float   $salvage is the value at the end of the depreciation (sometimes called the salvage value of the asset).
	* @param  integer $life    is the number of periods over which the asset is being depreciated (sometimes called the useful life of the asset).
	* @return float   the depreciation allowance for each period.
	*/
       private function SLN($cost, $salvage, $life)
	{
		$sln = ($cost - $salvage) / $life;
		return (is_finite($sln) ? $sln: null);
	}
     public function getAccumulated($asset,$period){
            
                  
             $output = \DB::table('tbl_depreciation_calculation')
                     ->where("ASSET","=",$asset)
                     ->where("PERIOD" ,"<=",$period)
                     ->SUM("CALCULATION");
                     
            return $output;
           
              
     }
     
     /*
         * reducing balance method
         */
        private function RDB($cost, $rate,  $asset,$period){
           
             
            $book  = $cost - $this->getAccumulated($asset, $period);
            $depreciation=  ceil($book * $rate) / 100  ;
             $output = \DB::table('tbl_fixed_assets_manager')
                     ->where("ID","=",$asset)
                     ->where("DEPRECIATED","=",1)
                     ->where("PERIOD" ,"=",$period)
                     ->lists('ID');
              
            if(empty($output)){
                 $asset = AssetModel::find($asset);
               
                  $asset->decrement('FIXED_ASSET_COST',$depreciation, array(
                    
                   'DEPRECIATED'=>1,
                   'PERIOD'=>$period,
 
               ));

                  return $depreciation;
            }
            
            else{
               return 0; 
            }
             
        }
        
    //get yearly depreciation for all report except balance sheet since it requires accumulated depreciation
              public function getDepreciation($asset,$period){
                    $output = \DB::table('tbl_depreciation_calculation')
                     ->where("ASSET","=",$asset)
                      
                     ->where("PERIOD" ,"=",$period)
                     ->lists('CALCULATION');
        

                    if(!empty($output)){
                             return $output;
                    }
                    else{
                        return "Depreciation not available now";
                    }    
    }
    
    //get accumulated deprec for balance sheet
          public function getAccDepreciation($asset,$period){
        
               $output = \DB::table('tbl_depreciation_calculation')
                     ->where("ASSET","=",$asset)
                      
                     ->where("PERIOD" ,"=",$period)
                      ->SUM("CALCULATION");
                     
        

                    if(!empty($output)){
                             return $output;
                    }
                    else{
                        return ;
                    }
        
        }
    /**
	* SYD
	* Returns the sum-of-years' digits depreciation of an asset for
	* a specified period.
	* 
	*        (cost - salvage) * (life - per + 1) * 2
	* SYD = -----------------------------------------
	*                  life * (1 + life)
	*
	* @param  float   $cost    is the initial cost of the asset.
	* @param  float   $salvage is the value at the end of the depreciation (sometimes called the salvage value of the asset).
	* @param  integer $life    is the number of periods over which the asset is depreciated (sometimes called the useful life of the asset).
	* @param  integer $per     is the period and must use the same units as life.  
	*/
      private function SYD($cost, $salvage, $life, $per)
	{
		$life = intval($life);
		$per  = intval($per);
		$syd  = (($cost - $salvage) * ($life - $per + 1) * 2) / ($life * (1 + $life));
		return (is_finite($syd) ? $syd: null);
      }
      public function calculateDepreciation($asset,$cost, $salvage, $life, $rate,$period,$method){
           
                 
                 $output = \DB::table('tbl_depreciation_calculation')
                     ->where("ASSET","=",$asset)
                      
                     ->where("PERIOD" ,"=",$period)
                      ->SUM("CALCULATION");
                      
        
                 
                   if(empty($output)){
                        if($method=='1'){
                           $dpr_amt= $this->SLN($cost, $salvage, $life);
                           
                             DepreciationStoreModel::create([
                                'ASSET'   => $asset,
                                'METHOD'  => '1',
                                'CALCULATION'    => $dpr_amt,
                                'PERIOD'    =>$period ,
                                  
                            ]);
                            
                           return $dpr_amt;
                        }
             elseif ($method == '2') {
                $dpr_amt = $this->RDB($cost, $rate, $asset, $period);
                            
                             DepreciationStoreModel::create([
                                'ASSET'   => $asset,
                                'METHOD'  => '2',
                                'CALCULATION'    => $dpr_amt,
                                'PERIOD'    =>$period ,
                                  
                            ]);
                            
                return $dpr_amt;
               } 
            
            else{
                      return $output;
                 }
                     
           }
                
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $asset = AssetModel::query();
        //check for search terms and attach as needed


        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $asset->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }


        $data = $asset->paginate(5);

        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("view_assets"));


        return view("setup.fassets.view")->with('data', $data)->with("account", $this->accountList())
                        ->with("departments", $this->departmentList())
                        ->with("categorys", $this->categoryList())
                        ->with("depreciations", $this->depreciationList());
   
    }
    public function manager(Request $request){
        //
        $asset = AssetModel::query();
        //check for search terms and attach as needed


        if ($request->has('asset') && trim($request->input('asset')) != "") {
                $asset->where("ID","=",$request->input("asset",""));
         }
        if ($request->has('depreciation') && trim($request->input('depreciation')) != "") {
             $asset->where("FIXED_ASSET_DEPRECIATION_METHOD","=",$request->input("depreciation",""));
        }
        if ($request->has('category') && trim($request->input('category')) != "") {
             $asset->where("FIXED_ASSET_CATEGORY","=",$request->input("category",""));
        }
        if ($request->has('department') && trim($request->input('department')) != "") {
             $asset->where("FIXED_ASSET_LOCATION","=",$request->input("department",""));
        }


        $data = $asset->paginate(5);

        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("asset_manager"));

         
         $request->flash();
        return view("setup.fassets.manager")->with('data', $data)->with("account", $this->accountList())
                        ->with("department", $this->departmentList())
                        ->with("category", $this->categoryList())
                        ->with("depreciation", $this->depreciationList())
                        ->with("asset", $this->assetList());
   
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
     public function print_all(Request $request) {

        //create query builder for model. this allows you to attach conditional or addtional queries as needed
        $asset = AssetModel::query();
        //check for search terms and attach as needed


        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $asset->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }



        $data = $asset->get();

        return view("setup.fassets.printassets")->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AssetRequest $request)
    {
        //
        //
        // insert into db here
        $code_ = \DB::table('codes')->lists('ASSET_CODE');
       
        $period = \date("t/m/Y");
        $code = substr(strtoupper($request['name']), 0, 3) . "/" . date("Y") . "/" . $code_[0];
         
        $rtmt=  AssetModel::create(['FIXED_ASSET_CODE' => $code, 'FIXED_ASSET_NAME' => $request['name'], 'FIXED_ASSET_DEPRECIATION_METHOD' => $request['depreciation_method'], 'FIXED_ASSET_CATEGORY' => $request['category'], 'FIXED_ASSET_LOCATION' => $request['location'], 'FIXED_ASSET_DESCRIPTION' => $request['description'], 'FIXED_ASSET_COST' => $request['cost'], 'FIXED_ASSET_DEPRECIATION_RATE' => $request['rate'],'FIXED_ASSETS_DATE_PURCHASE'=>$request['date'],'PERIOD'=>$period,'FIXED_ASSET_ACCOUNT'=>$request['account'],'USEFUL_LIFE'=>$request['life'],'FIXED_ASSET_SERIAL_NUMBER'=>$request['serial'],'SALVAGE_VALUE'=>$request['residual'],'FIXED_ASSET_DESCRIPTION'=>$request['description']]);
         
        
        
         if (!$rtmt) {
            $request->session()->flash('error_message', 'Asset successfully saved!');
            return redirect("addassets")->withInput();
          }
          else{
              
                 
                $request->session()->flash('success_message', 'Asset successfully saved!');
                 return redirect("addassets");
            }
        
    }
    /* get the  asset account details 
     * this is based on relationship
     */

    public function accountList() {

        $parent = \DB::table('tbl_accounts')
                ->lists('ACCOUNT_NAME', 'ACCOUNT_ID');
        return $parent;
    }
    public function departmentList() {

        $parent = \DB::table('tbl_department')
                ->lists('DEPARTMENT_NAME', 'ID');
        return $parent;
    }
    public function assetList() {

        $asset = \DB::table('tbl_fixed_assets_manager')
                ->lists('FIXED_ASSET_NAME', 'ID');
        return $asset;
    }
    public function depreciationList() {

        $parent = \DB::table('tbl_depreciation_method')
                ->lists('DEPRECIATION_METHOD', 'ID');
        return $parent;
    }
    public function categoryList() {

        $parent = \DB::table('tbl_fixed_asset_categories')
                ->lists('FIXED_ASSET_CATEGORY', 'ID');
        return $parent;
    }
    
    // get asset
    public function getAsset($asset){
        
       $data=\DB::table('tbl_fixed_assets_manager')->where("ID","=",$asset)->get();
       
                 foreach ($data as $output)
                {
                     
                      return $output->FIXED_ASSET_NAME;
                      
                 }
    }
    
     //get fixed asset code from assets
         public function getAssetAccount($account){
        
        
      $data=\DB::table('tbl_fixed_assets_manager')->where("ID","=",$account)->get();
      
 
       if(!empty($data)){
                 foreach ($data as $output)
                {
                     
                      return $output->ID;
                      
                 }
       }
       else{
           return  ;
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForm(Request $request, $id = null)
    {
        $account = $this->accountList();

//        $asset = AssetModel::find($request->input("id"));
        $asset = AssetModel::find($id);

        $show = false;
        if (!empty($asset)) {
            $show = true;
        }
        return view('setup.fassets.create')->with('show', $show)->with('asset', $asset)
                        ->with("account", $account)->with("department", $this->departmentList())
                        ->with("category", $this->categoryList())
                        ->with("depreciation", $this->depreciationList());
                      

        // return view('asset.create')->with("parent",$parent);
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $asset = AssetModel::find($id);
        $show = false;
        if (!empty($asset)) {
            $show = true;
        }
        return view('setup.fassets.create')->with('show', $show)->with('asset', $asset);
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
        $asset = AssetModel::find($id); //find the primary key of User table
     
    
            $ss=$asset->update(['FIXED_ASSET_NAME' => $request['name'], 'FIXED_ASSET_DEPRECIATION_METHOD' => $request['depreciation_method'], 'FIXED_ASSET_CATEGORY' => $request['category'], 'FIXED_ASSET_LOCATION' => $request['location'], 'FIXED_ASSET_DESCRIPTION' => $request['description'], 'FIXED_ASSET_COST' => $request['cost'], 'FIXED_ASSET_DEPRECIATION_RATE' => $request['rate'],'FIXED_ASSETS_DATE_PURCHASE'=>$request['date'],'FIXED_ASSET_ACCOUNT'=>$request['account'],'USEFUL_LIFE'=>$request['life'],'FIXED_ASSET_SERIAL_NUMBER'=>$request['serial'],'SALVAGE_VALUE'=>$request['residual'],'FIXED_ASSET_DESCRIPTION'=>$request['description']]);
         
        
            if (!$ss) {
            $request->session()->flash('error_message', 'Asset not successfully updated!');
            return redirect()->back();
            }
        
            $request->session()->flash('success_message', 'Asset successfully updated!');
 
            return redirect()->back();
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

        $asset = AssetModel::where('ID', $request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if (empty($asset)) {
            \Session::flash('flash_message', ' Asset not found!');

            return \redirect("view_assets");
        }

      //        $account->delete();


        \Session::flash('flash_message', 'Asset successfully deleted!');

        return \redirect("view_assets");
    }
}

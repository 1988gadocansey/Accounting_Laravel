<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoginUser;
use Illuminate\Cookie\CookieJar;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('login');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Process the Login form with validations
     * 
     */
   public function doLogin(Requests\LoginFormRequest $request)
	{
       
		 //$user will store the user object returned from the query or empty object if nothing found.  
		$user = LoginUser::where('USERNAME',$request->input('username'))->where('PASSWORD',md5($request->input('password')))->first();
            if(empty($user)){
              return redirect("/login")->withErrors(array("Error! Wrong username or password"));
            }
            else{
             $request->session()->put('flatUser.username', $user->USERNAME);
             $request->session()->put('flatUser.id', $user->ID);
             $request->session()->put('flatUser.role', $user->ROLE);
             
            return redirect('/');
            }

	}
        public function Logout(Request $request) {
//        if (\Auth::check()) {
//            \Auth::logout();
//            }
//            
            $request->session()->forget('flatUser')>flush();
            $cookie= \Cookie::forget('laravel_accounting_session');
            return \Redirect::to('/')->withErrors("<script>window.parent.location=".url('login')."</script>")->withCookie($cookie);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

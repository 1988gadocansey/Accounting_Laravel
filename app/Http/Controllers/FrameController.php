<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models;
use App\Http\Controllers\Controller;
use App\Models\LoginUser;
use Illuminate\Cookie\CookieJar;


class FrameController extends Controller
{
    
     public function show_dashboard()
    {
        return view('defaults.frame');
    }
    
     public function show_navigator()
    {
        return view('defaults.navigator');
    }
     public function showIndex()
    {
        return view('dashboard.dashboard');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show_login()
    {
        //
      return view('login.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function handle_login(Requests\LoginFormRequest $request)
    {
        
      $user = Models\Log::where('theid',$request->input('username'))->where('thepass',md5($request->input('password')))->where('branch',$request->input('b_id'))->where("status",1)->first();
      if(empty($user)){
        return redirect("login")->withErrors(array("Password/Username Error!"));
      }
      $request->session()->regenerate(true);
      $request->session()->put('current_user.id',$user->id);
      $request->session()->put('current_user.username',$user->theid);
      $request->session()->put('current_user.name',$user->name); 
      $request->session()->put('current_user.bank',$user->bank);
      $request->session()->put('current_user.branch',$user->branch);
      return redirect('/');

    }


    public function handle_logout(Request $request)
    {
        $request->session()->forget('current_user');
        $request->session()->flush();
        $request->session()->regenerate(true);
         $cookie=  \Cookie::forget('ropay_s');
        return redirect("/")->withErrors("<script>window.parent.location=".url('login')."</script>")->withCookie($cookie);
    
    }

    
     public static function do_logout(Request $request)
    {
        $request->session()->forget('current_user');
        $request->session()->flush();
       $request->session()->regenerate(true);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

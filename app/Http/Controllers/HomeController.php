<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\FormData;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application form by form Id.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showForm(Request $request)
    {
        $data = []; $opencount=1;
        if($request->post_url){
            $data = DB::table('posts')->select('posts.*', 'form_data.user_id')
            ->leftJoin('form_data', 'posts.id', '=', 'form_data.form_id') 
            ->where('post_url', $request->post_url)
            ->whereNull('form_data.user_id')
            ->first();
            if(!empty($data)){

                $opencount +=  $data->total_open_count;
                Post::where('post_url', $request->post_url)->update(['total_open_count' => $opencount]);
            }
           
        }
        return view('show-form', compact('data'));
        
    }

    

    /**
     * Save Form Form Function.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submitForm( Request $request)
    {
        $formdata = $request->all();
        if(!empty($formdata)){
            
                $userdata = FormData::where('form_id', $request->form_id)
                        ->where('user_id', Auth::id())
                        ->first();  

                if(empty($userdata)){

                    $formdata = new FormData;
                    $content = json_encode(["email"=>$request->field_data]);
                                
                    $formdata->user_id = $request->user_id;            
                    $formdata->form_id = $request->form_id;
                    $formdata->form_content = $content;

                    $formdata->save();
                    $submitcount = 1;
                    $data = Post::where('id', $request->form_id)->first();            
                    $submitcount +=  $data->total_submit_count;
                    Post::where('post_url', $data->post_url)->update(['total_submit_count' => $submitcount]);

                    Session::flash('success', 'Form Created Successfully!');
                    return Redirect::back();
                }else{
                    return Redirect::back()->withErrors(['errors' => 'NOt allowed to store!']);
                }
            
        }
    }



    
}

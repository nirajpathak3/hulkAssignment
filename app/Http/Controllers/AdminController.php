<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use DB;

class AdminController extends Controller
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
        return view('admin.index');
    }

    /**
     * Create Form Function.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createForm()
    {
        return view('admin.create-form');
    }
    

    /**
     * List all Forms Function.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listAllForms()
    {
        $data = Post::get();
        return view('admin.formlist', compact('data'));
    }

    /**
     * Save Form Form Function.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function saveForm( Request $request)
    {
        // dd($request->all());

        $formdata = $request->all();

        $rules=array(
            'field_title' => 'required',
            'field_type' => 'required',
        );
        
        $messages=array(
            'field_title.required' => 'Field title is required.',
            'field_type.required' => 'Field Type is required',
        );
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return view('admin.create-form', compact('errors'));
        }else{

            $post = new Post;
            $post_content = [];
            $post_content['field_type'] = $request->field_type;
            if($request->ismin){
                $post_content['min'] = $request->minval;
            }
            if($request->ismax){
                $post_content['max'] = $request->maxval;
            }
            
            $post->post_title = $request->field_title;            
            $post->post_content = json_encode($post_content);
            $post->post_url = 'form'.rand();
            $post->post_status = "publish";
            $post->post_type = "form";

            $post->save();
            $_id = $post->id;
            Session::flash('success', 'Form Created Successfully!');
            return view('admin.formlist');
        }
    }
}

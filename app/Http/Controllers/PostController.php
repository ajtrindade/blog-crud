<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Posts;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\Http\Requests;
  
class PostController extends Controller
{
       
    public function index()
    {
        $data = Posts::all();
        return Inertia::render('Posts', ['data' => $data]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'titulo' => ['required'],
            'corpo' => ['required'],
            'autor' => ['required'],
        ])->validate();
  
        Post::create($request->all());
  
        return redirect()->back();
                    
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'titulo' => ['required'],
            'corpo' => ['required'],
            'autor' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Post::find($request->input('id'))->update($request->all());
            return redirect()->back();
                    
        }
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Post::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }

    public function show($id) {

    }

}

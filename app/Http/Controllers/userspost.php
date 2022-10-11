<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class demo extends Controller
{
    public function index()
    {
       $posts = userspost::all();
 
        return view('posts.index', compact('posts'));
    }

   
    public function create()
    {
       return view('posts.create');
    }

   
    public function store(Request $request)
    {
         
         $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        userspost::create($request->all());
     
        return redirect()->route('posts.index')
                        ->with('success','posts created successfully.');
    }

   
    public function show(userspost $userspost)
    {
        return view('posts.show',compact('userpost'));
    }

    public function edit(userspost $userspost)
    {
        $posts = userspost::find($userspost);
        return view('stocks.edit', compact('posts'));
    }

   
    public function update(Request $request, userspost $userspost, $id)
    {
          $request->validate([
            'title'=>'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'=>'required',
            'status'=>'required'
        ]); 
        $userspost = userspost::find($id);
        $userspost->title =  $request->get('title');
        $userspost->image = $request->get('image');
        $userspost->description = $request->get('description');
        $userspost->status = $request->get('status');
        $userspost->save();
 
        return redirect('posts.index')->with('success', 'posts updated.'); 
    }

   
    public function destroy(userspost $userspost, $id)
    {
        userspost::find($id)->delete();
        return redirect()->route('posts.index')->with('success','posts deleted successfully');
    }
}

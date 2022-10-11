<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class demomodule extends Controller
{
    public function index()
    {
        $modules = usersmodule::latest()->paginate(5);
    
        return view('module.index',compact('modules'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'required',
        ]);

        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        usersmodule::create($request->all());
     
        return redirect()->route('module.index')
                        ->with('success','module created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\usersmodule  $usersmodule
     * @return \Illuminate\Http\Response
     */
    public function show(usersmodule $usersmodule)
    {
        return view('module.show',compact('usersmodule'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\usersmodule  $usersmodule
     * @return \Illuminate\Http\Response
     */
    public function edit(usersmodule $usersmodule)
    {
         return view('module.edit',compact('usersmodule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\usersmodule  $usersmodule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, usersmodule $usersmodule)
    {

        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'required',
        ]);

         $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
    
        $usersmodule->update($request->all());
    
        return redirect()->route('module.index')
                        ->with('success','User updated successfully');

    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\usersmodule  $usersmodule
     * @return \Illuminate\Http\Response
     */
    public function destroy(usersmodule $usersmodule, $id)
    {
         usersmodule::find($id)->delete();
        return redirect()->route('module.index')->with('success','Module deleted successfully');
    }
}

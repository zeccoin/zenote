<?php

namespace App\Http\Controllers;

use App\notesz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteszController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $notesz=notesz::all()->where('user', Auth::user()->email);
       
        return view('notesz.notesz',compact('notesz'));
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
        $validatedData = $request->validate([
            'name' => 'required|unique:noteszs|max:255',
        ],[

            'name.required' =>'يرجي ادخال اسم القسم',
            'name.unique' =>'اسم القسم مسجل مسبقا',


        ]);

            notesz::create([
                'name' => $request->name,
                'des' => $request->des,
                'user' => (Auth::user()->email),

            ]);
            session()->flash('Add','تم الاضافة');
            return redirect('/notesz');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\notesz  $notesz
     * @return \Illuminate\Http\Response
     */
    public function show(notesz $notesz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\notesz  $notesz
     * @return \Illuminate\Http\Response
     */
    public function edit(notesz $notesz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\notesz  $notesz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:noteszs,name,'.$id,
            'des' => 'required',
        ],[

            'name.required' =>'يرجي ادخال اسم القسم',
            'name.unique' =>'اسم القسم مسجل مسبقا',
            'des.required' =>'يرجي ادخال البيان',

        ]);

        $notesz = notesz::find($id);
        $notesz->update([
            'name' => $request->name,
            'des' => $request->des,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/notesz');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\notesz  $notesz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        notesz::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/notesz');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use DB;
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//$this->checkPermissionMethod('list.countries');
        $records = Currency::orderBy('created_at', 'DESC')->get();
		
        return view('currency.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//$this->checkPermissionMethod('list.countries');
        return view('currency.create');
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
            'name'=>'required|max:255|unique:currency,name|sanitizeScripts',
			'value'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $record = new Currency();
        $record->name = $request->input('name');
        $record->code = $request->input('code');
        $record->value = $request->input('value');
		$record->markup_value = $request->input('markup_value');
		$record->status = $request->input('status');
        $record->save();
        return redirect('currency')->with('success','Currency Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  currency
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		//$this->checkPermissionMethod('list.countries');
        $record = Currency::find($id);
        return view('currency.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:currency,name,' .$id,
			'markup_value'=>'required',
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
        if($request->input('is_default') == 1){
            Currency::query()->update(['is_default' => 0]) ;
        }

        $record = Currency::find($id);
        $record->name = $request->input('name');
        $record->code = $request->input('code');
        $record->value = $request->input('value');
		$record->markup_value = $request->input('markup_value');
        $record->is_default = $request->input('is_default');
		$record->status = $request->input('status');
        $record->save();
        return redirect('currency')->with('success','Currency Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Currency::find($id);
        $record->delete();
        return redirect('currency')->with('success', 'Currency Deleted.');
    }
	
}

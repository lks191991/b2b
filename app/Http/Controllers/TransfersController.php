<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\TransferData;
use Illuminate\Http\Request;
use DB;
class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		$this->checkPermissionMethod('list.transfer');
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
		$data = $request->all();
		$query = Transfer::where('id', '!=', null);

		if (isset($data['name']) && !empty($data['name'])) {
			$query->where('name', 'like', '%' . $data['name'] . '%');
		}

		if (isset($data['status']) && !empty($data['status'])) {
			if ($data['status'] == 1) {
				$query->where('status', 1);
			} elseif ($data['status'] == 2) {
				$query->where('status', '!=', 1);
			}
		}

		$records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

		return view('transfers.index', compact('records'));
	}

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.transfer');
        return view('transfers.create');
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
            'name'=>'required|max:255|unique:transfers,name|sanitizeScripts'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
		
		
        $record = new Transfer();
        $record->name = $request->input('name');
		$record->status = $request->input('status');
        $record->save();
		
		$transferDataInsert = [];
		$transferData = $request->input('price');
		foreach($transferData as $k => $data)
		{
			$transferDataInsert[$k]=[
			'transfer_id' => $record->id,
			'qty' => $k+1,
			'price' => $data,
			];
		}
		
		if(!empty($transferDataInsert)){
            TransferData::insert($transferDataInsert);
        }
		
        return redirect('transfers')->with('success','Transfer Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.transfer');
        $record = Transfer::with('transferdata')->find($id);
        return view('transfers.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:transfers,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Transfer::find($id);
        $record->name = $request->input('name');
        $record->status = $request->input('status');
        $record->save();
		
		$transferDataInsert = [];
		$transferData = $request->input('price');
		foreach($transferData as $k => $data)
		{
			if(!empty($data))
			{
				$transferDataInsert[$k]=[
				'transfer_id' => $record->id,
				'qty' => $k+1,
				'price' => $data,
				];
			}
		}
		
		$record->transferdata()->delete();
		if(!empty($transferDataInsert)){
            TransferData::insert($transferDataInsert);
        }
		
        return redirect('transfers')->with('success','Transfer Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Transfer::find($id);
        $record->delete();
        return redirect('transfers')->with('success', 'Transfer Deleted.');
    }
	
}

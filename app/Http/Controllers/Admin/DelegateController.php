<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExpressDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDelegateRequest;
use App\Models\City;
use App\Models\Delegate;
use App\Services\DelegateService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DelegateController extends Controller
{

    public function __construct(private DelegateService $delegateService)
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.delegates.index', ['delegates' => Delegate::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.delegates.create',['cities'=>City::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDelegateRequest $request)
    {
        $validated = $request->validated();
        
        $res_store = $this->delegateService->store($validated);

        if ($res_store['code'] == 1) 
        {
            return redirect()->route('admin.delegates.index')->with("success", "تم اضافة البيانات بنجاح");
        }
        else
        {
            return redirect()->route('admin.delegates.index')->with("error",$res_store['msg']);
        }
       
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
    public function edit(Delegate $delegate)
    {
        return view('admin.delegates.edit', ['delegate' => $delegate ,'cities'=>City::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delegate $delegate)
    {
     
        $rules = [
            'name'      => 'required',
            'phone'     => 'required|unique:delegates,phone,'.$delegate->id,
            'cities'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }

        $new_data = [
            'name'       => $request->name,
            'phone'      => $request->phone
        ];
        
        $res_update = $this->delegateService->update($delegate->id,$new_data,$request->cities);

        if ($res_update['code'] == 1) 
        {
            return redirect()->route('admin.delegates.index')->with("success","تم تعديل البيانات بنجاح");
        }else{
            return redirect()->route('admin.delegates.index')->with("error",$res_update['msg']);
        }


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delegate $delegate)
    {
        $delegate->delete();
        return redirect()->route('admin.delegates.index')->with("success","تم حذف البيانات بنجاح");
    }

    public function get_shipments(Delegate $delegate){
        $dataTable = new ExpressDataTable(false,null,$delegate->id);
        return $dataTable->render('admin.delegates.show_shipments');
    }
}

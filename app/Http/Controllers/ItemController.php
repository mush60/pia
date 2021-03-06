<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;
use Session;
use App;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if($request->has('search') && $request->search != "") {
            $item = \App\Models\Tbl_item::where('item_name', 'like', '%'.$request->search.'%')
                                            ->latest()->paginate(10);
        } else {
            $item = \App\Models\Tbl_item::latest()->paginate(10);
        }
        return view('app.item_list', ['data_item' => $item]);            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = \App\Models\Tbl_warehouse::all();
        return view('app.create_item', ['data_gudang' => $gudang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\App\Models\Tbl_item::count() == 0) {
            $lastid = 1;
        } else {
            $lastid = \App\Models\Tbl_item::latest()->first()->id + 1;
        }
        $item_cd = str_pad($lastid, 5, "0", STR_PAD_LEFT);

        $data_item = array(
            'item_code' => $item_cd,
            'item_name' => strtoupper($request->item_name),
            'item_unit' => ucfirst($request->item_unit),
            'gudang_id' => $request->gudang_id,
            'item_price' => 0,
            'desc' => $request->keterangan,
            'user_id' => auth()->user()->id
        );

        $in_item = \App\Models\Tbl_item::create($data_item);

        if ($in_item->exists) {
            Session::flash('alert', ['status' => 'success', 'msg' => 'Tambah Data '.$in_item->item_name.' berhasil!']);

            return redirect('dashboard');
         } else {
            App::abort(500, 'Error');
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

        $item = \App\Models\Tbl_item::find($id);
        $stock = \App\Models\Tbl_stock::where('item_id', $id)->get();
        $cst = \App\Models\Tbl_stock::selectRaw('item_id, sum(case when stock_type = "in" then item_qty else -item_qty end) as qty')
                ->where('item_id', '=', $id)
                ->groupBy('item_id')
                ->first();
        return view('app.item_show', ['item' => $item, 'data_stock' => $stock, 'cst' => $cst->qty]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = \App\Models\Tbl_item::find($id);
        return view('app.item_edit', ['item' => $item]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = \App\Models\Tbl_item::find($id);

        $item->item_name = strtoupper($request->item_name);
        $item->item_unit = ucfirst($request->item_unit);
        $item->updated_at = Carbon::now()->format('Y-m-d H:i:s');

        $save = $item->save();

        if(!$save) {
            App::abort(500, 'Error');
        } else {
            Session::flash('alert', ['status' => 'success', 'msg' => 'Update Data '.$item->item_name.' berhasil!']);

            return redirect('dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = \App\Models\Tbl_item::find($id);

        $nstock = \App\Models\Tbl_stock::where('item_id', $id)->count();
        
        if($nstock != 0) {

            $nstock = \App\Models\Tbl_stock::where('item_id', $id)->get();

            foreach ($nstock as $stock) {
                $id = $stock->id;
                \App\Models\Tbl_stock::find($id)->forceDelete();
            }

        }

        $delete = $item->forceDelete();

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tmlevel;
use DataTables;

// use Tmlevel;

class TmlevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $request;
    protected $route;
    protected $view;
    function __construct(Request $request)
    {
        $this->request = $request;
        $this->view    = '.level.';
        $this->route   = 'master.tmlevel.';
    }


    public function index()
    {
        $title = 'Level Akses User';
        return view($this->view . 'index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->request->ajax()) {
            return redirect(route('home'));
            exit();
        }
        $title = 'Level Akses User';
        return view($this->view . 'form_add', compact('title'));
    }

    public function getbangunan()
    {
        $title = 'Level Akses User';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = Tmlevel::get();
        return DataTables::of($data)
            ->editColumn('id', function ($p) {
                return "<input type='checkbox' name='cbox[]' value='" . $p->id . "' />";
            })
            ->editColumn('action', function ($p) {
                return  '<a href="" class="btn btn-warning btn-xs" id="edit" data-id="' . $p->id . '"><i class="fa fa-edit"></i>Edit </a> ';

            }, true)
            ->editColumn('nama', function ($p) {
                return $p->name;
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercrate', 'action', 'id'])
            ->toJson();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->request->validate([
            'level_kode' => 'required',
            'level' => 'required',
        ]);
        try {
            $data = new Tmlevel();
            $data->level_kode = $this->request->level_kode;
            $data->level = $this->request->level;
            $data->user_id = Auth::user()->id;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data bangunana berhasil dtambah'
            ]);
        } catch (\Tmlevel $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
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
    public function edit($id)
{

if (!$this->request->ajax()) {
 return response()->json([
     'data'=>'data null',
     'aspx'=>'response aspx fail '
 ]);
}
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->request->validate([
            'level_kode' => 'required',
            'level' => 'required',
            'user_id' => 'required'
        ]);
        try {
            $data = new Tmlevel();
            $data->level_kode = $this->request->level_kode;
            $data->level = $this->request->level;
            $data->user_id = $this->request->user_id;
            $data->find($id)->save();
            return response()->json([
                'status' => 1,
                'msg' => 'data bangunana berhasil dtambah'
            ]);
        } catch (\Tmlevel $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
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
        try {
            if (is_array($this->request->id))
                Tmlevel::whereIn('id', $this->request->id)->delete();
            else
                Tmlevel::whereid($this->request->id)->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (Tmlevel $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}

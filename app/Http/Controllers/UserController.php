<?php

namespace App\Http\Controllers;

use App\Models\Tmlevel;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class UserController extends Controller
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
        $this->view    = '.user.';
        $this->route   = 'master.user.';
    }


    public function index()
    {
        $title = 'Master Data User';
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
        $title = 'Tambah Data User';
        $level = Tmlevel::get();
        return view($this->view . 'form_add', compact('title', 'level'));
    }

    public function getbangunan()
    {
        $title = 'Master Data User';
        return view($this->view . 'select', compact('title'));
    }

    public function api()
    {
        $data = User::join('tmuser_level', 'user.level_id', '=', 'tmuser_level.id')->get();
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
            ->editColumn('foto_p', function ($p) {
                // return ;
                return '<img src="' . asset('file/photo_user/' . $p->photo) . '" alt="..."
                                                        class="avatar-img rounded-circle"
                                                        onerror="this.onerror=null;this.src=\'' . asset('assets/img/profile.jpg') . '\';"
                                                        id="foto">';
            }, true)
            ->addIndexColumn()
            ->rawColumns(['usercreate', 'foto_p', 'action', 'id'])
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
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'email' => 'required|unique:users,email',
            'tmlevel_id' => 'required',
            'foto' => 'mimes:png,jpg'
        ]);
        try {
            $data = new User;

            // $id = Auth::user()->id;
            $tgl = Carbon::now()->format('y-m-d');
            $ext = $this->request->file('foto');
            if ($ext == '') {
            } else {
                $setname = rand(122, 333) . '-' . $tgl . '.' . $ext->getClientOriginalExtension();
                $ext->move('./file/photo_user/', $setname);
                $data->photo  = $setname;
            }
            $data->username = $this->request->username;
            $data->password = bcrypt($this->request->password);
            $data->email = $this->request->email;
            $data->name = $this->request->name;

            $data->tmlevel_id = $this->request->id_role;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data user berhasil dtambah'
            ]);
        } catch (User $t) {
            return response()->json([
                'status' => 1,
                'msg' =>  $t,
            ]);
        }
    }
    public function profile()
    {
        //
        $id = Auth::user()->id;

        $data = User::findOrfail($id);
        $name = $data->name;
        $username = $data->username;
        $email = $data->email;
        $id_lev = $data->tmlevel_id;
        $password = $data->password;
        $id = $data->id;
        $level = Tmlevel::get();
        $tmlevel_id = $data->tmlevel_id;
        $photo = $data->photo;

        $title = "Edit Password";
        return view($this->view . 'profil', compact(
            'id',
            'title',
            'name',
            'username',
            'email',
            'level',
            'password',
            'tmlevel_id',
            'photo',
            'id_lev'
        ));
    }


    public function profilesave()
    {
        $this->request->validate([
            'password' => 'required',
            'email' => 'required|unique:users,email',
            'foto' => 'mimes:png,jpg',

        ]);

        // dd($this->request->file('foto')->getClientOriginalExtension());
        try {
            $id = Auth::user()->id;
            $tgl = Carbon::now()->format('y-m-d');
            $ext = $this->request->file('foto');
            $setname = rand(122, 333) . '-' . $tgl . '.' . $ext->getClientOriginalExtension();

            $ext->move('./file/photo_user/', $setname);
            $data = User::find($id);
            $filename = public_path('./file/photo_user/' . $data->photo);
            if (File::exists($filename)) {
                File::delete($filename);
            }
            // $data->username = $this->request->username;
            $data->password = bcrypt($this->request->password);
            $data->email = $this->request->email;
            $data->name = $this->request->name;

            $data->photo = $setname;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data user berhasil edit'
            ]);
        } catch (User $t) {
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
                'data' => 'data null',
                'aspx' => 'response aspx fail '
            ]);
        }
        //
        $data = User::findOrfail($id);
        $name = $data->name;
        $username = $data->username;
        $tmproyek_id = $data->tmproyek_id;
        $email = $data->email;
        $id_lev = $data->tmlevel_id;
        $password = $data->password;
        $id = $data->id;
        $level = Tmlevel::get();

        $tmlevel_id = $data->tmlevel_id;
        return view($this->view . 'form_edit', compact(
            'id',
            'name',
            'username',
            'tmproyek_id',
            'email',
            'level',
            'password',
            'tmlevel_id',
            'id_lev'
        ));
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
        // $this->request->validate([
        //     // 'username' => 'required|unique:users,username',
        //     'password' => 'required',
        //     'email' => 'required|unique:user,email',
        //     'tmlevel_id' => 'required',
        //     'tmproyek_id' => 'required'
        // ]);
        try {
            dd($this->request->file('foto'));
            $data = User::find($id);
            // $data->username = $this->request->username;

            $id = Auth::user()->id;
            $tgl = Carbon::now()->format('y-m-d');
            $ext = $this->request->file('foto');
            $setname = rand(122, 333) . '-' . $tgl . '.' . $ext->getClientOriginalExtension();

            $ext->move('./file/photo_user/', $setname);
            $data = User::find($id);
            $filename = public_path('./file/photo_user/' . $data->photo);
            if (File::exists($filename)) {
                File::delete($filename);
            }

            $data->password = bcrypt($this->request->password);
            $data->email = $this->request->email;
            $data->name = $this->request->name;

            $data->tmlevel_id = $this->request->id_role;
            $data->foto = $setname;
            $data->save();

            return response()->json([
                'status' => 1,
                'msg' => 'data user berhasil edit'
            ]);
        } catch (User $t) {
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
            if (is_array($this->request->id)) {
                $datas =  user::whereIn('id', $this->request->id);
                foreach ($datas as $data) {
                    $tgl = Carbon::now()->format('y-m-d');
                    $ext = $this->request->file('foto');
                    $setname = rand(122, 333) . '-' . $tgl . '.' . $ext->getClientOriginalExtension();

                    $ext->move('./file/photo_user/', $setname);
                    $data = User::find($id);
                    $filename = public_path('./file/photo_user/' . $data->photo);
                    if (File::exists($filename)) {
                        File::delete($filename);
                    }
                }
                $data->delete();
            } else {
                user::whereid($this->request->id)->delete();
            }
            return response()->json([
                'status' => 1,
                'msg' => 'Data berhasil di hapus'
            ]);
        } catch (user $t) {
            return response()->json([
                'status' => 2,
                'msg' => $t
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Company;
use App\Models\User;

class UserController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            // membuat relasinya
            $query = User::with(['company']);

            return Datatables::of($query)->addColumn('action',function($item){
                return'
                    <div class="btn-group">
                        <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                            type="button"
                            data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('user.edit', $item->id)  . '">
                                Sunting
                            </a>
                            <form action="'.  route('user.destroy', $item->id)  .'" method="POST">
                                '. method_field('delete')  .  csrf_field()  .'
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>
                
                ';
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('pages.admin.user.index');
    }

    public function create()
    {

        $company = Company::all();
        return view('pages.admin.user.create',[
            'company' => $company
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($request->password);

        User::create($data);

        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);
         $company = Company::all();
        return view('pages.admin.user.edit',[
            'item' => $item,
            'company' => $company

        ]);
    }

        public function update(UserRequest $request, $id)
    {
        $data = $request->all();
     
        $item = User::findOrFail($id);

        if($request->password){
            $data['password'] = bcrypt($request->password);
        }else{
            unset($data['password']);
        }

        $item->update($data);

        return redirect()->route('user.index');
    }

    

        public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return redirect()->route('user.index');
    }

     
}

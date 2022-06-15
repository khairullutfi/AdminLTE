<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Admin\KaryawanRequest;
use App\Http\Requests\Admin\AttachmentRequest;
use App\Models\Company;
use App\Models\Karyawan;
use App\Models\Attachment;


class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        $company = Company::all();
        if(request()->ajax()) {
            return datatables()->of(Karyawan::with(['company']))
            ->addColumn('button',function($item){
                return'
                    <div class="btn-group">
                        <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle mr-1 mb-1"
                            type="button"
                            data-toggle="dropdown">
                            Attachment
                        </button>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" href="' . route('karyawan-detail', $item->id)  . '">
                                Tambah Attachment
                            </a>
                            <a class="dropdown-item" href="' . route('karyawan-attachment', $item->id)  . '">
                                View Attachment
                            </a>
                        </div>
                    </div>
                    </div>
                
                ';
            })
            ->addColumn('action', 'pages.admin.karyawan.karyawan-action')
             ->rawColumns(['button','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.admin.karyawan.index',[
            'company' => $company
        ]);

    }


  public function store(KaryawanRequest $request)
    { 
        $karyawanId = $request->id;
 
        $karyawan   =   Karyawan::updateOrCreate(
                    [
                     'id' => $karyawanId
                    ],
                    [
                    'companies_id' => $request->companies_id, 
                    'name' => $request->name, 
                    'tanggal' => $request->tanggal,
                    'pos_code' => $request->pos_code,
                    'pos_name' => $request->pos_name,
                    'organisasi_code' => $request->organisasi_code,
                    'organisasi_name' => $request->organisasi_name
                    ]);    
                         
             return Response()->json($karyawan);
    }



    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $karyawan  = Karyawan::where($where)->first();
      
        return Response()->json($karyawan);
    }



        public function destroy(Request $request)
    {
         $karyawan = Karyawan::where('id',$request->id)->delete();
      
        return Response()->json($karyawan);
    }

      public function tambah($id){
        $item = Karyawan::findOrFail($id);

        return view('pages.admin.karyawan.attachment',[
            'item' => $item
        ]);
    }

      public function updateattach(AttachmentRequest $request, $id)
    {
        $data = $request->all();

        $data['photo'] = $request->file('photo')->store('assets/files', 'public');

      
        Attachment::create($data);

        return redirect()->route('karyawan.index');
    }

        public function viewattach($id){

         $item = Attachment::with(['attachment'])->where('id_fitur', 2)->where('ref_id', $id)->get();
            

        return view('pages.admin.karyawan.attachmentview',[
            'item' => $item,
        ]);
    }
    



}

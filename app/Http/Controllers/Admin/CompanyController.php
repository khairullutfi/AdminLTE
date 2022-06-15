<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttachmentRequest;
use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Attachment;
use Attribute;

class CompanyController extends Controller
{
    public function index()
    {

         $company = Company::query();

       
        
        if(request()->ajax()) {
            return datatables()->of($company)
            ->addColumn('action', 'pages.admin.company.company-action')
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
                           <a class="dropdown-item" href="' . route('company-detail', $item->id)  . '">
                                Tambah Attachment
                            </a>
                            <a class="dropdown-item" href="' . route('attachment-detail', $item->id)  . '">
                                View Attachment
                            </a>
                        </div>
                    </div>
                    </div>
                
                ';
            })
            ->rawColumns(['button','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.admin.company.index');

    }


     public function store(CompanyRequest $request)
    { 
         $companyId = $request->id;

         $data['slug'] = Str::slug($request->name);
 
        $company   =   Company::updateOrCreate(
                    [
                     'id' => $companyId
                    ],
                    [
                    'name' => $request->name, 
                    'initial' => $request->initial,
                    'slug' => $data["slug"],
                    'code' => $request->code
                    ]);    
                         
        return Response()->json($company);


    }

    public function edit(Request $request)
    
    {
        $where = array('id' => $request->id);
        $company  = Company::where($where)->first();
      
        return Response()->json($company);
    }

    

    public function destroy(Request $request)
    {
       $company = Company::where('id',$request->id)->delete();
      
        return Response()->json($company);
    }

    public function tambah($id){
        $item = Company::findOrFail($id);

        return view('pages.admin.company.attachment',[
            'item' => $item
        ]);
    }

      public function updateattach(AttachmentRequest $request, $id)
    {
        $data = $request->all();

        $data['photo'] = $request->file('photo')->store('assets/files', 'public');

      
        Attachment::create($data);

        return redirect()->route('company.index');
    }

        public function viewattach($id){

         $item = Attachment::with(['attachment'])->where('id_fitur', 1)->where('ref_id', $id)->get();
         
 

        return view('pages.admin.company.attachmentview',[
            'item' => $item,
        ]);
    }

}

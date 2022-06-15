<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

// use storage
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Admin\AttachmentRequest;
use App\Models\Company;
use App\Models\Attachment;

// use slug
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
      // membuat relasinya
        $query = Attachment::with(['company', 'karyawan']);


        if(request()->ajax()) {
            return datatables()->of($query)
            ->addColumn('action', 'pages.admin.attachment.attachment-action')
            ->editColumn('photo', function($item){
                return $item->photo ? '<a href="'. Storage::url($item->photo) .'" style="" />Download File</a>' : '';
            })
            ->rawColumns(['action','photo'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.admin.attachment.index');

    }


  public function store(AttachmentRequest $request)
    { 
        $attachmentId = $request->id;

        $attachment = $request->all();

 
        $attachment['photo'] = $request->file('photo')->store('assets/files', 'public');
 
        $attachment   =   Attachment::updateOrCreate(
                    [
                     'id' => $attachmentId
                    ],
                    [
                    'id_fitur' => $request->id_fitur, 
                    'ref_id' => $request->ref_id, 
                    'filename' => $request->filename,
                    'photo' => $attachment["photo"],
                    ]);    
                         
             return Response()->json($attachment);
    }



    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $attachment  = Attachment::where($where)->first();
      
        return Response()->json($attachment);
    }



        public function destroy(Request $request)
    {
         $attachment = Attachment::where('id',$request->id)->delete();
      
        return Response()->json($attachment);
    }
}

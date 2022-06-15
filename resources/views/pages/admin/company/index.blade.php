@extends('layouts.admin')

@section('title')
Company
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Company</h2>
            <p class="dashboard-subtitle">
                List company
            </p>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a onClick="add()" href="javascript:void(0)" class="btn btn-primary mb-3">
                                + Tambah Company Baru
                            </a>
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100"
                                    id="ajax-crud-datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>initial</th>
                                            <th>code</th>
                                            <th>attachment</th>
                                            <th>button</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- boostrap company model -->
<div class="modal fade" id="company-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="CompanyModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Company Name" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Initial</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="initial" name="initial"
                                placeholder="Enter Initial" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Code</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="code" name="code" placeholder="Enter Code"
                                required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- boostrap company model -->
<div class="modal fade" id="company-modalattach" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="CompanyModalattach"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="CompanyFormattach" name="CompanyFormattach"
                    class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Company Name" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Initial</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="initial" name="initial"
                                placeholder="Enter Initial" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Foto product</label>
                            <input type="file" name="photo" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
<script type="text/javascript">
    $(document).ready( function () {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#ajax-crud-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url('admin/company-show') }}",
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'initial', name: 'initial' },
    { data: 'code', name: 'code' },
    { data: 'button', name: 'button' },
    {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
    });
    });


function add(){
$('#CompanyForm').trigger("reset");
$('#CompanyModal').html("Add Company");
$('#company-modal').modal('show');
$('#id').val('');
}

function attach(){
$('#CompanyFormattach').trigger("reset");
$('#CompanyModalattach').html("Add Company");
$('#company-modalattach').modal('show');
$('#id').val('');
}

function attachfunc(id){
$.ajax({
type:"POST",
url: "{{ url('admin/tambah-attachment') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#CompanyModalattach').html("Tambah Attachment Company");
$('#company-modalattach').modal('show');
$('#id').val(res.id);
$('#name').val(res.name);
$('#initial').val(res.initial);
}
});
}

function deleteFunc(id){
if (confirm("Delete Record?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('admin/delete-company') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}

function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('admin/edit-company') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#CompanyModal').html("Edit Company");
$('#company-modal').modal('show');
$('#id').val(res.id);
$('#name').val(res.name);
$('#initial').val(res.initial);
$('#code').val(res.code);

}
});
}





$('#CompanyForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('admin/store-company')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#company-modal").modal('hide');
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
$("#btn-save").html('Submit');
$("#btn-save"). attr("disabled", false);
},
error: function(data){
console.log(data);
}
});
});
</script>
@endpush
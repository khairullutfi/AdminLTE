@extends('layouts.admin')

@section('title')
Attachment
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Attachment</h2>
            <p class="dashboard-subtitle">
                List Company
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
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100"
                                    id="ajax-crud-datatable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>name</th>
                                            <th>file name</th>
                                            <th>File</th>
                                            <th>Action</th>
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

<div class="modal fade" id="attachment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="AttachmentModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="AttachmentForm" name="AttachmentForm" class="form-horizontal"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ref id</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="id_fitur" name="id_fitur"
                                placeholder="Enter Pos Code" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ref id</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="ref_id" name="ref_id"
                                placeholder="Enter ref id" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">File Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="filename" name="filename"
                                placeholder="Enter Pos Code" required>
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
<script>
    $(document).ready( function () {
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/show-attachment') }}",
        columns: [
        { data: 'id', name: 'id'},
        { data: 'company.name', name: 'company.name'},
        { data: 'filename', name: 'filename'},
        { data: 'photo', name: 'photo'},
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
        });
        });
        function add(){
        $('#AttachmentForm').trigger("reset");
        $('#AttachmentModal').html("Add Attachment");
        $('#attachment-modal').modal('show');
        $('#id').val('');
        }
        
        function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
        // ajax
        $.ajax({
        type:"POST",
        url: "{{ url('admin/delete-attachment') }}",
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
        url: "{{ url('admin/edit-attachment') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
        $('#AttachmentModal').html("Edit Attachment");
        $('#attachment-modal').modal('show');
        $('#id').val(res.id);
        $('#companies_id').val(res.companies_id);
        $('#name').val(res.name);
        $('#tanggal').val(res.tanggal);
        $('#pos_code').val(res.pos_code);
        $('#pos_name').val(res.pos_name);
        $('#organisasi_code').val(res.organisasi_code);
        $('#organisasi_name').val(res.organisasi_name);
        }
        });
        }
        
        
        $('#AttachmentForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
        type:'POST',
        url: "{{ url('admin/store-attachment')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
        $("#attachment-modal").modal('hide');
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
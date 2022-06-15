@extends('layouts.admin')

@section('title')
Karyawan
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Karyawan</h2>
            <p class="dashboard-subtitle">
                List karyawan
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
                                + Tambah Karyawan Baru
                            </a>
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100"
                                    id="ajax-crud-datatable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>perusahaan</th>
                                            <th>nama</th>
                                            <th>tanggal</th>
                                            <th>pos name</th>
                                            <th>pos code</th>
                                            <th>organisasi name</th>
                                            <th>organisasi code</th>
                                            <th>attachment</th>
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

<div class="modal fade" id="karyawan-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="KaryawanModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="KaryawanForm" name="KaryawanForm" class="form-horizontal"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Perusahaan</label>
                            <select name="companies_id" class="form-control">
                                @foreach ($company as $companies)
                                <option value="{{$companies->id}}">{{$companies->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Company Name" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">tanggal</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Enter tanggal" value="{{old('date')}}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pos Code</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="pos_code" name="pos_code"
                                placeholder="Enter Pos Code" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pos_name" class="col-sm-2 control-label">Pos Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="pos_name" name="pos_name"
                                placeholder="Enter Karyawan Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">organisasi name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="organisasi_name" name="organisasi_name"
                                placeholder="Enter organisasi name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="organisasi_code" class="col-sm-2 control-label">organisasi code</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="organisasi_code" name="organisasi_code"
                                placeholder="Enter Karyawan Name" required>
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
        ajax: "{{ url('admin/karyawan-show') }}",
        columns: [
        { data: 'id', name: 'id'},
        { data: 'company.name', name: 'company.name'},
        { data: 'name', name: 'name'},
        { data: 'tanggal', name: 'tanggal'},
        { data: 'pos_name', name: 'pos_name'},
        { data: 'pos_code', name: 'pos_code'},
        { data: 'organisasi_name', name: 'organisasi_name'},
        { data: 'organisasi_code', name: 'organisasi_code'},
        { data: 'button', name: 'button' },
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
        });
        });
        function add(){
        $('#KaryawanForm').trigger("reset");
        $('#KaryawanModal').html("Add Karyawan");
        $('#karyawan-modal').modal('show');
        $('#id').val('');
        }
        
        function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
        // ajax
        $.ajax({
        type:"POST",
        url: "{{ url('admin/delete-karyawan') }}",
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
        url: "{{ url('admin/edit-karyawan') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
        $('#KaryawanModal').html("Edit Karyawan");
        $('#karyawan-modal').modal('show');
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
        
        
        $('#KaryawanForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
        type:'POST',
        url: "{{ url('admin/store-karyawan')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
        $("#karyawan-modal").modal('hide');
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
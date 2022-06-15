<div class="btn-group">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
            Aksi
        </button>
        <div class="dropdown-menu">
            <a href="javascript:void(0)" data-toggle="tooltip" class="dropdown-item" onClick="editFunc({{ $id }})"
                data-original-title="Edit">
                edit
            </a>
            <a href="javascript:void(0);" id="delete-company" data-toggle="tooltip" class="dropdown-item text-danger"
                onClick="deleteFunc({{ $id }})" data-original-title="Delete">
                hapus
            </a>
        </div>
    </div>
</div>
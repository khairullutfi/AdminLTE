@extends('layouts.admin')

@section('title')
Company
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">tambah attachment company</h2>
            <p class="dashboard-subtitle">
                tambah attachment
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li> {{ $error}} </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('company-update', $item->id)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" id="id_fitur" name="id_fitur"
                                            value="1" hidden required>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" id="ref_id" name="ref_id"
                                            value="{{ $item->id }}" hidden required>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">File Company</label>
                                            <input type="file" name="photo" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-group">File Name</label>
                                        <input type="text" class="form-control" id="filename" name="filename"
                                            placeholder="Enter Pos Code" required>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-success px-5">
                                            Save Now
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@extends('layouts.admin')

@section('title')
Company
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">view attachment company</h2>
            <p class="dashboard-subtitle">
                view attachment
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @forelse ($item as $items)
                                <div class="col-6 col-md-3 col-lg-1">
                                    <a class="component-categories d-block" href="{{Storage::url($items->photo)}}">
                                        <div class="categories-image">
                                            <img src="/img/ic_remove.svg" class="w-100" />
                                        </div>
                                        <p class="categories-text text-center text-black">
                                            {{$items->filename}}
                                        </p>
                                    </a>
                                </div>
                                @empty
                                No attachment Found
                                @endforelse
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
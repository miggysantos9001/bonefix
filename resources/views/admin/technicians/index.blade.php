@extends('layouts.master')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Technician Module</h2>
    </header> 
    <div class="row">
        <div class="col-12">
            @include('alert')
        </div>
        <div class="col-3">
            <section class="card">
                <header class="card-header">
                    <h4 class="card-title">Create Technician</h4>
                </header>
                {!! Form::open(['model'=>'POST','action'=>'TechnicianController@store']) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Technician Name') !!}
                                {!! Form::text('name',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Technician Code') !!}
                                {!! Form::text('code',null,['class'=>'form-control form-control-sm']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Select Tech Category') !!}
                                {!! Form::select('tech_category_id',$cat,null,['class'=>'select2 form-control form-control-sm','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> Save Entry</button>
                </div>
                {!! Form::close() !!}
            </section>
        </div>
        <div class="col-9">
            <section class="card">
                <header class="card-header">
                    <h4 class="card-title">Technician List</h4>
                </header>
                <div class="card-body">
                    <section class="card">
                        <div class="card-body">
                            <form class="row gx-3 gy-2 mb-2 align-items-center" method="GET" action="">
                                @csrf
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" name="searchName" placeholder="Search Technician Entry">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{ route('technicians.index') }}" class="btn btn-success btn-xs"><i class="fa fa-retweet"></i> Reset Search</a>
                                </div>
                            </form>
                        </div>
                    </section>
                    <table class="table table-sm table-condensed table-no-more" style="text-transform:uppercase;font-size:12px;">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">#</th>
                                <th class="">Name</th>
                                <th class="">Code</th>
                                <th class="">Category</th>
                                <th class="text-center" width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                                <td data-title="#" class="text-center">{{ $loop->iteration }}</td>
                                <td data-title="Name" class="">
                                    {{ $d->name }}
                                </td>
                                <td data-title="Code" class="">
                                    {{ $d->code }}
                                </td>
                                <td data-title="Category" class="">
                                    {{ ($d->tech_category_id == NULL) ? '-' : $d->tech_cat->name }}
                                </td>
                                <td data-title="Action" class="text-center">
                                    <div class="btn-group flex-wrap">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-wrench"></i><span class="caret"></span></button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item text-1" data-bs-target="#edit{{ $d->id }}" data-bs-toggle="modal">Edit Entry</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">NO RECORD FOUND</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $data->links() !!}
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
@push('modals')
@foreach($data as $d)
<div id="edit{{ $d->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['method'=>'PATCH','action'=>['TechnicianController@update',$d->id]]) !!}
            <div class="modal-header">
                <h5 class="modal-title style1" id="exampleLargeModalLabel">Update Entry</h5>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Technician Name') !!}
                            {!! Form::text('name',$d->name,['class'=>'form-control form-control-sm']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Technician Code') !!}
                            {!! Form::text('code',$d->code,['class'=>'form-control form-control-sm']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Select Tech Category') !!}
                            {!! Form::select('tech_category_id',$cat,$d->tech_category_id,['class'=>'select2 form-control form-control-sm','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal"><i class="fa fa-door-closed"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> Save Entry</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach
@endpush
@extends('layouts.base')


@section('content')
<div class="section-header">
    <h1>Roles {{ $role->name }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item">View Roles</a></div>
    </div>
</div>

<div class="section-body">
    <div class="card">
                  <div class="card-header">
                  <button class="btn btn-icon btn-outline-warning" onclick="window.history.back()"><i class="fa fa-arrow-circle-left"></i> Kembali</button> 
                  </div>
                  <div class="card-body">
                    <ul class="list-group">
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary badge-pill"> {{ $v->name }}</span>
                      </li>
                        @endforeach
                        @endif
                     
                    
                    </ul>
                  </div>
                </div>
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $role->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permissions:</strong>
                        @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                        <label class="label label-success">{{ $v->name }},</label>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div> -->
  
</div>
@endsection

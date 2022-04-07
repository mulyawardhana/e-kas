@extends('layouts.base')


@section('content')
<div class="section-header">
    <h1>Edit Roles</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item">Edit Roles</a></div>
    </div>
</div>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
    <form action="{{route('roles.update', $role->id)}}" method="POST">
    @csrf
    @method('PATCH')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for=""><strong>Role Name</strong></label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{$role->name}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <label for=""><strong>Permissions</strong></label>
                    <br>
                    <input type="checkbox" name="selectThemAll" class="checkAll"/><strong> Select All</strong><br/>
                    <hr>
                    <div class="row mb-1">
                           <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect12"/> <strong> Select All Akun Bank</strong><br/>
                            @foreach($permissions12 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect12')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect2"/> <strong> Select All User</strong><br/>
                            @foreach($permissions1 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect2')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect1"/><strong> Select All Role</strong><br/>
                            @foreach($permissions as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect1')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect3"/> <strong> Select All Klasifikasi</strong><br/>
                            @foreach($permissions2 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect3')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                      
                    </div>
                    <div class="row">
                    <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect4"/> <strong> Select All Jabatan</strong><br/>
                            @foreach($permissions3 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect4')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect5"/><strong> Select All Pemeriksa Kas</strong><br/>
                            @foreach($permissions4 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect5')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect6"/> <strong> Select All Jenis Kas</strong><br/>
                            @foreach($permissions5 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect6')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect7"/> <strong> Select All Pemakaian Kas</strong><br/>
                            @foreach($permissions6 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect7')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect8"/> <strong> Select All Pengisian Kas</strong><br/>
                            @foreach($permissions7 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect8')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect9"/> <strong> Select All Posting Kas</strong><br/>
                            @foreach($permissions8 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect9')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect13"/> <strong> Select All Kasbon</strong><br/>
                            @foreach($permissions13 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect13')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect14"/> <strong> Select All LPJ Kasbon</strong><br/>
                            @foreach($permissions14 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect14')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect11"/> <strong> Select All Report Operasional</strong><br/>
                            @foreach($permissions11 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect11')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect15"/> <strong> Select All Report Nasional</strong><br/>
                            @foreach($permissions15 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect15')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect16"/> <strong> Select All Report LPJ</strong><br/>
                            @foreach($permissions16 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect16')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect27"/> <strong> Select All Kasopname </strong><br/>
                            @foreach($permissions9 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect27')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3">
                            <input type="checkbox" name="chkSelectAll" class="checkAll" data-checkwhat="chkSelect17"/> <strong> Select All Efilling</strong><br/>
                            @foreach($permissions17 as $permission)
                            {{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'chkSelect17')) }} {{$permission->name}}<br/>
                            @endforeach
                        </div>
                    </div>

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-dark btn-block">Submit</button>
    </div>
</div>
</form>
    </div>
</div>



<script>
    $(function() {
        jQuery("[name=selectThemAll]").click(function(source) { 
            checkboxes = jQuery("[id=permissions]");
            for(var i in checkboxes){
                checkboxes[i].checked = source.target.checked;
            }
        });
    })
    </script> 
    <script>
    $(function() {
    $(".checkAll").click(function(){
        checkwhat  = $(this).data("checkwhat");
        $('input:checkbox.'+checkwhat).not(this).prop('checked', this.checked);
    });
  });
    </script>
@endsection
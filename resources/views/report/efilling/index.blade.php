@extends('layouts.base')

@section('content')
@php 
$years = range(2020, strftime("%Y", time()));
@endphp
<div class="section-header">
    <h1>Attachemnt E-filling Cashopname</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('efilling-cashopname.index')}}">Efilling - Cashopname</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('efilling-cashopname.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" name="efilling_pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><button class="btn btn-primary btn-block"
                                        type="submit">Sumbit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-md data-table" id="tabel-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <!-- <th>User</th> -->
                                    <th>BranchName</th>
                                    <th>Effiling CashOpname</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($efillings as $i=>$efilling)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <!-- <td>{{$efilling->user->name}}</td> -->
                                    <td>{{$efilling->user->branch_name}}</td>
                                    <td><a href="{{asset('/file_efilling/'.$efilling->efilling_pdf)}}" target="_blank"><i
                                    class="fas fa-download"></i>{{$efilling->efilling_pdf}}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


@endsection

@extends('layouts.base')

@section('content')
<div class="section-header">
    <h1>Pemakaian Kas Opname</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{route('pemakaian-kas.index')}}">Pemakaian-kas</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
        
            <div class="card">
                <div class="card-header d-flex">
                    <a class="btn btn-danger" href="{{route('kas-opname.create')}}">
                        <i class="fas fa-plus-circle"></i> Input Kas Opname 
                    </a>
                </div>
                <div class="card-body">
                    <!-- <a href="#" class="btn btn-danger mb-2"><i class="fas fa-print"></i> Print</a> -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-md data-table" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashOpname as $i=>$c)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$c->month_year}}</td>
                                        <td><a href="{{route('print.cashopname',$c->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-print"></i></a></td>
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


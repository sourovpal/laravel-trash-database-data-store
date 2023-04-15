@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="ti-trash fa-fw"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')

@endpush

@section('content')

@if(request()->table != "" && request()->action == "restore")
    @php
        DB::table(''.request()->table.'')->where('deleted_at', request()->deleted_at)->update(array('deleted_at' => NULL)); 
    @endphp
@endif

@if(request()->table != "" && request()->action == "delete")
    @php
        //DB::table(''.request()->table.'')->where('deleted_at', request()->deleted_at)->delete(); 
    @endphp
@endif


<br><br>
<div class="" style="padding:0px 35px;">
    
    <div class="row">
        <div class="col-lg-3">
            <ul class="list-group">
              <li class="list-group-item active"><h5 class="text-white">Tables</h5></li>
              @php
              @endphp
              @foreach(DB::select('SHOW TABLES') as $tbl)
              @if(count(DB::select("SELECT * FROM ".$tbl->Tables_in_busivcqs_imle." WHERE deleted_at > 0")))
                <li class="list-group-item"><a class="list-group-link text-dark" href="?table={{$tbl->Tables_in_busivcqs_imle}}">{{$tbl->Tables_in_busivcqs_imle}}</a></li>
              @endif
              @endforeach
            </ul>
        </div>
        <div class="col-lg-9">
            <div style="display: flex;justify-content: space-between;align-items: center;">
                <div><h3>Table: {{request()->table}}</h3></div>
                <div>
                    <a class="btn btn-sm btn-info" href="">Download</a>
                </div>
            </div>
            <div style="overflow:auto;">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                        @php
                        $deleted_at = null;
                        @endphp
                        @foreach(DB::select("SELECT * FROM ".request()->table." LIMIT 1") as $fields)
                            @foreach($fields as $field => $val)
                                <th scope="col">{{$field}}</th>
                            @endforeach
                        @endforeach
                        <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach(DB::select("SELECT * FROM ".request()->table." WHERE deleted_at > 0") as $rows)
                        <tr>
                            @foreach($rows as $key => $val)
                                @if($key == 'deleted_at')
                                    @php
                                        $deleted_at = $val;
                                    @endphp
                                @endif
                                <td>{{$val}}</td>
                            @endforeach
                                <td>
                                    <a class="btn btn-sm btn-info" href="?table={{request()->table}}&deleted_at={{$deleted_at}}&action=restore">
                                        <i class="icon-layers fa-fw" style="padding-left: 3px;"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Delete Permanently?')" href="?table={{request()->table}}&deleted_at={{$deleted_at}}&action=delete">
                                        <i class="icon-trash fa-fw" style="padding-left: 3px;"></i>
                                    </a>
                                </td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

@endsection

@push('footer-script')


@endpush


@extends('layouts.app')
@section('title', 'Assign Permission |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Assign Permission</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Assign Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST"
                        action="{{ route('admin.assign-permission',encrypt($role->id)) }}">
                        {{csrf_field()}}
                            <div class="row mb-4">
                                @php
                                    $groupData = [];
                                    $pivot = [];
                                @endphp
                                @if(count($rolePermission) > 0)
                                    @foreach($rolePermission as $row)
                                        @php
                                            $groupData[] = $row->group;
                                            $pivot[] = $row->pivot->permission_id;
                                        @endphp
                                    @endforeach
                                @endif
                                @foreach($permission as $key => $value)
                                    <div class="col-md-3 mb-2 mb-4">
                                        <input type="checkbox" class="select-all"
                                        data-key="{{$key}}"
                                        {{ in_array($key, $groupData) ? 'checked' : '' }}>
                                        &nbsp;<b>{{ ucfirst($key) }}</b>
                                        <br><br>
                                        <div class="row">
                                            @foreach($value as $group)
                                                <div class="col-md-12">
                                                    <input type="checkbox" name="permissions[]"
                                                    value="{{$group->id}}"
                                                    class="child-group-{{$key}}"
                                                    {{ in_array($group->id, $pivot) ? 'checked' : '' }} >
                                                    &nbsp;{{$group->name}}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                @if ($errors->has('permissions'))
                                    <span class="help-block">
                                        {{ $errors->first('permissions') }}
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary me-2"> Submit </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-dark">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script>
    $('.select-all').on('click',function(){
        var key = $(this).attr('data-key');
        if(this.checked){
            $('.child-group-'+key).each(function(){
                this.checked = true;
            });
        }else{
             $('.child-group-'+key).each(function(){
                this.checked = false;
            });
        }
    })
</script>
@endsection

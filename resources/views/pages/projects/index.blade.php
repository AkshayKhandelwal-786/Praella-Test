@extends('layouts.app')
@section('title', 'List Projects |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">List Projects</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Projects</li>
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
                        <div class="text-right mb-2">
                            @if(Auth::user()->can(config('constant.add-project')))
                                <a href="{{ route('projects.create') }}" class="btn btn-primary btn-md">Add Project</a>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dtable" id="users-table">
                                <caption></caption>
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Staus</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($projects as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>
                                                @if($row->status == $active)
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-success"
                                                        title="Active">Active</a>
                                                    </span>
                                                @else
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-danger"
                                                        title="Inactive">Inactive</a>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
                                            <td>
                                                <form
                                                action="{{ route('projects.destroy',encrypt($row->id)) }}"
                                                method="POST">
                                                    <span class='f-left margin-r-5'>
                                                        @if(Auth::user()->can(config('constant.edit-project')))
                                                            <a data-toggle='tooltip'
                                                            class='btn btn-primary btn-xs'
                                                            title='Edit'
                                                            href="{{ route('projects.edit',encrypt($row->id)) }}">
                                                                <i class="fa fa-edit"aria-hidden='true'></i>
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                        @if(Auth::user()->can(config('constant.delete-project')))
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                            onclick="return confirm(
                                                                'Are you sure to delete this project?'
                                                            )"
                                                            data-toggle='tooltip'
                                                            title='Delete'
                                                            class="btn btn-xs btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            -
                                                        @endif
                                                    </span>
                                                </form>
                                            </td>
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
</div>
@endsection
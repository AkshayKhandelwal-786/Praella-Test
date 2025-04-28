@extends('layouts.app')
@section('title', 'List Tasks |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">List Tasks</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Tasks</li>
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
                            @if(Auth::user()->can(config('constant.add-task')))
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-md">Add Task</a>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dtable" id="users-table">
                                <caption></caption>
                                <thead>
                                    <th>ID</th>
                                    <th>Project Name</th>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th>Staus</th>
                                    <th>Start Date</th>
                                    <th>Deadline</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($task as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->project->name }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>
                                                @if($row->priority == $priority['low'])
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-warning"
                                                        title="Low">Low</a>
                                                    </span>
                                                @elseif($row->priority == $priority['medium'])
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-info"
                                                        title="Medium">Medium</a>
                                                    </span>
                                                @else
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-success"
                                                        title="High">High</a>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->status == $status['todo'])
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-warning"
                                                        title="To Do">To Do</a>
                                                    </span>
                                                @elseif($row->status == $status['inprogress'])
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-info"
                                                        title="In Progress">In Progress</a>
                                                    </span>
                                                @else
                                                    <span class="f-left margin-r-5 1">
                                                        <a href="javascript:void(0)"
                                                        class="btn btn-xs btn-success"
                                                        title="Completed">Completed</a>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-M-Y',strtotime($row->start_date)) }}</td>
                                            <td>{{ date('d-M-Y',strtotime($row->deadline)) }}</td>
                                            <td>
                                                <form
                                                action="{{ route('tasks.destroy', encrypt($row->id)) }}"
                                                method="POST">
                                                    <span class='f-left margin-r-5'>
                                                        @if(Auth::user()->can(config('constant.edit-task')))
                                                            <a data-toggle='tooltip'
                                                            class='btn btn-primary btn-xs'
                                                            title='Edit'
                                                            href="{{ route('tasks.edit', encrypt($row->id)) }}">
                                                                <i class="fa fa-edit"aria-hidden='true'></i>
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->can(config('constant.delete-task')))
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                            onclick="return confirm(
                                                                'Are you sure to delete this task?'
                                                            )"
                                                            data-toggle='tooltip'
                                                            title='Delete'
                                                            class="btn btn-xs btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
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
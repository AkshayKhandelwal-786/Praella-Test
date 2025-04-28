@extends('layouts.app')
@section('title', 'List Users |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">List Users</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                        @if(Auth::user()->can(config('constant.add-user')))
                            <div class="text-right mb-2">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-md">Add User</a>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dtable" id="users-table">
                                <caption></caption>
                                <thead>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($users as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                @if(!empty($row->profile_picture))
                                                    <img src="{{ url($row->profile_picture) }}" height="70"
                                                    width="" alt="Profile Image">
                                                @else
                                                    <img src="{{ url('assets/images/no-image.png') }}" height="70"
                                                    width="" alt="Profile Image">
                                                @endif
                                            </td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email  }}</td>
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
                                            <td>{{ isset($row->roles[0])
                                                ? $row->roles[0]['name'] : '-' }}
                                            </td>
                                            <td>{{ date('d-M-Y h:i a',strtotime($row->created_at)) }}
                                            </td>
                                            <td>
                                                @if($row->roles[0]['name'] != $role)
                                                    <form
                                                    action="{{ route('users.destroy', encrypt($row->id)) }}"
                                                    method="POST">
                                                        <span class='f-left margin-r-5'>
                                                            @if(Auth::user()->can(config('constant.edit-user')))
                                                                <a data-toggle='tooltip'
                                                                class='btn btn-primary btn-xs'
                                                                title='Edit'
                                                                href="{{ route('users.edit',encrypt($row->id)) }}">
                                                                    <i class="fa fa-edit"aria-hidden='true'></i>
                                                                </a>
                                                            @endif
                                                            @if(Auth::user()->can(config('constant.delete-user')))
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                onclick="return confirm(
                                                                    'Are you sure to delete this user?'
                                                                )"
                                                                data-toggle='tooltip'
                                                                title='Delete'
                                                                class="btn btn-xs btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        </span>
                                                    </form>
                                                @else
                                                    -
                                                @endif
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
@section('page-script')
    @if(session('message'))
        <script>
            $(document).ready(function() {
                toastr.success('{{ session('message') }}');
            });
        </script>
    @endif
@endsection

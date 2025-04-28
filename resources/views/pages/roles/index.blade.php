@extends('  layouts.app')
@section('title', 'List Role |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Role</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dtable" id="users-table">
                                <caption></caption>
                                <thead>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                    <th>Role Type</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($role as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>
                                                @if($row->is_primary == $primary)
                                                    Primary
                                                    <a href="javascript:void(0)"
                                                    data-toggle="tooltip"
                                                    title="This is the primary role which can
                                                    not be edit or delete. This role is fixed
                                                    from developers">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ date('d-M-Y h:i a',strtotime($row->created_at)) }}</td>
                                            <td>
                                                @if($row->is_primary != $primary)
                                                    <a href="{{ route('admin.assign-permission',encrypt($row->id)) }}"
                                                    class="btn btn-info btn-rounded">
                                                    Assign Permission</a>
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

@extends('layouts.app')
@section('title', 'List Comments |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">List Comments</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Comments</li>
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
                            @if($roleName == $role)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Add Comment</button>       
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dtable" id="users-table">
                                <caption></caption>
                                <thead>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Project Name</th>
                                    <th>Task</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($comment as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ $row->user->email  }}</td>
                                            <td>{{ $row->project->name }}</td>
                                            <td>{{ $row->task->title }}</td>
                                            <td>{{ date('d-M-Y h:i a',strtotime($row->created_at)) }}</td>
                                            <td>
                                                <form
                                                action="{{ route('comments.destroy', encrypt($row->id)) }}"
                                                method="POST">
                                                    <span class='f-left margin-r-5'>
                                                        <a data-toggle='tooltip'
                                                        class='btn btn-primary btn-xs'
                                                        title='View'
                                                        href="{{ route('comments.show',encrypt($row->task_id)) }}">
                                                            <i class="fa fa-eye"aria-hidden='true'></i>
                                                        </a>
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

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form method="POST" accept-charset="UTF-8" id="submit-form" autocomplete="off" action="{{ route('comments.store') }}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="float:left;">Add Comment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-widget">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Project</label><span class="help-block">*</span>
                                        <select class="form-control"
                                        id="project" name="project" >
                                            <option value="">Select Project</option>
                                            @if(count($project) > 0)
                                                @foreach($project as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No Project Found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Task</label><span class="help-block">*</span>
                                        <select class="form-control"
                                        id="task" name="task" >
                                            <option value="">Select Task</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment</label><span class="help-block">*</span>
                                        <textarea class="form-control" placeholder="Enter comment" id="comment"
                                        name="comment" maxlength="255" rows="5" >{{ old('comment') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Attachments</label>
                                        <input type="file" id="file" data-default-file=""
                                        name="file" class="dropify"
                                        data-height="100" data-show-remove="false"
                                        data-allowed-file-extensions="png jpeg jpg"
                                        data-max-file-size="3M"
                                        accept=".jpg,.png,.jpeg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
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
<script>
var spinner = $('.preloader');
$('#project').on('change', function () {
    var project_id = this.value;
    
    $("#task").html('');
    $.ajax({
        url: "{{ route('admin.list-task') }}",
        type: "POST",
        data: {
            project_id: project_id,
            _token: '{{csrf_token()}}',
        },
        dataType: 'json',
        success: function (result) {
            if(result.status == true)
            {
                if(result.message.length > 0)
                {
                    $('#task').html('<option value="">Select Task</option>')
                    $.each(result.message, function (key, value) {
                        $("#task").append('<option value="' + value
                            .id + '">' + value.title + '</option>');
                    });
                }
                else
                {
                    $('#task').html('<option value="">Select Task</option>')
                    $('#task').append('<option value="">No Data Found</option>')
                }
            }
            if(result.status == false)
            {
                toastr.error(result.message,{timeOut: 5000});
            }
        }
    });
});
$('#submit-form').on('submit',function(e){
    	e.preventDefault();
        var route = $(this).attr('action');
		var formData = new FormData(this);
        $.ajax({
            url: route,
            type:"POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                spinner.show();
            },
            success: (response) => {
                if(response.status == true){
                    location.reload();
                }else{
                    toastr.error(response.message);
                }
                spinner.hide();
            },
            error: function(response)
            {                
                $('.text-danger').remove();
                spinner.hide();
                $.each(response.responseJSON.errors, function(key, value) {
                    $('#' + key).closest('.form-group').append('<span class="text-danger">'+value+'</span>');
                });
            }
        });
    });
</script>
@endsection

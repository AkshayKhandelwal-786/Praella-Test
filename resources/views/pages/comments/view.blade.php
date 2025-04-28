@extends('layouts.app')
@section('title', 'View Comments |')
@section('content')

@section('page-style')
    <link rel="stylesheet" href="{{ url('dist/css/AdminLTE.min.css') }}">
@endsection

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">View Comments</h4>
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
                            <a class="btn btn-secondary" href="{{ route('tasks.index') }}">Back</a>
                        </div>
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered dtable">
                                        <caption></caption>
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <td>{{ $task->project->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Task</th>
                                                <td>{{ $task->title }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
            <div class="box box-widget">
                @foreach($comment as $row) 
                    <div class="box-header with-border">
                        <div class="user-block">
                            @if(!empty($row->user->profile_picture))
                                <img src="{{ url($row->user->profile_picture) }}">
                            @else
                                <img src="{{ url('assets/images/users/1.jpg') }}">
                            @endif
                            <span class="username"><a href="#">{{ $row->user->name }}</a></span>
                            <span class="description">{{ date('d-M-Y h:i a',strtotime($row->created_at)) }}</span>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(!empty($row->file))
                            <div class="attachment-block clearfix">
                                <img class="attachment-img" src="{{ url($row->file) }}" alt="Attachment Image">
                                <div class="attachment-pushed">
                                    <div class="attachment-text">
                                        {{ $row->comments }}
                                        @if($roleName != $role)
                                            <button type="button" onClick="replyComment('{{ $row->id }}', '{{ e($row->comments) }}')" class="btn btn-primary btn-xs">
                                                <i class="fa fa-reply"></i> Reply
                                            </button>
                                        @endif
                                    </div>
                                    @if(count($row->comment_reply) > 0)
                                        <div class="box-footer box-comments">
                                            @foreach($row->comment_reply as $data)
                                                <div class="box-comment">
                                                    @if(!empty($data->user->profile_picture))
                                                        <img class="img-circle img-sm" src="{{ url($data->user->profile_picture) }}">
                                                    @else
                                                        <img class="img-circle img-sm" src="{{ url('assets/images/users/1.jpg') }}">
                                                    @endif

                                                    <div class="comment-text">
                                                        <span class="username">
                                                            {{ $data->user->name }}
                                                            <span class="text-muted pull-right">{{ date('d-M-Y h:i a',strtotime($data->created_at)) }}y</span>
                                                        </span>
                                                        @if(!empty($data->file))
                                                        <div class="attachment-block clearfix">
                                                            <img class="attachment-img" src="{{ url($data->file) }}" alt="Attachment Image">
                                                            <div style="margin-left:40px">
                                                                <div class="attachment-text">
                                                                    {{ $row->comments }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                            <p>{{ $data->comments }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p>{{ $row->comments }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form method="POST" accept-charset="UTF-8" id="submit-form" autocomplete="off" action="{{ route('admin.reply-comment') }}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" class="form-control" id="comment_id" name="comment_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="float:left;">Reply Comment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-widget">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" placeholder="Enter comment" maxlength="255" rows="5" id="description" readonly></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment Reply</label><span class="help-block">*</span>
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

    function replyComment(commentId, comment)
    {
        $('#comment_id').val(commentId);
        $('#description').val(comment);
        $('#modal-default').modal('show');
    }
</script>
@endsection
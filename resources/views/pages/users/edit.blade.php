@extends('layouts.app')
@section('title', 'Edit Users |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Edit Users</h4>
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
                        <form method="POST" accept-charset="UTF-8"
                        class="updateUser" action="{{ route('users.update', encrypt($user->id)) }}" id="submit-form" autocomplete="off" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @method('PUT')
                            <input type="hidden" class="form-control" id="user_id"
                            name="user_id" value="{{ encrypt($user->id) }}"  >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label><span class="help-block">*</span>
                                        <input type="text" placeholder="Enter Name"
                                        class="form-control" value="{{ $user->name }}"
                                        id="name" name="name" maxlength="50" >
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" placeholder="Enter Password"
                                        class="form-control"
                                        id="password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label><span class="help-block">*</span>
                                        <input type="text"
                                        placeholder="Enter Phone Number"
                                        class="form-control"
                                        id="phone_number"
                                        name="phone_number"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').
                                        replace(/(\..*)\./g, '$1');"
                                        value="{{ $user->phone_number }}"
                                        maxlength="15" >
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label><span class="help-block">*</span>
                                        <select class="form-control"
                                        id="role" name="role" >
                                            <option value="">Select Role</option>
                                            @if(count($role) > 0)
                                                @foreach($role as $row)
                                                    <option value="{{$row->name}}" {{ optional( isset($user->roles[0])
                                                        ? $user->roles[0] : ''  )->id == $row->id
                                                        ? 'selected' : '' }}>
                                                        {{$row->name}}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">No Role Found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" id="profile_picture" data-default-file="{{ !empty($user->profile_picture) ? url($user->profile_picture) : '' }}"
                                        name="profile_picture" class="dropify"
                                        data-height="100" data-show-remove="false"
                                        data-allowed-file-extensions="png jpeg jpg"
                                        data-max-file-size="3M"
                                        accept=".jpg,.png,.jpeg">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label><span class="help-block">*</span>
                                        <input type="email" placeholder="Enter Email"
                                        class="form-control" value="{{ $user->email }}"
                                        id="email" name="email" maxlength="100" >
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" placeholder="Enter Confirm Password"
                                        class="form-control"
                                        id="confirm_password" name="confirm_password"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label><span class="help-block">*</span>
                                        <select class="form-control"
                                        id="status" name="status" >
                                            <option value="">Select Status</option>
                                            <option value="{{ $status['Active'] }}" {{ $user->status  == $status['Active'] ? 'selected': '' }}>
                                            Active</option>
                                            <option value="{{ $status['Inactive'] }}" {{ $user->status  == $status['Inactive'] ? 'selected': '' }}>
                                            Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group project">
                                        <label>Project</label><span class="help-block">*</span>
                                        <select class="form-control"
                                        id="project" name="project[]" multiple>
                                            <option value="">Select Project</option>
                                            @if(count($project) > 0)
                                                @foreach($project as $row)
                                                    <option value="{{ $row->id }}" {{ in_array($row->id, $userProject) ? 'selected' : '' }}>{{ $row->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No Project Found</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea class="form-control" placeholder="Enter Bio"
                                        name="bio" maxlength="255" rows="4">{{ $user->bio }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="submit-btn" type="submit">
                                <span id="licon"></span>Update
                            </button>
                            <a class="btn btn-secondary" href="{{ route('users.index') }}">Back</a>
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
    var spinner = $('.preloader');
    $('.updateUser').on('submit',function(e){
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
                    window.location.href = "{{ route('users.index') }}";
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
    var id = '#project';
    var placeholder = 'Select Project';
    var userRole  = '{{ $userRole }}';
</script>
<script src="{{ url('js/select2.js') }}"></script>
@endsection

@extends('layouts.app')
@section('title', 'Add Tasks |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Add Tasks</h4>
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
                        <form method="POST" accept-charset="UTF-8"
                        class="storeUser" id="submit-form" autocomplete="off" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title</label><span class="help-block">*</span>
                                        <input type="text" placeholder="Enter Title"
                                        class="form-control
                                        {{ $errors->has('title') ? 'has-error' : '' }}"
                                        id="title" name="title" value="{{ old('title') }}"
                                        maxlength="50" required>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                {{ $errors->first('title') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Priority</label><span class="help-block">*</span>
                                        <select class="form-control
                                        {{ $errors->has('priority') ? 'has-error' : '' }}"
                                        id="priority" name="priority" required>
                                            <option value="">Select Priority</option>
                                            <option value="{{ $priority['low'] }}"
                                            {{ old('priority') == $priority['low'] ? 'selected': '' }}>
                                            Low</option>
                                            <option value="{{ $priority['medium'] }}"
                                            {{ old('priority') == $priority['medium'] ? 'selected': '' }}>
                                            Medium</option>
                                            <option value="{{ $priority['high'] }}"
                                            {{ old('priority') == $priority['high'] ? 'selected': '' }}>
                                            High</option>
                                        </select>
                                        @if ($errors->has('priority'))
                                            <span class="help-block">
                                                {{ $errors->first('priority') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label><span class="help-block">*</span>
                                        <input type="text" placeholder="Enter Start Date"
                                        class="form-control
                                        {{ $errors->has('start_date') ? 'has-error' : '' }}"
                                        id="start_date" name="start_date" value="{{ old('start_date') }}"
                                        required>
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">
                                                {{ $errors->first('start_date') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Attachments</label>
                                        <input type="file" id="file" data-default-file=""
                                        name="file" class="dropify"
                                        data-height="100" data-show-remove="false"
                                        data-allowed-file-extensions="png jpeg jpg pdf"
                                        data-max-file-size="3M"
                                        accept=".jpg,.png,.jpeg,.pdf">
                                        @if ($errors->has('file'))
                                            <span class="help-block">
                                                {{ $errors->first('file') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Project</label><span class="help-block">*</span>
                                        <select class="form-control
                                        {{ $errors->has('project') ? 'has-error' : '' }}"
                                        id="project" name="project" required>
                                            <option value="">Select Project</option>
                                            @if(count($project) > 0)
                                                @foreach($project as $row)
                                                    <option value="{{ $row->id }}" {{ (old('project')== $row->id) ? 'selected':''}}>{{ $row->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No Project Found</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('project'))
                                            <span class="help-block">
                                                {{ $errors->first('project') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label><span class="help-block">*</span>
                                        <select class="form-control
                                        {{ $errors->has('status') ? 'has-error' : '' }}"
                                        id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="{{ $status['todo'] }}"
                                            {{ old('status') == $status['todo'] ? 'selected': '' }}>
                                            To Do</option>
                                            <option value="{{ $status['inprogress'] }}"
                                            {{ old('status') == $status['inprogress'] ? 'selected': '' }}>
                                            In Progress</option>
                                            <option value="{{ $status['done'] }}"
                                            {{ old('status') == $status['done'] ? 'selected': '' }}>
                                            Done</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Deadline</label><span class="help-block">*</span>
                                        <input type="text" placeholder="Enter Deadline"
                                        class="form-control
                                        {{ $errors->has('deadline') ? 'has-error' : '' }}"
                                        id="end_date" name="deadline" value="{{ old('deadline') }}"
                                        required>
                                        @if ($errors->has('deadline'))
                                            <span class="help-block">
                                                {{ $errors->first('deadline') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control {{ $errors->has('description') ? 'has-error' : '' }}" placeholder="Enter Description"
                                        name="description" maxlength="500" rows="4" required>{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                {{ $errors->first('description') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="submit-btn" type="submit">
                                <span id="licon"></span>Save
                            </button>
                            <a class="btn btn-secondary" href="{{ route('tasks.index') }}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script src="{{ url('js/main.js') }}"></script>
@endsection

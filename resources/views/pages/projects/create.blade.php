@extends('layouts.app')
@section('title', 'Add Projects |')
@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Add Projects</h4>
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
                        <form method="POST" accept-charset="UTF-8"
                        class="storeUser" id="submit-form" autocomplete="off" action="{{ route('projects.store') }}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label><span class="help-block">*</span>
                                        <input type="text" placeholder="Enter Name"
                                        class="form-control
                                        {{ $errors->has('name') ? 'has-error' : '' }}"
                                        id="name" name="name" value="{{ old('name') }}"
                                        maxlength="50" required>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label><span class="help-block">*</span>
                                        <select class="form-control
                                        {{ $errors->has('status') ? 'has-error' : '' }}"
                                        id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="{{ $status['Active'] }}"
                                            {{ old('status') == $status['Active'] ? 'selected': '' }}>
                                            Active</option>
                                            <option value="{{ $status['Inactive'] }}"
                                            {{ old('status') == $status['Inactive'] ? 'selected': '' }}>
                                            Inactive</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label><span class="help-block">*</span>
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
                            <a class="btn btn-secondary" href="{{ route('projects.index') }}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

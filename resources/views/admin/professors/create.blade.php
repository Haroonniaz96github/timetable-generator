@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Professor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('professors.index')}}">Professors List</a></li>
                        <li class="breadcrumb-item active">Create Professor</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('admin.partials._msg')

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Professor</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['route' => 'professors.store', 'class' => 'form-horizontal']) }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    placeholder="Enter name">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email"
                                    class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                    placeholder="Enter Code">
                                @error('email')
                                    <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code">Courses</label>
                                <select class="form-control">
                                    <option selected>Select Courses</option>
                                    <option>CSM 302 Computer Graphics</option>
                                    <option>CSM 303 Data Structures and Algorithms I</option>
                                    <option>CSM 305 System Analysis</option>
                                </select>
                                @error('code')
                                    <span id="code-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code">Unavailable Periods</label>
                                <select class="form-control">
                                    <option selected>Select Professor</option>
                                    <option>Monday 10:30 - 12:30</option>
                                    <option>Monday 12:30 - 01:30</option>
                                    <option>Monday 01:30 - 02:15</option>
                                </select>
                                @error('code')
                                    <span id="code-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
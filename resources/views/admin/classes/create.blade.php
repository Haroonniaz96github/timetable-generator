@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Classes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('professors.index')}}">Classes List</a></li>
                        <li class="breadcrumb-item active">Classes</li>
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
                            <h3 class="card-title">Classes</h3>
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
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Courses</label>
                                        <select class="form-control">
                                            <option selected>Select Course</option>
                                            <option>CSM 302 Computer Graphics</option>
                                            <option>CSM 303 Data Structures and Algorithms I</option>
                                            <option>CSM 305 System Analysis</option>
                                        </select>
                                        @error('code')
                                            <span id="code-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Academic Periods</label>
                                        <select class="form-control">
                                            <option selected>Select Academic Period</option>
                                            <option>Semester 1</option>
                                            <option>Semester 2</option>
                                            <option>Semester 3</option>
                                        </select>
                                        @error('code')
                                            <span id="code-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Meetings per Week</label>
                                        <input type="number" class="form-control" />
                                        @error('code')
                                            <span id="code-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code">Unavailable Lecture Rooms</label>
                                <select class="form-control">
                                    <option selected>Select Rooms</option>
                                    <option>SF 19</option>
                                    <option>SF 20</option>
                                    <option>FF 1</option>
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
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
                                <label for="courses-select">Select Courses</label>
                                <select id="courses-select" name="course_ids[]" class="form-control select2" multiple>
                                    <option value="">Select courses</option>
                                    @foreach ($courses as $course)
                                     <option value="{{ $course->id }}">{{ $course->course_code }} {{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_ids')
                                    <span id="course_ids-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="unavailable_periods">Select unavailable periods for this lecturer</label>
                                <select class="form-control select2" name="unavailable_periods[]">
                                    {{-- <option value="">Select unavailable periods for this lecturer</option> --}}
                                    @foreach ($days as $day)
                                        @foreach ($timeslots as $timeslot)
                                            <option value="{{ $day->id  }},{{ $timeslot->id }}">
                                                {{ $day->name . " " . $timeslot->time }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('unavailable_periods')
                                    <span id="unavailable_periods-error" class="error invalid-feedback">{{ $message }}</span>
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
@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Professor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('professors.index')}}">Professors List</a></li>
                        <li class="breadcrumb-item active">Edit Professor</li>
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
                            <h3 class="card-title">Edit Professor</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::model($professor, ['method' => 'PATCH','route' => ['professors.update', $professor->id],'class'=>'form-horizontal'])}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{$professor->name}}"
                                    placeholder="Enter name" @if ($errors->has('name')) aria-describedby="name-error" aria-invalid="true"  @endif>
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{$professor->email}}"
                                    class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                    placeholder="Enter email" min="0">
                                @error('email')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="courses-select">Select Courses</label>
                                <select id="courses-select" name="course_ids[]" class="form-control select2" multiple>
                                    <option value="">Select courses</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" 
                                            @if(in_array($course->id, $professor->course_ids ?? []))
                                                selected
                                            @endif
                                        >
                                            {{ $course->course_code }} {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_ids')
                                    <span id="course_ids-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="unavailable_periods">Select unavailable periods for this lecturer</label>
                                <select class="form-control select2" name="unavailable_periods[]" multiple>
                                    @foreach ($days as $day)
                                        @foreach ($timeslots as $timeslot)
                                            <option value="{{ $day->id }},{{ $timeslot->id }}"
                                                @if(in_array(implode(",", [$day->id, $timeslot->id]), $professor->periods ?? []))
                                                    selected
                                                @endif
                                            >
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
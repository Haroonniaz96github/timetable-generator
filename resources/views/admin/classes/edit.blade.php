@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Course</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('courses.index')}}">Courses List</a></li>
                        <li class="breadcrumb-item active">Edit Course</li>
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
                            <h3 class="card-title">Edit Course</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::model($course, ['method' => 'PATCH','route' => ['courses.update', $course->id],'class'=>'form-horizontal'])}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{$course->name}}"
                                    placeholder="Enter name" @if ($errors->has('name')) aria-describedby="name-error" aria-invalid="true"  @endif>
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="course">Code</label>
                                <input type="text" name="code" value="{{$course->course_code}}"
                                    class="form-control  {{ $errors->has('code') ? 'is-invalid' : '' }}" id="course"
                                    placeholder="Enter code" min="0">
                                @error('code')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code">Select Professor</label>
                                <select class="form-control select2" name="professor_ids[]" multiple="multiple" data-placeholder="Select options" style="width: 100%;">
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}" 
                                            @if(in_array($professor->id, $course->professor_ids   ?? []))
                                                selected
                                            @endif
                                        >{{ $professor->name }}</option>
                                    @endforeach
                                </select>
                                @error('professor_ids')
                                    <span id="professor_ids-error" class="error invalid-feedback">{{ $message }}</span>
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
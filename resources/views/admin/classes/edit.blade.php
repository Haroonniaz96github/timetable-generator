@extends('admin.layouts.master')
<style>
    .side-icon {
        margin-top: 10px;
        cursor: pointer;
    }
</style>
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
                        {{ Form::model($class, ['method' => 'PATCH','route' => ['classes.update', $class->id],'class'=>'form-horizontal'])}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    placeholder="Enter name" value="{{$class->name}}">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                              <label>Courses <i class="fa fa-plus side-icon" title="Add Course" id="course-add"></i></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Courses</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Academic Periods</label>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="code">Meetings per Week</label>
                                    </div>
                                </div>
                            </div>
                            <div id="courses-container">
                                @foreach($class->courses as $class_course)
                                {{-- @dd($class_course->academic_period_id) --}}
                                    <div class="row course-form appended-course" style="margin-bottom: 5px" data-row-index="{{ $class_course->id }}">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <select class="form-control course-select" name="courses[]">
                                                <option value="" selected>Select a course</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}" {{ $course->id == $class_course->id ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="select2-wrapper">
                                                <select class="form-control period-select" name="periods[]">
                                                    <option value="" selected>Select an academic period</option>
                                                    @foreach ($academicPeriods as $period)
                                                        <option value="{{ $period->id }}" {{ $period->id == $class_course->pivot->academic_period_id ? 'selected' : '' }}>
                                                            {{ $period->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                
                                        <div class="col-md-3 col-sm-4 col-xs-10">
                                            <input type="number" class="form-control course-meetings" name="meetings[]" value="{{ $class_course->pivot->meetings }}">
                                        </div>
                                
                                        <div class="col-md-1 col-sm-1 col-xs-2">
                                            <span class="fa fa-trash course-remove" title="Remove Course" data-row-index="{{ $class_course->id }}"></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>Population</label>
                                <input type="number" name="size" value="{{$class->size}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="code">Unavailable Lecture Rooms</label>
                                <select name="room_ids[]" class="form-control select2" multiple>
                                    <option selected disabled>Select Rooms</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" {{ $class->unavailable_rooms->contains('id', $room->id) ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
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

    <div id="course-template" class="" style="display: none">
        <div class="row course-form appended-course" style="margin-bottom: 5px">
           <div class="col-md-4 col-sm-6 col-xs-12">
               {{-- <div class="select2-wrapper"> --}}
                   <select class="form-control course-select" name="courses[]">
                       <option value="" selected>Select a course</option>
                       @foreach ($courses as $course)
                       <option value="{{ $course->id }}">{{ $course->name }}</option>
                       @endforeach
                   </select>
               {{-- </div> --}}
           </div>
   
           <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="select2-wrapper">
                   <select class="form-control period-select" name="periods[]">
                       <option value="" selected>Select an academic period</option>
                       @foreach ($academicPeriods as $period)
                       <option value="{{ $period->id }}">{{ $period->name }}</option>
                       @endforeach
                   </select>
               </div>
           </div>
   
           <div class="col-md-3 col-sm-4 col-xs-10">
               <input type="number" class="form-control course-meetings" name="meetings[]">
           </div>
   
           <div class="col-md-1 col-sm-1 col-xs-2">
                <span class="fa fa-trash course-remove" title="Remove Course"></span>
           </div>
       </div>
   </div>
@endsection
@section('scripts')
<script>
    $(document).on('click', '#course-add', function() {
        addCourse();
    });

    $(document).on('click', '.course-remove', function() {
            var rowIndex = $(this).data('row-index');
            removeCourse(rowIndex);
        });

    function removeCourse(rowIndex) {
        // Remove the course-form with the specified data-row-index
        $('.appended-course[data-row-index="' + rowIndex + '"]').remove();
    }

    function addCourse() {
        // Clone the last course-form and append it to the courses-container
        var lastCourse = $('.appended-course:last');
        var newCourse = lastCourse.clone();
        newCourse.find('select, input').val('');
        $('#courses-container').append(newCourse);
    }
</script>
@endsection

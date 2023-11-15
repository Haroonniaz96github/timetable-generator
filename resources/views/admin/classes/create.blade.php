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
                        {{ Form::open(['route' => 'classes.store', 'class' => 'form-horizontal']) }}
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

                            </div>
                            <div class="form-group">
                                <label>Population</label>
                                <input type="text" name="size" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="code">Unavailable Lecture Rooms</label>
                                <select name="room_ids[]" class="form-control select2" multiple>
                                    <option selected disabled>Select Rooms</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
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
        <div class="row course-form appended-course" id="course-{ID}-container" style="margin-bottom: 5px">
           <div class="col-md-4 col-sm-6 col-xs-12">
               {{-- <div class="select2-wrapper"> --}}
                   <select class="form-control course-select" name="course-{ID}">
                       <option value="" selected>Select a course</option>
                       @foreach ($courses as $course)
                       <option value="{{ $course->id }}">{{ $course->name }}</option>
                       @endforeach
                   </select>
               {{-- </div> --}}
           </div>
   
           <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="select2-wrapper">
                   <select class="form-control period-select" name="period-{ID}">
                       <option value="" selected>Select an academic period</option>
                       @foreach ($academicPeriods as $period)
                       <option value="{{ $period->id }}">{{ $period->name }}</option>
                       @endforeach
                   </select>
               </div>
           </div>
   
           <div class="col-md-3 col-sm-4 col-xs-10">
               <input type="number" class="form-control course-meetings" name="course-{ID}-meetings">
           </div>
   
           <div class="col-md-1 col-sm-1 col-xs-2">
               <span class="fa fa-close side-icon course-remove" title="Remove Course" data-id="{ID}"></span>
           </div>
       </div>
   </div>
@endsection
@section('scripts')
<script>
    $(document).on('click', '#course-add', function() {
        addCourse();
    });

    $(document).on('click', '.course-remove', function(event){
        var $el = $(event.target);
        var id = $el.data('id');

        $('#course-' + id + '-container').remove();
    });


    function addCourse(data){
        var template = $('#course-template').html();
        var id = new Date().valueOf();
        data = data || null;

        template = template.replace(/{ID}/g, id);

        if (data) {
            $('#courses-container').prepend(template);
            $('[name=course-' + id + ']').val(data.course_id).change();
            $('[name=course-' + id + '-meetings]').val(data.meetings);
            $('[name=period-' + id + ']').val(data.academic_period_id).change();
        } else {
            $('#courses-container').append(template);
        }

        // $('[name=course-' + id +']').select2();
        // $('[name=period-' + id + ']').select2();
    };
</script>
@endsection

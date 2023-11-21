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
                    <h1>Generate Timetable</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('professors.index')}}">Timetable List</a></li>
                        <li class="breadcrumb-item active">Timetable</li>
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
                            <h3 class="card-title">Timetable</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['route' => 'timetables.store', 'class' => 'form-horizontal']) }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Time</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    placeholder="Enter name">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Academic Period</label>
                                <div class="select2-wrapper">
                                    <select class="form-control select2" name="academic_period_id">
                                        <option value="" selected>Select an academic period</option>
                                        @foreach ($academicPeriods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Select Days</label>

                                @foreach ($days as $day)
                                <div class="form-group">
                                    <input name="day_{{ $day->id }}" type="checkbox" for="day_{{ $day->id }}" @if($day->id <= 5) checked @endif>
                                    <label id="day_{{ $day->id }}">{{ $day->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="submit-btn btn btn-primary btn-block">Generate</button>
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
@section('scripts')
<script>

</script>
@endsection

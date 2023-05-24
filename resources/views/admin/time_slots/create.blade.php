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
                        {{ Form::open(['route' => 'time-slots.store', 'class' => 'form-horizontal']) }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="from">From</label>
                                <select id="from-select" name="from" class="form-control select2">
                                    @for($i = 0; $i <= 23; $i++)
                                       @foreach(['00', '30'] as $subPart)
                                        <option value="{{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}">
                                            {{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}
                                        </option>
                                        @endforeach
                                    @endfor
                                </select>
                                @error('from')
                                    <span id="from-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="to">To</label>
                                <select id="to-select" name="to" class="form-control select2">
                                    @for($i = 0; $i <= 23; $i++)
                                        @foreach(['00', '30'] as $subPart)
                                        <option value="{{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}">
                                            {{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}
                                        </option>
                                        @endforeach
                                    @endfor
                                </select>
                                @error('to')
                                    <span id="to-error" class="error invalid-feedback">{{ $message }}</span>
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
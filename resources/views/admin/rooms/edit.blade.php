@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('rooms.index')}}">Rooms List</a></li>
                        <li class="breadcrumb-item active">Edit Room</li>
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
                            <h3 class="card-title">Edit Room</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::model($room, ['method' => 'PATCH','route' => ['rooms.update', $room->id],'class'=>'form-horizontal'])}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{$room->name}}"
                                    placeholder="Enter name" @if ($errors->has('name')) aria-describedby="name-error" aria-invalid="true"  @endif>
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input type="number" name="capacity" value="{{$room->capacity}}"
                                    class="form-control  {{ $errors->has('capacity') ? 'is-invalid' : '' }}" id="capacity"
                                    placeholder="Enter Capacity" min="0">
                                @error('capacity')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
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
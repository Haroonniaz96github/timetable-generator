@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Courses List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Courses List</li>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group float-right">
                                {{-- @can('user-create') --}}
                                    <a href="{{ route('courses.create') }}" class="btn btn-primary">
                                        <i class="fa fw fa-plus"></i>
                                        Add Course
                                    </a>
                                {{-- @endcan --}}
                                @can('user-delete')
                                <a class="btn btn-danger" onclick="del_selected()" href="javascript:void(0)">
                                    <i class="fa fa-trash"></i> Delete All
                                </a>
                                @endcan
                            </div>
                            <h4 class="float-left">Courses List</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ url('admin/delete-selected-courses') }}" method="post" id="delete-form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table id="datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="checkbox checkbox-success m-0">
                                                        <input type="checkbox">
                                                        <label for="checkbox3"></label>
                                                    </div>
                                                <th>NAME</th>
                                                <th style="width: 30%">Course Code</th>
                                                <th style="width: 30%">Taught By</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-success m-0">
                                                            <input id="checkbox{{ $course->id }}" type="checkbox"
                                                                name="courses[]" value="{{ $course->id }}">
                                                            <label for="checkbox{{ $course->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $course->name }}</td>
                                                    <td>{{ $course->course_code }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($course->professors as $professor)
                                                            <li>{{ $professor->name }}</li>
                                                            @endforeach
                                                            </ul>
                                                    </td>
                                                    <td>{{ $course->created_at }}</td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm"
                                                            onclick="event.preventDefault();viewInfo(
                                                                {{ $course->id }});"
                                                            title="View Course" href="javascript:void(0)">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a title="Edit Course" class="btn btn-sm btn-primary" href="{{route('courses.edit', $course->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault();del({{ $course->id }});"
                                                            title="Delete Course" href="javascript:void(0)">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <!-- /.modal -->
                            <div id="model" class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Course Detail</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        function del(id) {
            swal.fire({

                    title: "Are you sure!",
                    text: "This course will be deleted permanently",
                    type: "warning",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    showCancelButton: true,
                })
                .then((result) => {
                    if (result.value) {
                        var APP_URL = {!! json_encode(url('/')) !!}
                        window.location.href = APP_URL + "/admin/courses/delete/" + id;
                    }
                });
        }

        function del_selected() {
            swal.fire({
                    title: "Are you sure?",
                    text: "These course/courses will be deleted permanently",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                })
                .then((result) => {
                    if (result.value) {
                        $("#delete-form").submit();
                        setTimeout(function() {
                            swal("Courses deleted sucessfully. Thanks");
                        }, 2000);
                    }
                });
        }
    </script>

    <script>
        $(document).on('click', 'th input:checkbox', function() {
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function() {
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });

        function viewInfo(id) {
            // $.LoadingOverlay("show");
            var CSRF_TOKEN = '{{ csrf_token() }}';
            $.post("{{ route('admin.getCourse') }}", {
                _token: CSRF_TOKEN,
                id: id
            }).done(function(response) {
                // Add response in Modal body
                $('.modal-body').html(response);
                // Display Modal
                $('#model').modal('show');
                // $.LoadingOverlay("hide");
            });
        }

        jQuery(function($) {
            //initiate dataTables plugin
            var myTable =
                $('#datatable').DataTable();
        });
    </script>
@endsection


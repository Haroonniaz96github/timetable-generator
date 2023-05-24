<div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{$course->name ?? ''}}</td>
        </tr>
        <tr>
            <th>Code</th>
            <td>{{$course->code ?? ''}}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{$course->created_at ?? ''}}</td>
        </tr>
        </tbody>
    </table>
</div>

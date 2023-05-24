<div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{$room->name ?? ''}}</td>
        </tr>
        <tr>
            <th>Capacity</th>
            <td>{{$room->capacity ?? ''}}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{$room->created_at ?? ''}}</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{$professor->name ?? ''}}</td>
        </tr>
        <tr>
            <th>Professor</th>
            <td>{{$professor->email ?? ''}}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{$professor->created_at ?? ''}}</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{$time->time ?? ''}}</td>
        </tr>
        <tr>
            <th>Created at</th>
            <td>{{$time->created_at ?? ''}}</td>
        </tr>
        </tbody>
    </table>
</div>

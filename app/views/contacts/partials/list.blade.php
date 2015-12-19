<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Extra data</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->surname }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->custom1 }}</td>
            <td>
                <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span
                            class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td>
                <p data-placement="top" data-toggle="tooltip" title="" data-original-title="Delete">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                        <span class="glyphicon glyphicon-trash"></span></button>
                </p>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



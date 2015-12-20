<table id="contacts-table" class="table table-stripped table-hover">
    <thead>
    <tr>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Custom info</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
        <tr id="tr-{{ $contact->id }}">
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->surname }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>
                <button class="btn btn-primary btn-xs custom-data" title="Contact custom info."
                        data-contact-id="{{ $contact->id }}"><span
                            class="glyphicon glyphicon-info-sign"></span></button>
            </td>
            <td>
                <button class="btn btn-primary btn-xs edit-contact" title="Edit contact."
                        data-contact-id="{{ $contact->id }}"><span
                            class="glyphicon glyphicon-pencil"></span></button>
            </td>
            <td>
                <button class="btn btn-danger btn-xs delete-contact" title="Delete contact."
                        data-contact-id="{{ $contact->id }}"
                        data-contact-name="{{ $contact->name }}">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



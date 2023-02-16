<!DOCTYPE html>
<html>

<head>
    <div>
        <title>Laravel Yajra Datatables</title>   
        <a href="{{ route('users.export') }}"><button type="submit">Export</button></a>
        {{-- <a href="{{ route('users.import') }}"><button type="submit">Import</button></a>
        <input type="file" name="import"> --}}
    </div>

    <form method="POST" action="{{ route('users.import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".csv">
        <button type="submit">Import</button>
    </form>
    

 
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>

    <div class="container">
        <h1>Laravel Yajra Datatables</h1>
        <table class="table table-bordered data-table" id="users-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</body>

<script type="text/javascript">
    $(function() {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'image',
                    name: 'image',
                    render: function(data, type, full, meta) {
                        return '<img src="' + data + '" width="50" />';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });

    function deleteUser(id) {
        // alert(id);
        var currentPosition = $(document).scrollTop();
        $.ajax({
            type: "GET",
            url: '/yazraDataTable/users/' + id,
            success: function(response) {
                console.log(response);
                console.log(response.message);
                var table = $('#users-table').DataTable();
                // table.row($("#user-" + id)).remove({
                //     draw: false
                // }).draw();
                // $(document).scrollTop(currentPosition);
                $('#users-table').dataTable().fnDraw(false);

            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }
</script>

</html>

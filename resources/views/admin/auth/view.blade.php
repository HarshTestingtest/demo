<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-2">
        <div class="row">

            <div class="col-lg-2">
                <a class="btn btn-sm btn-danger" href="{{ route('adminDashboard') }}">Back</a>
            </div>
            <div class="col-lg-2">
                <span data-href="export-csv" id="export" class="btn btn-success btn-sm" onclick="exportTasks (event.target);">Export</span>
            </div>
            <div class="col-lg-4">
                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn btn-success" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No.</th>
                    <th>Status</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($users as $user)
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $user->username }}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->mobile_no}}</td>

                    <td>
                        @if($user->status == 'active')
                        <a href="{{route('status-update',$user->id)}}" class="btn btn-sm btn-success">Active</a>
                        @else
                        <a href="{{route('status-update',$user->id)}}" class="btn btn-sm btn-danger">Inactive</a>
                        @endif
                    </td>

                    <td>
                        <a class="btn btn-sm btn-primary" href="#">Edit</a>
                        <a class="btn btn-sm btn-danger" href="#">Delete</a>
                    </td>
                </tr>
                <?php $i++; ?>
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    $(function() {
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var user_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatus',
                data: {
                    'status': status,
                    'user_id': user_id
                },
                success: function(data) {
                    console.log(data.success)
                }
            });
        })
    });

    function exportTasks(_this) {
        let text = "Are you sure export all data.";
        if (confirm(text) == true) {
            text = "Yes";
            let _url = $(_this).data('href');
            window.location.href = _url;
        }

    }
</script>
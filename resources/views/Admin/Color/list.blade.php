@extends('Admin.Layout.main')
@push('css')
    <style>
        #categoryTable_wrapper{
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
@endpush
@section('main')

@include('Admin.Layout.sidebar')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Color/</span> List</h4>
    <table class="table" id="categoryTable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Color Name</th>
                <th>Color Code</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

</div>
</div>
</div>

@endsection

@push('script')
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session("success") }}',
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '{!! implode("<br>", $errors->all()) !!}',
            });
        @endif

        $(function () {
            $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.color.data') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'code', name: 'code', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });

        $(document).on('click', '.delete-color', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ url('admin/color/delete') }}/" + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    </script>
@endpush

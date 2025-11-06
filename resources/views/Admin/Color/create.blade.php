@extends('Admin.Layout.main')
@push('css')
    <style>
        .select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__clear,.select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 35px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 34px
        }
    </style>
@endpush
@section('main')

@include('Admin.Layout.sidebar')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Color/</span> Create</h4>

    <div class="row">
        <div class="col-xl">
            <div class="card p-4">
                <form method="post" action="{{ route('admin.color.store') }}" id="categoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Color Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Color Name" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="code">Parent Color</label>
                        <input type="text" name="code" class="form-control" id="code" placeholder="Color Code" />
                    </div>

                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
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

    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let name = document.getElementById('name').value.trim();

        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Color Name',
                text: 'Please enter a category name.',
            });
            return false;
        }

        let code = document.getElementById('code').value.trim();

        if (!code) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Color Name',
                text: 'Please enter a color code.',
            });
            return false;
        }

        this.submit();
    });
</script>
@endpush

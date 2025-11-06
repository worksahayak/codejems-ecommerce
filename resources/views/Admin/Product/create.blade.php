@extends('Admin.Layout.main')
@push('css')
    <style>
        .select2-container .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__clear,.select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 35px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 34px
        }
        .select2-container .select2-selection--multiple{
            min-height: 40px;
        }
        .select2-container .select2-search--inline .select2-search__field{
            height: 33px;
            padding: 4px 10px;
        }
        .select2-container--default .select2-selection--multiple{
            padding-bottom: 0
        }
    </style>
@endpush
@section('main')

@include('Admin.Layout.sidebar')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product/</span> Create</h4>

    <div class="row">
        <div class="col-xl">
            <div class="card p-4">
                <form method="post" action="{{ route('admin.products.store') }}" id="categoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Product Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Product Name" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Product Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter Description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="gender">Gender: </label>
                        <div class="d-flex align-items-center">
                            <label for="male">
                                <input type="radio" name="gender" id="male" value="male"> Male
                            </label>
                            <label for="female" class="ms-3">
                                <input type="radio" name="gender" id="female" value="female"> Female
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="categories_id">Category</label>
                        <select name="categories_id" id="categories_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="colors">Color</label>
                        <select name="colors[]" id="colors" class="form-control" multiple>
                            <option value="">Select Colors</option>
                            @foreach ($colors as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
</script>

<script>
$(document).ready(function () {

    $('#categoryForm').on('submit', function (e) {
        e.preventDefault();

        let name = $.trim($('#name').val());
        let description = $.trim($('#description').val());
        let gender = $('input[name="gender"]:checked').val();
        let category = $('#categories_id').val();
        let colors = $('#colors').val();

        if (name === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Product Name',
                text: 'Please enter the product name before submitting.'
            });
            return;
        }

        if (description === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Description',
                text: 'Please write a short description of the product.'
            });
            return;
        }

        if (!gender) {
            Swal.fire({
                icon: 'warning',
                title: 'Select Gender',
                text: 'Please select the gender for this product.'
            });
            return;
        }

        if (category === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Select Category',
                text: 'Please choose a product category.'
            });
            return;
        }

        if (colors === null || colors.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Select Color(s)',
                text: 'Please select at least one color.'
            });
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Confirm Submission',
            text: 'Are you sure you want to submit this product?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                e.currentTarget.submit();
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#colors').select2({
            placeholder: "Select Colors",
            allowClear: true,
            width: '100%'
        });
    });
</script>

@endpush

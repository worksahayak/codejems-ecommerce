@extends('Admin.Layout.main')
@push('css')
    <style>
        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--single .select2-selection__clear,
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px
        }

        .select2-container .select2-selection--multiple {
            min-height: 40px;
        }

        .select2-container .select2-search--inline .select2-search__field {
            height: 33px;
            padding: 4px 10px;
        }

        .select2-container--default .select2-selection--multiple {
            padding-bottom: 0
        }

        .step-section {
            display: none;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .step-section.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            color: #666;
        }

        .step.active {
            background-color: #007bff;
            color: white;
        }

        .step.completed {
            background-color: #28a745;
            color: white;
        }

        .step-line {
            flex: 1;
            height: 4px;
            background-color: #e0e0e0;
            margin-top: 18px;
        }

        .step-line.completed {
            background-color: #28a745;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-item .remove-image {
            position: absolute;
            top: 2px;
            right: 2px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }

        .hidden {
            display: none;
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
                    <div class="step-indicator" id="stepIndicator">
                    </div>

                    <form method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}"
                        id="productForm" enctype="multipart/form-data">
                        @csrf

                        <div class="step-section active" id="step-1">
                            <h5 class="mb-4">Step 1: Basic Information</h5>

                            <div class="mb-3">
                                <label class="form-label" for="name">Product Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Product Name" value="{{ old('name', $product->name ?? '') }}" required />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Product Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter Description"
                                    required>{{ old('description', $product->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="gender">Gender:</label>
                                <div class="d-flex align-items-center">
                                    <label for="male" class="me-3">
                                        <input type="radio" name="gender" id="male" value="male"
                                            {{ old('gender', $product->gender ?? '') == 'male' ? 'checked' : '' }} required>
                                        Male
                                    </label>
                                    <label for="female">
                                        <input type="radio" name="gender" id="female" value="female"
                                            {{ old('gender', $product->gender ?? '') == 'female' ? 'checked' : '' }}> Female
                                    </label>
                                </div>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="categories_id">Category</label>
                                <select name="categories_id" id="categories_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('categories_id', $product->categories_id ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categories_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="step-section" id="step-2">
                            <h5 class="mb-4">Step 2: Color Selection</h5>

                            <div class="mb-3">
                                <label class="form-label">Colors</label>
                                <select name="colors[]" id="colors" class="form-control" multiple required>
                                    @foreach ($colors as $item)
                                        <option value="{{ $item->id }}"
                                            {{ in_array($item->id, old('colors', json_decode($product->colors ?? '[]', true) ?? [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('colors')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="step-section" id="step-3">
                            <h5 class="mb-4">Step 3: Color Details</h5>
                            <div id="colorDetailsContainer">
                            </div>
                        </div>

                        <div class="navigation-buttons mt-4">
                            <button type="button" class="btn btn-secondary" id="prevBtn"
                                style="display:none;">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                        </div>
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
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '{!! implode('<br>', $errors->all()) !!}',
            });
        @endif
    </script>

    <script>
        const productColorDetails = @json($product->colorDetails);

        $(document).ready(function() {
            $('#colors').select2({
                placeholder: "Select Colors",
                allowClear: true,
                width: '100%'
            });

            let currentStep = 1;
            const totalSteps = 3;
            let colorDetails = {};

            function showStep(step) {
                $('.step-section').removeClass('active');
                $('#step-' + step).addClass('active');

                $('#prevBtn').toggle(step > 1);

                $('#nextBtn').attr('type', 'button');

                if (step === totalSteps) {
                    $('#nextBtn').text('Submit');
                } else {
                    $('#nextBtn').text('Next');
                }
            }

            function generateColorDetails() {
                const selectedColors = $('#colors').val() || [];
                const container = $('#colorDetailsContainer');
                container.empty();

                selectedColors.forEach(colorId => {
                    const colorName = $('#colors option[value="' + colorId + '"]').text();
                    const existingDetail = productColorDetails.find(cd => cd.color_id == colorId);
                    const existingPrice = existingDetail ? existingDetail.price : '';
                    const existingImages = existingDetail && existingDetail.images ? JSON.parse(
                        existingDetail.images) : [];

                    const html = `
                <div class="card mb-4" data-color-id="${colorId}">
                    <div class="card-header"><h6 class="mb-0">${colorName}</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Price for ${colorName}</label>
                            <input type="number" name="prices[${colorId}]" class="form-control color-price"
                                placeholder="Enter price" min="0" step="0.01" value="${existingPrice}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Images for ${colorName}</label>
                            <input type="file" name="images[${colorId}][]" class="form-control color-images" multiple accept="image/*">
                            <div class="image-preview mt-2" id="preview-${colorId}"></div>
                        </div>
                    </div>
                </div>`;

                    container.append(html);

                    const previewContainer = $('#preview-' + colorId);
                    existingImages.forEach(img => {
                        const imagePath = `${window.location.origin}/${img}`;
                        previewContainer.append(`
                    <div class="image-preview-item">
                        <img src="${imagePath}" width="100">
                    </div>`);
                    });
                });
            }

            function validateStep(step) {
                let valid = true;
                if (step === 1) {
                    if (!$('#name').val()) valid = false;
                    if (!$('#description').val()) valid = false;
                    if (!$('input[name="gender"]:checked').val()) valid = false;
                    if (!$('#categories_id').val()) valid = false;
                }
                if (step === 2) {
                    const colors = $('#colors').val();
                    if (!colors || colors.length === 0) valid = false;
                }
                if (step === 3) {
                    $('.color-price').each(function() {
                        if (!$(this).val()) valid = false;
                    });
                }
                return valid;
            }

            $('#nextBtn').on('click', function() {
                if (!validateStep(currentStep)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields correctly.',
                    });
                    return;
                }

                if (currentStep === 2) {
                    generateColorDetails();
                }

                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    $('#productForm').submit();
                }
            });

            $('#prevBtn').on('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);
        });
    </script>
@endpush

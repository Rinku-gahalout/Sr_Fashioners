@extends('wl-admin.layouts.app')

@push('styles')

<style>

.category-card{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

.card-title{
    font-size:20px;
    font-weight:700;
    color:#1e0536;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

.form-label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#374151;
}

.form-control{
    width:100%;
    height:48px;
    border:1.5px solid #e2e8f0;
    border-radius:12px;
    padding:0 15px;
    font-size:14px;
    transition:.3s;
}

.form-control:focus{
    outline:none;
    border-color:#EB7405;
    box-shadow:0 0 0 3px rgba(235,116,5,.12);
}

textarea.form-control{
    height:120px;
    padding-top:12px;
    resize:none;
}

.image-upload{
    border:2px dashed #e2e8f0;
    border-radius:14px;
    padding:25px;
    text-align:center;
    transition:.3s;
}

.image-upload:hover{
    border-color:#EB7405;
}

.image-upload input{
    display:none;
}

.upload-label{
    cursor:pointer;
    display:block;
}

.upload-label i{
    font-size:40px;
    color:#EB7405;
    margin-bottom:10px;
}

.upload-label p{
    margin:0;
    color:#64748b;
}

.preview-image{
    max-width:150px;
    max-height:150px;
    border-radius:12px;
    margin-top:15px;
    display:none;
}

.btn-save{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    border:none;
    color:#fff;
    padding:12px 28px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.btn-save:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 18px rgba(235,116,5,.35);
}

.btn-cancel{
    background:#fff;
    border:1.5px solid #e2e8f0;
    color:#64748b;
    padding:12px 28px;
    border-radius:12px;
    font-weight:600;
    text-decoration:none;
}

.btn-cancel:hover{
    border-color:#EB7405;
    color:#EB7405;
}

.form-actions{
    display:flex;
    gap:12px;
    margin-top:30px;
}

.text-danger{
    color:#dc2626;
    font-size:13px;
    margin-top:5px;
    display:block;
}

.alert-success{
    background:#dcfce7;
    color:#166534;
    padding:12px 16px;
    border-radius:10px;
    margin-bottom:20px;
}

</style>

@endpush

@section('content')

<div class="container-fluid">

<div class="page-top">

    <div class="page-top-left">

        <h2>Add Sub Category</h2>

        <div class="breadcrumb-bar">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="#">Sub Categories</a>
            <span>/</span>
            <span>Add Sub Category</span>
        </div>

    </div>

</div>

<div class="category-card">

    <h4 class="card-title">
        Sub Category Information
    </h4>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('store.subcategory')}}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <!-- Category -->

        <div class="form-group">

            <label class="form-label">
                Category
            </label>

            <select name="category_id" class="form-control" required>

                <option value="">
                    Select Category
                </option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <!-- Name -->

        <div class="form-group">

            <label class="form-label">
                Sub Category Name
            </label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Enter sub category name">

            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <!-- Slug -->

        <div class="form-group">

            <label class="form-label">
                Slug
            </label>

            <input type="text"
                   name="slug"
                   class="form-control"
                   value="{{ old('slug') }}"
                   placeholder="subcategory-slug">

            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <!-- Description -->

        <div class="form-group">

            <label class="form-label">
                Description
            </label>

            <textarea name="description"
                      class="form-control"
                      placeholder="Enter description">{{ old('description') }}</textarea>

        </div>

        <!-- Image -->

        <div class="form-group">

            <label class="form-label">
                Sub Category Image
            </label>

            <div class="image-upload">

                <label class="upload-label">

                    <input type="file"
                           name="image"
                           id="imageInput">

                    <i class="ri-image-add-line"></i>

                    <p>Click to upload image</p>

                    <img id="previewImage"
                         class="preview-image">

                </label>

            </div>

            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <!-- Status -->

        <div class="form-group">

            <label class="form-label">
                Status
            </label>

            <select name="status" class="form-control">

                <option value="1">
                    Active
                </option>

                <option value="0">
                    Inactive
                </option>

            </select>

        </div>

        <!-- Buttons -->

        <div class="form-actions">

            <button type="submit"
                    class="btn-save">
                Save Sub Category
            </button>

            <a href="#"
               class="btn-cancel">
                Cancel
            </a>

        </div>

    </form>

</div>

</div>

@endsection

@push('scripts')

<script>

document.getElementById('imageInput').addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(event){

            const preview =
                document.getElementById('previewImage');

            preview.src = event.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

});

</script>

@endpush

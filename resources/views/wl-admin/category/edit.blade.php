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
    border:1px solid #eee;
}

.btn-update{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    border:none;
    color:#fff;
    padding:12px 28px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.btn-update:hover{
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

.current-image{
    margin-bottom:15px;
}

.current-image img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:12px;
    border:1px solid #e5e7eb;
}

.image-title{
    font-size:14px;
    font-weight:600;
    color:#374151;
    margin-bottom:10px;
}

</style>

@endpush

@section('content')

<div class="container-fluid">

<div class="page-top">
    <div class="page-top-left">

        <h2>Edit Category</h2>

        <div class="breadcrumb-bar">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('list.category') }}">Categories</a>
            <span>/</span>
            <span>Edit Category</span>
        </div>

    </div>
</div>

<div class="category-card">

    <h4 class="card-title">Update Category</h4>

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.updatecategory',$category->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="form-label">Category Name</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name',$category->name) }}"
                   placeholder="Enter category name">

            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Slug</label>

            <input type="text"
                   name="slug"
                   class="form-control"
                   value="{{ old('slug',$category->slug) }}"
                   placeholder="category-slug">

            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>

            <textarea name="description"
                      class="form-control"
                      placeholder="Category description">{{ old('description',$category->description) }}</textarea>

            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">

            <label class="form-label">Category Image</label>

            @if($category->image)

                <div class="current-image">
                    <div class="image-title">
                        Current Image
                    </div>

                    <img src="{{ asset('uploads/categories/'.$category->image) }}"
                         alt="{{ $category->name }}">
                </div>

            @endif

            <div class="image-upload">

                <label class="upload-label">

                    <input type="file"
                           name="image"
                           id="imageInput">

                    <i class="ri-image-add-line"></i>

                    <p>Click to upload new image</p>

                    <img id="previewImage"
                         class="preview-image"
                         style="display:none;">

                </label>

            </div>

            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">

            <label class="form-label">Status</label>

            <select name="status" class="form-control">

                <option value="1"
                    {{ $category->status == 1 ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ $category->status == 0 ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn-update">
                Update Category
            </button>

            <a href="{{ route('list.category') }}"
               class="btn-cancel">
                Back
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

            const preview = document.getElementById('previewImage');

            preview.src = event.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

});

</script>

@endpush

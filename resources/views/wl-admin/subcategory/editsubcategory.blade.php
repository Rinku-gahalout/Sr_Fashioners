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
}

.preview-image{
    max-width:150px;
    max-height:150px;
    border-radius:12px;
    margin-top:15px;
}

.current-image{
    margin-bottom:15px;
}

.current-image img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:12px;
    border:1px solid #eee;
}

.btn-update{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    border:none;
    color:#fff;
    padding:12px 28px;
    border-radius:12px;
    font-weight:600;
}

.btn-cancel{
    background:#fff;
    border:1px solid #e2e8f0;
    color:#64748b;
    padding:12px 28px;
    border-radius:12px;
    text-decoration:none;
}

.form-actions{
    display:flex;
    gap:12px;
    margin-top:30px;
}
</style>
@endpush

@section('content')

<div class="container-fluid">

    <div class="page-top">
        <div class="page-top-left">
            <h2>Edit Sub Category</h2>

            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <a href="{{ route('list.subcategory') }}">Sub Categories</a>
                <span>/</span>
                <span>Edit</span>
            </div>
        </div>
    </div>

    <div class="category-card">

        <h4 class="card-title">
            Update Sub Category
        </h4>

        <form action="{{ route('update.subcategory',$subcategory->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- Category -->

            <div class="form-group">
                <label class="form-label">
                    Category
                </label>

                <select name="category_id" class="form-control">

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>
            </div>

            <!-- Name -->

            <div class="form-group">
                <label class="form-label">
                    Sub Category Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name',$subcategory->name) }}">
            </div>

            <!-- Slug -->

            <div class="form-group">
                <label class="form-label">
                    Slug
                </label>

                <input type="text"
                       name="slug"
                       class="form-control"
                       value="{{ old('slug',$subcategory->slug) }}">
            </div>

            <!-- Description -->

            <div class="form-group">
                <label class="form-label">
                    Description
                </label>

                <textarea name="description"
                          class="form-control">{{ old('description',$subcategory->description) }}</textarea>
            </div>

            <!-- Current Image -->

            @if($subcategory->image)
                <div class="form-group">

                    <label class="form-label">
                        Current Image
                    </label>

                    <div class="current-image">
                        <img src="{{ asset('uploads/subcategories/'.$subcategory->image) }}">
                    </div>

                </div>
            @endif

            <!-- New Image -->

            <div class="form-group">

                <label class="form-label">
                    Change Image
                </label>

                <div class="image-upload">

                    <label class="upload-label">

                        <input type="file"
                               name="image"
                               id="imageInput">

                        <i class="ri-image-add-line"></i>

                        <p>Click to upload image</p>

                        <img id="previewImage"
                             class="preview-image"
                             style="display:none;">

                    </label>

                </div>

            </div>

            <!-- Status -->

            <div class="form-group">

                <label class="form-label">
                    Status
                </label>

                <select name="status" class="form-control">

                    <option value="1"
                        {{ $subcategory->status == 1 ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ $subcategory->status == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn-update">
                    Update Sub Category
                </button>

                <a href="{{ route('list.subcategory') }}"
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
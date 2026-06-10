@extends('wl-admin.layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-top">
        <div class="page-top-left">
            <h2>Create Fitting</h2>

            <div class="breadcrumb-bar">
                <a href="{{ route('fitting.list') }}">Fittings</a>
                <span>/</span>
                <span>Create</span>
            </div>
        </div>

        <a href="{{ route('fitting.list') }}" class="btn-add">
            <i class="mdi mdi-arrow-left"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="form-card">

        <div class="form-card-header">
            <h5>
                <i class="mdi mdi-plus-circle"></i>
                New Fitting Details
            </h5>
        </div>

        <form action="{{ route('store.fitting')}}" method="POST">
            @csrf

            <div class="form-body">

                <!-- Name -->
                <div class="form-group">
                    <label>Fitting Name <span>*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Enter fitting name">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="form-group">
                    <label>Slug <span>*</span></label>
                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}"
                        placeholder="fitting-slug">

                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div class="form-group">
                    <label>Sort Order</label>
                    <input
                        type="number"
                        name="sort_order"
                        class="form-control"
                        value="{{ old('sort_order',0) }}">
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>

                    <select name="status" class="form-control">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn-save">
                    <i class="mdi mdi-content-save"></i>
                    Save Fitting
                </button>

                <a href="{{ route('fitting.list') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

@endsection


@push('styles')
<style>

.form-card{
    background:#fff;
    border-radius:16px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    overflow:hidden;
}

.form-card-header{
    padding:20px 24px;
    border-bottom:1px solid #f1f5f9;
}

.form-card-header h5{
    margin:0;
    font-size:16px;
    font-weight:700;
    color:#1e0536;
    display:flex;
    align-items:center;
    gap:8px;
}

.form-card-header h5 i{
    color:#EB7405;
}

.form-body{
    padding:24px;
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    margin-bottom:8px;
    font-size:13px;
    font-weight:600;
    color:#334155;
}

.form-group label span{
    color:#dc2626;
}

.form-control{
    height:48px;
    border:1.5px solid #e2e8f0;
    border-radius:12px;
    padding:0 14px;
    font-size:14px;
    outline:none;
    transition:.3s;
}

.form-control:focus{
    border-color:#EB7405;
    box-shadow:0 0 0 4px rgba(235,116,5,.1);
}

.form-footer{
    border-top:1px solid #f1f5f9;
    padding:20px 24px;
    display:flex;
    gap:12px;
}

.btn-save{
    border:none;
    background:linear-gradient(135deg,#EB7405,#DC410A);
    color:#fff;
    padding:12px 22px;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
    box-shadow:0 4px 14px rgba(235,116,5,.35);
}

.btn-save:hover{
    transform:translateY(-2px);
}

.btn-cancel{
    text-decoration:none;
    background:#f1f5f9;
    color:#64748b;
    padding:12px 22px;
    border-radius:12px;
    font-weight:600;
}

.invalid-feedback{
    color:#dc2626;
    font-size:12px;
    margin-top:6px;
}

@media(max-width:768px){
    .form-body{
        grid-template-columns:1fr;
    }
}

</style>
@endpush


@push('scripts')
<script>
document.querySelector('input[name="name"]').addEventListener('keyup', function () {

    let slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    document.getElementById('slug').value = slug;
});
</script>
@endpush
@extends('wl-admin.layouts.app')

@push('styles')

<style>

/* ==========================
   PAGE HEADER
========================== */
.page-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.page-top-left h2{
    margin:0;
    font-size:28px;
    font-weight:700;
    color:#1e0536;
}

.breadcrumb-bar{
    margin-top:5px;
    font-size:14px;
}

.breadcrumb-bar a{
    color:#EB7405;
    text-decoration:none;
}

.breadcrumb-bar span{
    color:#94a3b8;
}

/* ==========================
   CARD
========================== */
.category-card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

.card-title{
    font-size:20px;
    font-weight:700;
    color:#1e0536;
    margin-bottom:20px;
}

/* ==========================
   BUTTONS
========================== */
.btn-add{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    color:#fff;
    text-decoration:none;
    border:none;
    padding:12px 22px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.btn-add:hover{
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(235,116,5,.35);
}

/* ==========================
   TABLE
========================== */
.table-responsive{
    overflow-x:auto;
}

.category-table{
    width:100%;
    border-collapse:collapse;
}

.category-table thead th{
    background:#fafafa;
    color:#1e0536;
    font-size:13px;
    font-weight:700;
    padding:15px;
    border-bottom:1px solid #eee;
}

.category-table tbody td{
    padding:15px;
    border-bottom:1px solid #f5f5f5;
    vertical-align:middle;
}

.category-table tbody tr:hover{
    background:#fffaf5;
}

/* ==========================
   IMAGE
========================== */
.cat-image{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:12px;
    border:1px solid #eee;
}

.cat-placeholder{
    width:60px;
    height:60px;
    border-radius:12px;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    color:#94a3b8;
}

/* ==========================
   STATUS
========================== */
.status{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status.active{
    background:#dcfce7;
    color:#15803d;
}

.status.inactive{
    background:#fee2e2;
    color:#dc2626;
}

/* ==========================
   ACTION BUTTONS
========================== */
.action-btns{
    display:flex;
    gap:8px;
}

.btn-edit,
.btn-delete{
    width:38px;
    height:38px;
    border:none;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    transition:.3s;
}

.btn-edit{
    background:#fff7ed;
    color:#EB7405;
}

.btn-edit:hover{
    background:#EB7405;
    color:#fff;
}

.btn-delete{
    background:#fee2e2;
    color:#dc2626;
}

.btn-delete:hover{
    background:#dc2626;
    color:#fff;
}

/* ==========================
   EMPTY STATE
========================== */
.empty-state{
    text-align:center;
    padding:50px 0;
    color:#94a3b8;
}

.empty-state i{
    font-size:50px;
    margin-bottom:10px;
    display:block;
}

/* ==========================
   PAGINATION
========================== */
.pagination{
    margin-top:20px;
}

.pagination svg{
    width:16px;
    height:16px;
}

</style>

@endpush

@section('content')

<div class="container-fluid">

<!-- Header -->
<div class="page-top">

    <div class="page-top-left">

        <h2>Categories</h2>

        <div class="breadcrumb-bar">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span> / </span>
            <span>Categories</span>
        </div>

    </div>

    <a href="{{ route('admin.addcategory') }}" class="btn-add">
        <i class="ri-add-line"></i>
        Add Category
    </a>

</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<!-- Card -->
<div class="category-card">

    <h4 class="card-title">Category List</h4>

    <div class="table-responsive">

        <table class="category-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th width="130">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($categories as $category)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        @if($category->image)

                            <img
                                src="{{ asset('uploads/categories/'.$category->image) }}"
                                alt="{{ $category->name }}"
                                class="cat-image">

                        @else

                            <div class="cat-placeholder">
                                <i class="ri-image-line"></i>
                            </div>

                        @endif

                    </td>

                    <td>
                        <strong>{{ $category->name }}</strong>
                    </td>

                    <td>{{ $category->slug }}</td>

                    <td>

                        @if($category->status)

                            <span class="status active">
                                Active
                            </span>

                        @else

                            <span class="status inactive">
                                Inactive
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $category->created_at->format('d M Y') }}
                    </td>

                    <td>

                        <div class="action-btns">

                            <a href="{{ route('admin.editcategory',$category->id) }}"
                               class="btn-edit">
                                <i class="ri-pencil-line"></i>
                            </a>

                            <form action="{{ route('admin.deletecategory', $category->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7">

                        <div class="empty-state">
                            <i class="ri-folder-open-line"></i>
                            <h5>No Categories Found</h5>
                        </div>

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

</div>

</div>

@endsection

@push('scripts')

<script>
console.log('Category List Loaded');
</script>

@endpush

@extends('wl-admin.layouts.app')

@push('styles')
    <style>
        .page-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-top-left h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #1e0536;
        }

        .breadcrumb-bar {
            margin-top: 5px;
            font-size: 14px;
        }

        .breadcrumb-bar a {
            color: #EB7405;
            text-decoration: none;
        }

        .breadcrumb-bar span {
            color: #94a3b8;
        }

        .category-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e0536;
            margin-bottom: 20px;
        }

        .btn-add {
            background: linear-gradient(135deg, #EB7405, #DC410A);
            color: #fff;
            text-decoration: none;
            border: none;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: .3s;
        }

        .btn-add:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(235, 116, 5, .35);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .subcategory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .subcategory-table thead th {
            background: #fafafa;
            color: #1e0536;
            font-size: 13px;
            font-weight: 700;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .subcategory-table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }

        .subcategory-table tbody tr:hover {
            background: #fffaf5;
        }

        .subcat-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #eee;
        }

        .no-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 24px;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.active {
            background: #dcfce7;
            color: #15803d;
        }

        .status.inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-edit,
        .btn-delete {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .3s;
        }

        .btn-edit {
            background: #fff7ed;
            color: #EB7405;
        }

        .btn-edit:hover {
            background: #EB7405;
            color: #fff;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 50px 0;
        }

        .empty-state i {
            font-size: 50px;
            color: #94a3b8;
        }

        .empty-state h5 {
            margin-top: 10px;
            color: #64748b;
        }

        .success-alert {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="page-top">

            <div class="page-top-left">

                <h2>Sub Categories</h2>

                <div class="breadcrumb-bar">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <span>Sub Categories</span>
                </div>

            </div>

            <a href="{{ route('add.subcategory') }}" class="btn-add">
                <i class="ri-add-line"></i>
                Add Sub Category
            </a>

        </div>

        @if (session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="category-card">

            <h4 class="card-title">
                Sub Category List
            </h4>

            <div class="table-responsive">

                <table class="subcategory-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($subcategories as $subcategory)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>

                                    @if ($subcategory->image)
                                        <img src="{{ asset('uploads/subcategories/' . $subcategory->image) }}"
                                            class="subcat-image">
                                    @else
                                        <div class="no-image">
                                            <i class="ri-image-line"></i>
                                        </div>
                                    @endif

                                </td>

                                <td>
                                    {{ $subcategory->category->name ?? '-' }}
                                </td>

                                <td>
                                    <strong>{{ $subcategory->name }}</strong>
                                </td>

                                <td>
                                    {{ $subcategory->slug }}
                                </td>

                                <td>

                                    @if ($subcategory->status)
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
                                    {{ $subcategory->created_at->format('d M Y') }}
                                </td>

                                <td>

                                    <div class="action-btns">

                                        <a href="{{ route('edit.subcategory', $subcategory->id) }}" class="btn-edit">
                                            <i class="ri-pencil-line"></i>
                                        </a>

<form action="{{ route('delete.subcategory', $subcategory->id) }}"
      method="POST"
      onsubmit="return confirm('Delete this sub category?')">

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
                                <td colspan="8">

                                    <div class="empty-state">

                                        <i class="ri-folder-open-line"></i>

                                        <h5>
                                            No Sub Categories Found
                                        </h5>

                                    </div>

                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $subcategories->links() }}
            </div>
        </div>
    </div>
@endsection

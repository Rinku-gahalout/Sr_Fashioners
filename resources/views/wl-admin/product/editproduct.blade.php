@extends('wl-admin.layouts.app')

@push('styles')
    <style>
        /* ══════════════════════════════
                   PAGE HEADER
                ══════════════════════════════ */
        .page-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 26px;
        }

        .page-top-left h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
        }

        .breadcrumb-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .breadcrumb-bar a {
            color: #EB7405;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-bar span {
            color: #cbd5e1;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: #475569;
            padding: 11px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            transition: .3s;
        }

        .btn-back:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        /* ══════════════════════════════
                   LAYOUT GRID
                ══════════════════════════════ */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 22px;
            align-items: start;
        }

        /* ══════════════════════════════
                   SECTION CARDS
                ══════════════════════════════ */
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
            margin-bottom: 22px;
        }

        .form-card:last-child {
            margin-bottom: 0;
        }

        .card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-head-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #EB7405, #DC410A);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }

        .card-head h5 {
            font-size: 15px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
        }

        .card-head p {
            font-size: 12px;
            color: #94a3b8;
            margin: 2px 0 0;
        }

        .card-body {
            padding: 22px;
        }

        /* ══════════════════════════════
                   FORM ELEMENTS
                ══════════════════════════════ */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-row.cols-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .form-row.cols-1 {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-group label .req {
            color: #DC410A;
            font-size: 15px;
            line-height: 1;
        }

        .form-group label i {
            font-size: 15px;
            color: #EB7405;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #374151;
            outline: none;
            transition: .3s;
            background: #fff;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #EB7405;
            box-shadow: 0 0 0 3px rgba(235, 116, 5, .1);
        }

        .form-control::placeholder {
            color: #c0c8d8;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 110px;
            font-family: inherit;
            line-height: 1.6;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* Input with prefix/suffix */
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-prefix,
        .input-suffix {
            position: absolute;
            font-size: 13px;
            font-weight: 700;
            color: #94a3b8;
            pointer-events: none;
        }

        .input-prefix {
            left: 13px;
        }

        .input-suffix {
            right: 13px;
        }

        .input-wrap .form-control.has-prefix {
            padding-left: 30px;
        }

        .input-wrap .form-control.has-suffix {
            padding-right: 38px;
        }

        /* Helper text */
        .form-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint i {
            font-size: 13px;
            color: #EB7405;
        }

        /* Character counter */
        .char-counter {
            font-size: 12px;
            color: #94a3b8;
            text-align: right;
            margin-top: 3px;
        }

        /* Divider */
        .form-divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 20px 0;
        }

        /* ══════════════════════════════
                   SKU GENERATOR
                ══════════════════════════════ */
        .sku-row {
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .sku-row .form-control {
            flex: 1;
        }

        .btn-generate {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 14px;
            border-radius: 10px;
            background: linear-gradient(135deg, #EB7405, #DC410A);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: .3s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-generate:hover {
            box-shadow: 0 4px 14px rgba(235, 116, 5, .4);
            transform: translateY(-1px);
        }

        /* ══════════════════════════════
                   PRICE CALCULATOR
                ══════════════════════════════ */
        .price-preview {
            background: linear-gradient(135deg, #fff7ed, #fff3e0);
            border: 1.5px solid #fed7aa;
            border-radius: 12px;
            padding: 14px 18px;
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .price-preview-item {
            text-align: center;
        }

        .price-preview-item .val {
            font-size: 18px;
            font-weight: 700;
            color: #1e0536;
        }

        .price-preview-item .lbl {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-top: 2px;
        }

        .price-preview-item .val.saving {
            color: #16a34a;
        }

        .price-preview-item .val.discount {
            color: #DC410A;
        }

        .price-preview-item .val.orange {
            color: #EB7405;
        }

        .price-divider {
            width: 1px;
            height: 36px;
            background: #fec89a;
        }

        /* ══════════════════════════════
                   STOCK THRESHOLDS
                ══════════════════════════════ */
        .threshold-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #92400e;
            margin-top: 16px;
            line-height: 1.5;
        }

        .threshold-note i {
            font-size: 18px;
            color: #f59e0b;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ══════════════════════════════
                   SIZE CHART
                ══════════════════════════════ */
        .size-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 4px;
        }

        .size-chip {
            position: relative;
        }

        .size-chip input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .size-chip label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            transition: .2s;
            background: #fff;
            min-width: 52px;
            text-align: center;
        }

        .size-chip label span.size-lbl {
            font-size: 15px;
            font-weight: 800;
            color: #1e0536;
        }

        .size-chip label span.size-sub {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 500;
        }

        .size-chip input:checked+label {
            border-color: #EB7405;
            background: linear-gradient(135deg, #fff7ed, #fff3e0);
            color: #EB7405;
            box-shadow: 0 2px 8px rgba(235, 116, 5, .2);
        }

        .size-chip label:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        /* ══════════════════════════════
                   COLOR SWATCHES
                ══════════════════════════════ */
        .color-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 4px;
        }

        .color-chip {
            position: relative;
        }

        .color-chip input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .color-chip label {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 13px;
            border: 1.5px solid #e2e8f0;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            transition: .2s;
            background: #fff;
        }

        .color-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(0, 0, 0, .1);
            flex-shrink: 0;
        }

        .color-chip input:checked+label {
            border-color: #EB7405;
            color: #EB7405;
            background: #fff7ed;
        }

        .color-chip label:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        /* ══════════════════════════════
                   IMAGE UPLOAD
                ══════════════════════════════ */
        .image-upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 14px;
            padding: 36px 20px;
            text-align: center;
            cursor: pointer;
            transition: .3s;
            position: relative;
            background: #fafbff;
        }

        .image-upload-zone:hover,
        .image-upload-zone.dragover {
            border-color: #EB7405;
            background: #fff7ed;
        }

        .image-upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, #fff7ed, #ffe4c4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #EB7405;
            margin: 0 auto 14px;
            border: 1.5px solid #fecda2;
        }

        .image-upload-zone h6 {
            font-size: 14px;
            font-weight: 700;
            color: #1e0536;
            margin: 0 0 5px;
        }

        .image-upload-zone p {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
            line-height: 1.5;
        }

        .upload-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 10px;
        }

        /* Image previews */
        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 14px;
        }

        .img-preview-wrap {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 1;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
        }

        .img-preview-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .img-preview-wrap .img-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(220, 38, 38, .85);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
        }

        .img-preview-wrap .img-remove:hover {
            background: #dc2626;
        }

        .img-preview-wrap .img-main-badge {
            position: absolute;
            bottom: 4px;
            left: 4px;
            background: rgba(235, 116, 5, .9);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ══════════════════════════════
                   STATUS TOGGLE
                ══════════════════════════════ */
        .toggle-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toggle-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: .25s;
        }

        .toggle-option:hover {
            border-color: #EB7405;
        }

        .toggle-option-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-option-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .toggle-option-icon.active-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .toggle-option-icon.inactive-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .toggle-option-icon.draft-icon {
            background: #fef9c3;
            color: #ca8a04;
        }

        .toggle-option-text strong {
            font-size: 13px;
            font-weight: 700;
            color: #1e0536;
            display: block;
        }

        .toggle-option-text span {
            font-size: 11px;
            color: #94a3b8;
        }

        .toggle-option input[type="radio"] {
            accent-color: #EB7405;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* ══════════════════════════════
                   TAGS INPUT
                ══════════════════════════════ */
        .tags-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            min-height: 46px;
            transition: .3s;
            cursor: text;
            background: #fff;
            align-items: center;
        }

        .tags-wrap:focus-within {
            border-color: #EB7405;
            box-shadow: 0 0 0 3px rgba(235, 116, 5, .1);
        }

        .tag-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, #fff7ed, #ffe4c4);
            color: #c2410c;
            border: 1px solid #fecda2;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .tag-remove {
            background: none;
            border: none;
            color: #c2410c;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
            display: flex;
            align-items: center;
            line-height: 1;
            opacity: .7;
        }

        .tag-remove:hover {
            opacity: 1;
        }

        .tag-input {
            border: none;
            outline: none;
            font-size: 13px;
            color: #374151;
            background: transparent;
            min-width: 100px;
            flex: 1;
        }

        .tag-input::placeholder {
            color: #c0c8d8;
        }

        /* ══════════════════════════════
                   SUMMARY CARD (sidebar)
                ══════════════════════════════ */
        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 0;
            border-bottom: 1px dashed #f1f5f9;
            font-size: 13px;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row .s-key {
            color: #94a3b8;
            font-weight: 500;
        }

        .summary-row .s-val {
            font-weight: 700;
            color: #1e0536;
            text-align: right;
            max-width: 160px;
            word-break: break-word;
        }

        .summary-row .s-val.orange {
            color: #EB7405;
        }

        /* ══════════════════════════════
                   FORM ACTIONS
                ══════════════════════════════ */
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, #EB7405, #DC410A);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 4px 14px rgba(235, 116, 5, .35);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(235, 116, 5, .45);
        }

        .btn-draft {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: #fff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .btn-draft:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        .btn-discard {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 20px;
            background: #fff;
            color: #94a3b8;
            border: 1.5px solid #f1f5f9;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            text-decoration: none;
        }

        .btn-discard:hover {
            border-color: #fee2e2;
            color: #dc2626;
        }

        /* Tips card */
        .tips-card {
            background: linear-gradient(135deg, #1e0536, #3b0764);
            border-radius: 14px;
            padding: 20px;
            color: #fff;
            margin-bottom: 22px;
        }

        .tips-card h6 {
            font-size: 13px;
            font-weight: 700;
            color: #EB7405;
            margin: 0 0 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 9px;
            line-height: 1.5;
        }

        .tip-item:last-child {
            margin-bottom: 0;
        }

        .tip-item i {
            font-size: 15px;
            color: #EB7405;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ══════════════════════════════
                   VALIDATION STATES
                ══════════════════════════════ */
        .form-control.is-invalid {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .1);
        }

        .invalid-feedback {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .gallery-item {
            position: relative;
            display: inline-block;
        }

        .gallery-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .delete-image-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 22px;
            height: 22px;
            border: none;
            border-radius: 50%;
            background: #ef4444;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .delete-image-btn:hover {
            background: #dc2626;
        }

        /* ══════════════════════════════
                   RESPONSIVE
                ══════════════════════════════ */
        @media (max-width: 1100px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .sidebar-col {
                display: contents;
            }
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-row.cols-3 {
                grid-template-columns: 1fr 1fr;
            }

            .image-preview-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .page-top {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .form-row.cols-3 {
                grid-template-columns: 1fr;
            }

            .image-preview-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── Page Top ── --}}
    <div class="page-top">
        <div class="page-top-left">
            <h2>Edit Product</h2>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.product') }}">Products</a>
                <span>/</span>
                <span>Edit</span>
            </div>
        </div>
        <a href="{{ route('admin.product') }}" class="btn-back">
            <i class='bx bx-arrow-back'></i>
            Back to Products
        </a>
    </div>

    {{-- ── Main Form ── --}}
    <form action="{{ route('update.product', $product->id) }}" method="POST" enctype="multipart/form-data"
        id="addProductForm">
        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- ═══════════════════════════════
                 LEFT COLUMN — Main Details
            ════════════════════════════════ --}}
            <div class="main-col">

                {{-- 1. Basic Information --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-info-circle'></i></div>
                        <div>
                            <h5>Basic Information</h5>
                            <p>Product name, SKU, and description</p>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Product Name --}}
                        <div class="form-group" style="margin-bottom:18px;">
                            <label>
                                <i class='bx bx-purchase-tag'></i>
                                Product Name <span class="req">*</span>
                            </label>
                            <input type="text" name="name" id="productName"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g. Classic Comfort Chino Pants" value="{{ old('name', $product->name) }}"
                                maxlength="150" required>
                            <div class="char-counter"><span id="nameCount">0</span> / 150</div>
                            @error('name')
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SKU --}}
                        <div class="form-group" style="margin-bottom:18px;">
                            <label>
                                <i class='bx bx-barcode'></i>
                                SKU (Stock Keeping Unit) <span class="req">*</span>
                            </label>
                            <div class="sku-row">
                                <input type="text" name="sku" id="skuField"
                                    class="form-control @error('sku') is-invalid @enderror" placeholder="e.g. SRF-0001"
                                    value="{{ old('sku', $product->sku) }}" required>
                                <button type="button" class="btn-generate" id="btnGenerateSKU">
                                    <i class='bx bx-refresh'></i> Auto Generate
                                </button>
                            </div>
                            <span class="form-hint">
                                <i class='bx bx-info-circle'></i>Must be unique. Use prefix SRF- for consistency.
                            </span>
                            @error('sku')
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Short Description --}}
                        <div class="form-group" style="margin-bottom:18px;">
                            <label>
                                <i class='bx bx-align-left'></i>
                                Short Description
                            </label>
                            <input type="text" name="short_description"
                                class="form-control @error('short_description') is-invalid @enderror"
                                placeholder="A brief one-line summary of the product…"
                                value="{{ old('short_description', $product->short_description) }}" maxlength="250">
                            <span class="form-hint">
                                <i class='bx bx-info-circle'></i>Shown on product listing cards. Max 250 characters.
                            </span>
                            @error('short_description')
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Full Description --}}
                        <div class="form-group">
                            <label>
                                <i class='bx bx-file-blank'></i>
                                Full Description
                            </label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe the product in detail — fabric, features, occasion, care instructions…">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- 2. Category & Attributes --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-category'></i></div>
                        <div>
                            <h5>Category &amp; Attributes</h5>
                            <p>Classification, fabric, and tags</p>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-row" style="margin-bottom:18px;">

                            {{-- Category --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-layer'></i>
                                    Category <span class="req">*</span>
                                </label>
                                <select name="category_id" id="productCategory"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">— Select Category —</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sub Category --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-category'></i>
                                    Sub Category <span class="req"></span>
                                </label>
                                <select name="subcategory_id" id="productSubCategory"
                                    class="form-control @error('subcategory_id') is-invalid @enderror">
                                    <option value="">— Select Sub Category —</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            data-category="{{ $subcategory->category_id }}"
                                            {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- Fabric --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-grid-alt'></i>
                                    Fabric / Material
                                </label>
                                <select name="fabric" id="productFabric"
                                    class="form-control @error('fabric') is-invalid @enderror">
                                    <option value="">— Select Fabric —</option>
                                    <option value="100_cotton"
                                        {{ old('fabric', $product->fabric) == '100_cotton' ? 'selected' : '' }}>100%
                                        Cotton</option>
                                    <option value="cotton_blend"
                                        {{ old('fabric', $product->fabric) == 'cotton_blend' ? 'selected' : '' }}>Cotton
                                        Blend</option>
                                    <option value="linen"
                                        {{ old('fabric', $product->fabric) == 'linen' ? 'selected' : '' }}>Linen
                                    </option>
                                    <option value="denim"
                                        {{ old('fabric', $product->fabric) == 'denim' ? 'selected' : '' }}>Denim
                                    </option>
                                    <option value="polyester"
                                        {{ old('fabric', $product->fabric) == 'polyester' ? 'selected' : '' }}>Polyester
                                    </option>
                                    <option value="lycra_blend"
                                        {{ old('fabric', $product->fabric) == 'lycra_blend' ? 'selected' : '' }}>Lycra
                                        Blend</option>
                                    <option value="terry_cotton"
                                        {{ old('fabric', $product->fabric) == 'terry_cotton' ? 'selected' : '' }}>Terry
                                        Cotton</option>
                                </select>
                                @error('fabric')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <hr class="form-divider">

                        {{-- Tags --}}
                        <div class="form-group">
                            <label>
                                <i class='bx bx-purchase-tag-alt'></i>
                                Tags
                            </label>
                            <div class="tags-wrap" id="tagsWrap">
                                <input type="text" id="tagInput" class="tag-input"
                                    placeholder="Type a tag and press Enter or comma…">
                            </div>
                            <input type="hidden" name="tags" id="tagsHidden"
                                value="{{ old('tags', $product->tags) }}">
                            <span class="form-hint">
                                <i class='bx bx-info-circle'></i>Press Enter or comma to add a tag. Helps with search.
                            </span>
                        </div>

                    </div>
                </div>

                {{-- 3. Pricing --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-rupee'></i></div>
                        <div>
                            <h5>Pricing</h5>
                            <p>MRP, selling price, and discount</p>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-row cols-3" style="margin-bottom:16px;">

                            {{-- MRP --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-tag'></i>
                                    MRP <span class="req">*</span>
                                </label>
                                <div class="input-wrap">
                                    <span class="input-prefix">₹</span>
                                    <input type="number" name="mrp" id="mrpField"
                                        class="form-control has-prefix @error('mrp') is-invalid @enderror"
                                        placeholder="0.00" min="0" step="0.01"
                                        value="{{ old('mrp', $product->mrp) }}" required>
                                </div>
                                @error('mrp')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Discount % --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-minus-circle'></i>
                                    Discount (%)
                                </label>
                                <div class="input-wrap">
                                    <input type="number" name="discount_percent" id="discountField"
                                        class="form-control has-suffix @error('discount_percent') is-invalid @enderror"
                                        placeholder="0" min="0" max="100"
                                        value="{{ old('discount_percent', $product->discount_percent) }}">
                                    <span class="input-suffix">%</span>
                                </div>
                                @error('discount_percent')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Selling Price --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-cart'></i>
                                    Selling Price <span class="req">*</span>
                                </label>
                                <div class="input-wrap">
                                    <span class="input-prefix">₹</span>
                                    <input type="number" name="selling_price" id="sellingPriceField"
                                        class="form-control has-prefix @error('selling_price') is-invalid @enderror"
                                        placeholder="0.00" min="0" step="0.01"
                                        value="{{ old('selling_price', $product->selling_price) }}" required>
                                </div>
                                @error('selling_price')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- Price Preview --}}
                        <div class="price-preview" id="pricePreview">
                            <div class="price-preview-item">
                                <div class="val" id="previewMRP">₹0</div>
                                <div class="lbl">MRP</div>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-preview-item">
                                <div class="val discount" id="previewDiscount">0%</div>
                                <div class="lbl">Discount</div>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-preview-item">
                                <div class="val orange" id="previewSelling">₹0</div>
                                <div class="lbl">Selling Price</div>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-preview-item">
                                <div class="val saving" id="previewSaving">₹0</div>
                                <div class="lbl">Customer Saves</div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- 4. Inventory & Stock --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-package'></i></div>
                        <div>
                            <h5>Inventory &amp; Stock</h5>
                            <p>Quantity and low-stock threshold</p>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-row" style="margin-bottom:18px;">

                            {{-- Stock Quantity --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-cube'></i>
                                    Stock Quantity <span class="req">*</span>
                                </label>
                                <div class="input-wrap">
                                    <input type="number" name="stock_quantity" id="stockField"
                                        class="form-control has-suffix @error('stock_quantity') is-invalid @enderror"
                                        placeholder="0" min="0"
                                        value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                    <span class="input-suffix">units</span>
                                </div>
                                @error('stock_quantity')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Low Stock Threshold --}}
                            <div class="form-group">
                                <label>
                                    <i class='bx bx-error-circle'></i>
                                    Low Stock Alert At
                                </label>
                                <div class="input-wrap">
                                    <input type="number" name="low_stock_threshold"
                                        class="form-control has-suffix @error('low_stock_threshold') is-invalid @enderror"
                                        placeholder="10" min="0"
                                        value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
                                    <span class="input-suffix">units</span>
                                </div>
                                @error('low_stock_threshold')
                                    <div class="invalid-feedback"><i class='bx bx-error-circle'></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="threshold-note">
                            <i class='bx bx-bulb'></i>
                            <div>
                                When stock falls below the <strong>Low Stock Alert</strong> threshold, the product status
                                will automatically change to <strong>Low Stock</strong> and you'll receive a dashboard
                                alert.
                            </div>
                        </div>

                    </div>
                </div>

                {{-- 5. Sizes & Colors --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon">
                            <i class='bx bx-palette'></i>
                        </div>
                        <div>
                            <h5>Sizes & Colors</h5>
                            <p>Available variants for this product</p>
                        </div>
                    </div>

                    <div class="card-body">

                        @php
                            $selectedSizes = old('sizes', $product->sizes ?? []);
                            $selectedColors = old('colors', $product->colors ?? []);

                            $sizes = [
                                ['val' => '28', 'sub' => 'Waist 28'],
                                ['val' => '30', 'sub' => 'Waist 30'],
                                ['val' => '32', 'sub' => 'Waist 32'],
                                ['val' => '34', 'sub' => 'Waist 34'],
                                ['val' => '36', 'sub' => 'Waist 36'],
                                ['val' => '38', 'sub' => 'Waist 38'],
                                ['val' => '40', 'sub' => 'Waist 40'],
                                ['val' => '42', 'sub' => 'Waist 42'],
                                ['val' => 'S', 'sub' => 'Small'],
                                ['val' => 'M', 'sub' => 'Medium'],
                                ['val' => 'L', 'sub' => 'Large'],
                                ['val' => 'XL', 'sub' => 'X-Large'],
                            ];

                            $colors = [
                                ['val' => 'black', 'label' => 'Black', 'hex' => '#1a1a1a'],
                                ['val' => 'white', 'label' => 'White', 'hex' => '#f0f0f0'],
                                ['val' => 'navy', 'label' => 'Navy Blue', 'hex' => '#1e3a5f'],
                                ['val' => 'grey', 'label' => 'Grey', 'hex' => '#6b7280'],
                                ['val' => 'khaki', 'label' => 'Khaki', 'hex' => '#c3a882'],
                                ['val' => 'olive', 'label' => 'Olive', 'hex' => '#6b7c48'],
                                ['val' => 'brown', 'label' => 'Brown', 'hex' => '#7c5c3a'],
                                ['val' => 'wine', 'label' => 'Wine', 'hex' => '#722f37'],
                                ['val' => 'beige', 'label' => 'Beige', 'hex' => '#e8d5b7'],
                                ['val' => 'dark_blue', 'label' => 'Dark Blue', 'hex' => '#1e2a6e'],
                            ];
                        @endphp

                        {{-- Sizes --}}
                        <div class="form-group mb-4">

                            <label>
                                <i class='bx bx-ruler'></i>
                                Available Sizes
                            </label>

                            <div class="size-grid">

                                @foreach ($sizes as $size)
                                    <div class="size-chip">

                                        <input type="checkbox" name="sizes[]" id="size_{{ $size['val'] }}"
                                            value="{{ $size['val'] }}"
                                            {{ in_array($size['val'], $selectedSizes) ? 'checked' : '' }}>

                                        <label for="size_{{ $size['val'] }}">

                                            <span class="size-lbl">
                                                {{ $size['val'] }}
                                            </span>

                                            <span class="size-sub">
                                                {{ $size['sub'] }}
                                            </span>

                                        </label>

                                    </div>
                                @endforeach

                            </div>

                            <span class="form-hint">
                                <i class='bx bx-info-circle'></i>
                                Select all sizes this product is available in.
                            </span>

                        </div>

                        <hr class="form-divider">

                        {{-- Colors --}}
                        <div class="form-group">

                            <label>
                                <i class='bx bx-color-fill'></i>
                                Available Colors
                            </label>

                            <div class="color-grid">

                                @foreach ($colors as $color)
                                    <div class="color-chip">

                                        <input type="checkbox" name="colors[]" id="color_{{ $color['val'] }}"
                                            value="{{ $color['val'] }}"
                                            {{ in_array($color['val'], $selectedColors) ? 'checked' : '' }}>

                                        <label for="color_{{ $color['val'] }}">

                                            <span class="color-dot" style="background:{{ $color['hex'] }};">
                                            </span>

                                            {{ $color['label'] }}

                                        </label>

                                    </div>
                                @endforeach

                            </div>

                            <span class="form-hint">
                                <i class='bx bx-info-circle'></i>
                                Select all colors available for this product.
                            </span>

                        </div>

                    </div>
                </div>

                {{-- 6. Product Images --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-images'></i></div>
                        <div>
                            <h5>Product Images</h5>
                            <p>Main image and gallery shots</p>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Main Image --}}
                        <div class="form-group" style="margin-bottom:22px;">
                            <label>
                                <i class='bx bx-image'></i>
                                Main Product Image <span class="req">*</span>
                            </label>

                            {{-- Current Image --}}
                            @if ($product->main_image)
                                <div class="mb-3">
                                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                                        style="
                    width:180px;
                    height:180px;
                    object-fit:cover;
                    border-radius:12px;
                    border:1px solid #e5e7eb;
                ">
                                </div>
                            @endif

                            <div class="image-upload-zone" id="mainImageZone">

                                <input type="file" name="main_image" id="mainImageInput" accept="image/*"
                                    onchange="previewMainImage(this)">

                                <div id="mainUploadPlaceholder">
                                    <div class="upload-icon">
                                        <i class='bx bx-cloud-upload'></i>
                                    </div>

                                    <h6>Drop main image here or click to browse</h6>

                                    <p>
                                        Leave empty if you don't want to change the image
                                    </p>

                                    <span class="upload-badge">
                                        JPG, PNG, WebP — Max 2MB
                                    </span>
                                </div>

                                <div id="mainImagePreviewWrap" style="display:none;">
                                    <img id="mainImagePreview" src="" alt="Preview"
                                        style="
                    max-height:200px;
                    border-radius:10px;
                    object-fit:contain;
                ">
                                </div>

                            </div>

                            @error('main_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Gallery Images --}}
                        <div class="form-group">
                            <label>
                                <i class='bx bx-image-alt'></i>
                                Gallery Images <span style="color:#94a3b8; font-weight:400;">(Optional)</span>
                            </label>

                            {{-- EXISTING IMAGES --}}
                            @if ($product->images->count())
                                <div class="existing-gallery"
                                    style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px;">

                                    @foreach ($product->images as $image)
                                        <div class="gallery-item">
                                            <img src="{{ asset($image->image_path) }}" width="80" height="80">

                                            <button type="button" class="delete-image-btn"
                                                onclick="deleteGalleryImage({{ $image->id }})">
                                                <i class='bx bx-x'></i>
                                            </button>
                                        </div>
                                    @endforeach

                                </div>
                            @endif

                            {{-- UPLOAD NEW --}}
                            <div class="image-upload-zone" id="galleryZone">
                                <input type="file" name="gallery_images[]" id="galleryInput" accept="image/*"
                                    multiple onchange="previewGallery(this)">

                                <div class="upload-icon"><i class='bx bx-images'></i></div>
                                <h6>Drop multiple images here</h6>
                                <p>Upload up to 8 gallery images for product details page</p>
                                <span class="upload-badge">Up to 8 images — JPG, PNG, WebP — Max 2MB each</span>
                            </div>

                            {{-- NEW PREVIEW --}}
                            <div class="image-preview-grid" id="galleryPreviewGrid"></div>

                            @error('gallery_images')
                                <div class="invalid-feedback">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>{{-- end .main-col --}}

            {{-- ═══════════════════════════════
                 RIGHT COLUMN — Sidebar
            ════════════════════════════════ --}}
            <div class="sidebar-col">

                {{-- Tips Card --}}
                <div class="tips-card">
                    <h6><i class='bx bx-bulb'></i> Pro Tips</h6>
                    <div class="tip-item">
                        <i class='bx bx-check-circle'></i>
                        Use a clear, high-resolution main image against a clean background.
                    </div>
                    <div class="tip-item">
                        <i class='bx bx-check-circle'></i>
                        Select the correct fabric so customers can filter by material easily.
                    </div>
                    <div class="tip-item">
                        <i class='bx bx-check-circle'></i>
                        Set a low-stock threshold to get timely restocking alerts.
                    </div>
                    <div class="tip-item">
                        <i class='bx bx-check-circle'></i>
                        Tags help with internal search. Use fabric, occasion, and style keywords.
                    </div>
                </div>

                {{-- Product Status --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-toggle-right'></i></div>
                        <div>
                            <h5>Product Status</h5>
                            <p>Set the initial visibility</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toggle-group">

                            <label class="toggle-option">
                                <div class="toggle-option-left">
                                    <div class="toggle-option-icon active-icon">
                                        <i class='bx bx-check-circle'></i>
                                    </div>
                                    <div class="toggle-option-text">
                                        <strong>Active</strong>
                                        <span>Visible to customers immediately</span>
                                    </div>
                                </div>
                                <input type="radio" name="status" value="active"
                                    {{ old('status', $product->status) == 'active' ? 'checked' : '' }}>
                            </label>

                            <label class="toggle-option">
                                <div class="toggle-option-left">
                                    <div class="toggle-option-icon draft-icon">
                                        <i class='bx bx-pencil'></i>
                                    </div>
                                    <div class="toggle-option-text">
                                        <strong>Draft</strong>
                                        <span>Save but not visible yet</span>
                                    </div>
                                </div>
                                <input type="radio" name="status" value="draft"
                                    {{ old('status', $product->status) == 'draft' ? 'checked' : '' }}>
                            </label>

                            <label class="toggle-option">
                                <div class="toggle-option-left">
                                    <div class="toggle-option-icon inactive-icon">
                                        <i class='bx bx-x-circle'></i>
                                    </div>
                                    <div class="toggle-option-text">
                                        <strong>Inactive</strong>
                                        <span>Hidden from all listings</span>
                                    </div>
                                </div>
                                <input type="radio" name="status" value="inactive"
                                    {{ old('status', $product->status) == 'inactive' ? 'checked' : '' }}>
                            </label>

                        </div>
                    </div>
                </div>

                {{-- Live Summary --}}
                <div class="form-card">
                    <div class="card-head">
                        <div class="card-head-icon"><i class='bx bx-list-check'></i></div>
                        <div>
                            <h5>Live Summary</h5>
                            <p>Preview before saving</p>
                        </div>
                    </div>
                    <div class="card-body" style="padding:16px 20px;">
                        <div class="summary-row">
                            <span class="s-key">Product Name</span>
                            <span class="s-val orange" id="sumName">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">SKU</span>
                            <span class="s-val" id="sumSKU">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">Category</span>
                            <span class="s-val" id="sumCategory">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">Fabric</span>
                            <span class="s-val" id="sumFabric">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">MRP</span>
                            <span class="s-val" id="sumMRP">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">Selling Price</span>
                            <span class="s-val orange" id="sumPrice">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="s-key">Stock</span>
                            <span class="s-val" id="sumStock">—</span>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-card">
                    <div class="card-body">
                        <div class="form-actions">
                            <button type="submit" name="action" value="publish" class="btn-submit">
                                <i class='bx bx-check-double'></i>
                                Save &amp; Publish Product
                            </button>
                            <button type="submit" name="action" value="draft" class="btn-draft">
                                <i class='bx bx-save'></i>
                                Save as Draft
                            </button>
                            <a href="{{ route('admin.product') }}" class="btn-discard">
                                <i class='bx bx-x'></i>
                                Discard Changes
                            </a>
                        </div>
                    </div>
                </div>

            </div>{{-- end .sidebar-col --}}

        </div>{{-- end .form-grid --}}
    </form>
    <form id="deleteGalleryForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ═══════════════════════════════════════════════
               HELPER — format number in Indian locale
            ═══════════════════════════════════════════════ */
            function inr(val, decimals) {
                return '₹' + val.toLocaleString('en-IN', {
                    minimumFractionDigits: decimals || 0,
                    maximumFractionDigits: decimals || 0
                });
            }

            /* ═══════════════════════════════════════════════
               1. SKU AUTO-GENERATE
            ═══════════════════════════════════════════════ */
            document.getElementById('btnGenerateSKU').addEventListener('click', function() {
                const rand = Math.floor(1000 + Math.random() * 9000);
                document.getElementById('skuField').value = 'SRF-' + rand;
                updateSummary();
            });

            /* ═══════════════════════════════════════════════
               2. PRICE CALCULATOR
               — MRP + Discount  →  Selling Price
               — MRP + Selling   →  Discount %
            ═══════════════════════════════════════════════ */
            const mrpField = document.getElementById('mrpField');
            const discountField = document.getElementById('discountField');
            const sellingField = document.getElementById('sellingPriceField');

            function calcPriceFromDiscount() {
                const mrp = parseFloat(mrpField.value) || 0;
                const discount = parseFloat(discountField.value) || 0;
                const selling = +(mrp - (mrp * discount / 100)).toFixed(2);
                const saving = +(mrp - selling).toFixed(2);

                sellingField.value = selling.toFixed(2);
                updatePricePreview(mrp, discount, selling, saving);
                updateSummary();
            }

            function calcDiscountFromPrice() {
                const mrp = parseFloat(mrpField.value) || 0;
                const selling = parseFloat(sellingField.value) || 0;

                if (mrp > 0 && selling >= 0 && selling <= mrp) {
                    const discount = +((mrp - selling) / mrp * 100).toFixed(1);
                    const saving = +(mrp - selling).toFixed(2);
                    discountField.value = discount;
                    updatePricePreview(mrp, discount, selling, saving);
                }
                updateSummary();
            }

            function updatePricePreview(mrp, discount, selling, saving) {
                document.getElementById('previewMRP').textContent = inr(mrp);
                document.getElementById('previewDiscount').textContent = discount + '%';
                document.getElementById('previewSelling').textContent = inr(selling, 2);
                document.getElementById('previewSaving').textContent = inr(saving, 2);
            }

            mrpField.addEventListener('input', calcPriceFromDiscount);
            discountField.addEventListener('input', calcPriceFromDiscount);
            sellingField.addEventListener('input', calcDiscountFromPrice);

            /* ═══════════════════════════════════════════════
               3. LIVE SUMMARY
            ═══════════════════════════════════════════════ */
            function updateSummary() {
                /* Elements */
                const nameEl = document.getElementById('productName');
                const skuEl = document.getElementById('skuField');
                const catEl = document.getElementById('productCategory');
                const fabricEl = document.getElementById('productFabric');
                const stockEl = document.getElementById('stockField');

                /* Derived text */
                const catText = catEl?.selectedIndex > 0 ?
                    catEl.options[catEl.selectedIndex].text :
                    '—';
                const fabricText = fabricEl?.selectedIndex > 0 ?
                    fabricEl.options[fabricEl.selectedIndex].text :
                    '—';

                const mrp = parseFloat(mrpField.value) || 0;
                const sp = parseFloat(sellingField.value) || 0;

                /* Update DOM */
                document.getElementById('sumName').textContent = nameEl.value.trim() || '—';
                document.getElementById('sumSKU').textContent = skuEl.value.trim() || '—';
                document.getElementById('sumCategory').textContent = catText;
                document.getElementById('sumFabric').textContent = fabricText;
                document.getElementById('sumMRP').textContent = mrp > 0 ? inr(mrp) : '—';
                document.getElementById('sumPrice').textContent = sp > 0 ? inr(sp, 2) : '—';
                document.getElementById('sumStock').textContent = stockEl.value ?
                    stockEl.value + ' units' :
                    '—';
            }

            /* Bind all summary-triggering fields */
            const summaryFields = ['productName', 'skuField', 'stockField'];
            summaryFields.forEach(function(id) {
                const el = document.getElementById(id);
                if (el) el.addEventListener('input', updateSummary);
            });

            const summarySELECTs = ['productCategory', 'productFabric'];
            summarySELECTs.forEach(function(id) {
                const el = document.getElementById(id);
                if (el) el.addEventListener('change', updateSummary);
            });

            /* ═══════════════════════════════════════════════
               4. NAME CHARACTER COUNTER
            ═══════════════════════════════════════════════ */
            document.getElementById('productName').addEventListener('input', function() {
                document.getElementById('nameCount').textContent = this.value.length;
            });

            /* ═══════════════════════════════════════════════
               5. SUBCATEGORY FILTER
            ═══════════════════════════════════════════════ */
            const categorySelect = document.getElementById('productCategory');
            const subcategorySelect = document.getElementById('productSubCategory');

            function filterSubcategories(reset = false) {

                const selectedCatId = categorySelect.value;

                Array.from(subcategorySelect.options).forEach(function(opt) {

                    if (opt.value === '') {
                        opt.style.display = '';
                        return;
                    }

                    opt.style.display =
                        opt.dataset.category == selectedCatId ?
                        '' :
                        'none';
                });

                // Only clear subcategory when user changes category
                if (reset) {
                    subcategorySelect.value = '';
                }
            }

            categorySelect.addEventListener('change', function() {
                filterSubcategories(true);
            });

            // Initial load
            filterSubcategories(false);

            /* ═══════════════════════════════════════════════
               6. TAGS INPUT
            ═══════════════════════════════════════════════ */
            const tagInput = document.getElementById('tagInput');
            const tagsWrap = document.getElementById('tagsWrap');
            const tagsHidden = document.getElementById('tagsHidden');
            let tags = [];

            // Pre-populate tags from old() value
            const oldTags = tagsHidden.value.trim();
            if (oldTags) {
                tags = oldTags.split(',').map(t => t.trim()).filter(Boolean);
                renderTags();
            }

            tagsWrap.addEventListener('click', function() {
                tagInput.focus();
            });

            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    const val = this.value.trim().replace(/,/g, '');
                    if (val && !tags.includes(val)) {
                        tags.push(val);
                        renderTags();
                    }
                    this.value = '';
                }
                if (e.key === 'Backspace' && this.value === '' && tags.length) {
                    tags.pop();
                    renderTags();
                }
            });

            function renderTags() {
                document.querySelectorAll('#tagsWrap .tag-item').forEach(el => el.remove());
                tags.forEach(function(t, i) {
                    const chip = document.createElement('span');
                    chip.className = 'tag-item';
                    chip.innerHTML = t +
                        '<button type="button" class="tag-remove" data-index="' + i + '">' +
                        '<i class="bx bx-x"></i></button>';
                    tagsWrap.insertBefore(chip, tagInput);
                });
                tagsHidden.value = tags.join(',');
            }

            tagsWrap.addEventListener('click', function(e) {
                const btn = e.target.closest('.tag-remove');
                if (btn) {
                    tags.splice(parseInt(btn.dataset.index), 1);
                    renderTags();
                }
            });

            /* ═══════════════════════════════════════════════
               7. IMAGE PREVIEWS
            ═══════════════════════════════════════════════ */

            /* Main image */
            function previewMainImage(input) {
                if (!input.files || !input.files[0]) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('mainUploadPlaceholder').style.display = 'none';
                    const wrap = document.getElementById('mainImagePreviewWrap');
                    wrap.style.display = 'block';
                    wrap.style.pointerEvents = 'none';
                    document.getElementById('mainImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }

            document.getElementById('mainImageInput').addEventListener('change', function() {
                previewMainImage(this);
            });

            /* Gallery images */
            document.getElementById('galleryInput').addEventListener('change', function() {
                const grid = document.getElementById('galleryPreviewGrid');
                const files = Array.from(this.files).slice(0, 8);

                files.forEach(function(file, idx) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrap = document.createElement('div');
                        wrap.className = 'img-preview-wrap';
                        wrap.innerHTML =
                            '<img src="' + e.target.result + '" alt="Gallery ' + (idx + 1) +
                            '">' +
                            '<button class="img-remove" type="button"><i class="bx bx-x"></i></button>' +
                            (idx === 0 ? '<span class="img-main-badge">1st</span>' : '');

                        wrap.querySelector('.img-remove').addEventListener('click', function() {
                            wrap.remove();
                        });

                        grid.appendChild(wrap);
                    };
                    reader.readAsDataURL(file);
                });
            });

            /* Drag-and-drop visual feedback */
            ['mainImageZone', 'galleryZone'].forEach(function(id) {
                const zone = document.getElementById(id);
                if (!zone) return;
                zone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    zone.classList.add('dragover');
                });
                zone.addEventListener('dragleave', function() {
                    zone.classList.remove('dragover');
                });
                zone.addEventListener('drop', function() {
                    zone.classList.remove('dragover');
                });
            });

            /* ═══════════════════════════════════════════════
               INIT — run summary once to reflect old() values
            ═══════════════════════════════════════════════ */
            updateSummary();
            calcPriceFromDiscount();

        }); // end DOMContentLoaded

        function deleteGalleryImage(id) {

            if (!confirm('Delete this image?')) {
                return;
            }

            let form = document.getElementById('deleteGalleryForm');

            form.action = `/admin/product/gallery-image/${id}`;

            form.submit();
        }
    </script>
@endpush

@extends('layouts.app')

@section('title')
New Order
@endsection

@section('content')

<div class="container mt-5">
    @foreach ($tables->chunk(3) as $tableGroup)
    <div class="row mb-4">
        @foreach ($tableGroup as $table)
        <div class="col-md-4 mb-3">
            <a href="{{ $table->order_id != null ? 'edit-order/' . $table->order_id : 'new-order/'. $table->id }}">
                <div class="card table-card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="table-icon mb-3">
                            <i class="fas fa-utensils fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Table #{{ $table->table_no }}</h3>

                        @if($table->order_id != null )
                        <span class="badge bg-danger">Occupied</span>
                        @else
                        <span class="badge bg-success">Available</span>
                        @endif

                        <div class="mt-3">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endforeach
</div>

<style>
    .table-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }

    .table-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .table-icon {
        color: #6c757d;
        opacity: 0.8;
    }

    .badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 50px;
    }
</style>

<!-- Make sure you have Font Awesome for the icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

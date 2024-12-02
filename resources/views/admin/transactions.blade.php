@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 text-primary">User Transactions</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Transaction ID</th>
                    <th>User Name</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>
                        <!-- Menampilkan detail produk yang ada dalam JSON items -->
                        @foreach (json_decode($transaction->items) as $item)
                            <p><strong>{{ $item->product_name ?? 'Unknown Product' }}</strong> - Qty: {{ $item->quantity }} - Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        @if ($transaction->status == 'completed')
                            <span class="badge badge-success">Completed</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <!-- Tombol Submit untuk menyelesaikan transaksi -->
                        @if ($transaction->status == 'pending')
                            <form action="{{ route('admin.transactions.submit', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

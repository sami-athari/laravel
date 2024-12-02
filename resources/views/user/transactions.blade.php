@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 text-primary">User Transactions</h1>

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
                    <td>{{ $transaction->product_name }}</td>
                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        @if ($transaction->status == 'completed')
                            <span class="badge badge-success">Completed</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
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

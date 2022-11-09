@extends('layouts.front')

@section('main')
    <div class="container">
        <h1>Customers Database</h1>

        <table class="table table-hover" id="flightCustomers">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Country</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($flights as $flight)
                    <tr>
                        <th scope="row">{{ $flight->id }}</th>
                        <td>{{ $flight->cust_name }}</td>
                        <td>{{ $flight->cust_email }}</td>
                        <td>{{ $flight->cust_phone }}</td>
                        <td>{{ $flight->cust_address }}</td>
                        <td>{{ $flight->cust_country }}</td>
                    </tr>

                @empty
                    <h2>No flights</h2>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#flightCustomers').DataTable();
        });
    </script>
@endpush

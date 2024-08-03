<!-- resources/views/water/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Water Consumption</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Water Meter Management</h3>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Meter Status:</strong> <span id="meter-status">{{ $latestStatus ? 'ON' : 'OFF' }}</span></p>
                    <p class="card-text"><strong>Total Units:</strong> <span id="total-units">{{ $totalUnits }}</span></p>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('water.updateStatus') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="btn btn-success">TURN ON</button>
                    </form>
                    <form action="{{ route('water.updateStatus') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="0">
                        <button type="submit" class="btn btn-danger">TURN OFF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Consumption Records</h5>
            <table class="table table-bordered" id="consumption-table">
                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Units Consumed</th>
                </tr>
                </thead>
                <tbody>
                <!-- Data will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function fetchData() {
        $.ajax({
            url: '{{ route('water.getData') }}',
            method: 'GET',
            success: function(data) {
                // Update the meter status
                $('#meter-status').text(data.latestStatus ? 'ON' : 'OFF');
                
                // Update the total units
                $('#total-units').text(data.totalUnits);
                
                // Update the table with new data
                let tableBody = $('#consumption-table tbody');
                tableBody.empty();
                data.consumptions.forEach(function(consumption) {
                    tableBody.append(`
                        <tr>
                            <td>${consumption.id}</td>
                            <td>${consumption.name}</td>
                            <td>${consumption.address}</td>
                            <td>${consumption.units_consumed}</td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Fetch data initially and then periodically
    fetchData();
    setInterval(fetchData, 5000); // Fetch data every 5 seconds
</script>
</body>
</html>

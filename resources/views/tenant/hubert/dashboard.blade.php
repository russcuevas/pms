<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Huberts Dashboard</title>
</head>
<body>
    <h1>Huberts Residence</h1>
    <p>Welcome, {{ $tenant->fullname }}</p>
    <p>Your Property: {{ $property->property_name }} (ID: {{ $tenant->property_id }})</p>
    <p>Your Unit: {{ $unit->units_name }} (Unit ID: {{ $tenant->unit_id }})</p>
    <a href="{{ route('tenants.logout.request') }}">Logout</a>
</body>
</html>

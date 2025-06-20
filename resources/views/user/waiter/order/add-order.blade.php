@extends('layouts.app')

@section('title')
New Order
@endsection

@section('content')
<div id="vueApp">
    <!-- Your Vue app content will be rendered here -->
</div>

<script>
    window.componentName = 'pos'; // Set the name of the component here dynamically
        window.table_id = {{ $table_id  }}; // Default to table ID 2 if $table_id isn't provided
        window.initialSelectedTableId = $table_id; // Explicitly set to table ID 2
</script>
@endsection

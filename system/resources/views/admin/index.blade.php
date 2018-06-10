@extends('layouts.admin')

@section('content')
<div id="app">
    <wp-license-server></wp-license-server>
</div>
<script type="text/javascript">
    var wplsPackages = @json($packages);
</script>
@endsection
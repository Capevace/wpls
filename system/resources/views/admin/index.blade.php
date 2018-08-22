@extends('layouts.admin')

@section('content')
<div id="app">
    <wp-license-server></wp-license-server>
</div>
<script type="text/javascript">
    var wplsPackages    = @json($packages);
    var wplsNeedsUpdate = @json($needsUpdate);
    var wplsUpdateLink  = @json(route('update:index'));
    var wplsVersion     = @json($version);
</script>
@endsection
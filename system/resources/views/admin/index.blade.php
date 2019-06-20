@extends('layouts.admin')

@section('content')
<div id="app">
    <wp-license-server></wp-license-server>
</div>
<script type="text/javascript">
    var wplsPackages    = @json($packages);
    var wplsNeedsUpdate = @json($needsUpdate);
<<<<<<< HEAD
    var wplsUpdateLink  = '';
    var wplsVersion     = @json($version);
=======
    var wplsUpdateLink = '';
>>>>>>> renew
</script>
@endsection
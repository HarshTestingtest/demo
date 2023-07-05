@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
    <button type="button" class="close" onclick="this.parentElement.style.display='none'" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('danger'))
<div class="alert alert-danger" role="alert">
    {{ session('danger') }}
    <button type="button" class="close" onclick="this.parentElement.style.display='none'" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">500</div>
                <div class="panel-body">
                  <h3><i class="fa fa-warning text-red"></i> Oops! Ada Masalah Di Server.</h3>
                    <br>
                    <details>
                      <summary>Detail Error : </summary>
                      <p>{{ $exception->getMessage() }}</p>
                    </details>
                    <p>
                      Coba refresh halaman dan hubungi admin atau
                      <a href="{{ url('home') }}">kembali ke dashboard</a>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection


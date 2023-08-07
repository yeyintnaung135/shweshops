<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$slot}}</h1>
            </div>
            <div class="col-sm" style="margin-right: 25px;margin-left: 8px;">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{$slot}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

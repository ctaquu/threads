@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1>Threads</h1>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>data</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (ee) {

            $token = localStorage.getItem('token');

            $.ajax({
                url: "/api" + window.location.pathname + "?token=" + $token,
                type: "GET"
            })
                .done(function (data) {
                    console.log(data);
                })
                .fail(function (e, x, m) {
                })
                .always(function () {
                });

        });
    </script>
@endsection

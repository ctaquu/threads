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
                        <ul id="thread_list">
                            <li>one</li>
                            <li>two</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (ee) {

            $.ajax({
                url: "api/threads?token=" + localStorage.getItem('token'),
                type: "GET"
            })
                .done(function (data) {

                    $.each( data.content.threads, function( key, thread ) {
                        $(" #thread_list ").append(
                            '<a href="">' + thread.title + '</a>'
                        );
                    });
                })
                .fail(function (e, x, m) {
                    window.location.replace("login");
                })
                .always(function () {
                });

        });
    </script>
@endsection

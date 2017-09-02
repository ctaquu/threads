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
                        <h3>add new thread</h3>
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-4 control-label">desc</label>

                            <div class="col-md-6">
                                <input id="desc" type="text" class="form-control" name="desc"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <input id="btn_submit" type="submit" class="btn btn-primary" value="Login">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul id="thread_list">
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

            $token = localStorage.getItem('token');

            $.ajax({
                url: "api/threads?token=" + $token,
                type: "GET"
            })
                .done(function (data) {

                    $.each(data.content.threads, function (key, thread) {
                        $(" #thread_list ").append(
                            '<li><a class="thread_one" href="threads/' + thread.id + '">' + thread.title + '</a></li>'
                        );
                    });
                })
                .fail(function (e, x, m) {
                    window.location.replace("login");
                })
                .always(function () {
                });

            $(" #btn_submit ").click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "api/threads",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "title": $(" #title ").val(),
                        "desc": $(" #desc ").val(),
                        "token": $token
                    }
                })
                    .done(function (data) {
                        window.location.replace("");
                    })
                    .fail(function (e, x, m) {
                    })
                    .always(function () {
                    });
            });

        });
    </script>
@endsection

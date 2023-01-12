@extends('layouts.student')
@section('title', 'Exams')
@section('content')
    <style type="text/css">
        .question_options>li {
            list-style: none;
            height: 40px;
            line-height: 40px;
        }
    </style>
    <!-- /.content-header -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exams</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Exam</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Default box -->
                            <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h3 class="text-center">Time : {{ $exam->exam_duration }} min</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <h3><b>Timer</b> : <span class="js-timeout"
                                                    id="timer">{{ $exam['exam_duration'] }}:00</span></h3>
                                        </div>

                                        <div class="col-sm-4">
                                            <h3 class="text-right"><b>Status</b> :Running</h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mt-4">

                                        <div class="card-body">

                                            <form action="{{ url('student/submit_questions') }}" method="POST">
                                                <input type="hidden" name="exam_id" value="{{ Request::segment(3) }}">
                                                {{ csrf_field() }}
                                                <div class="row">

                                                    @foreach ($question as $key => $q)
                                                        <div class="col-sm-12 mt-4 question "
                                                            id="question_{{ $key }}" style="display: none;">
                                                            <p>{{ $key + 1 }}. {{ $q->questions }}</p>
                                                            <?php

                                                            $options = json_decode($q->options);
                                                            ?>
                                                            <input type="hidden" name="question{{ $key + 1 }}"
                                                                value="{{ $q['id'] }}">


                                                            <ul class="question_options">
                                                                <li><input type="radio" value="{{ $options->option1 }}"
                                                                        name="ans{{ $key + 1 }}">
                                                                    {{ $options->option1 }}
                                                                </li>
                                                                <li><input type="radio" value="{{ $options->option2 }}"
                                                                        name="ans{{ $key + 1 }}">
                                                                    {{ $options->option2 }}
                                                                </li>
                                                                <li><input type="radio" value="{{ $options->option3 }}"
                                                                        name="ans{{ $key + 1 }}">
                                                                    {{ $options->option3 }}
                                                                </li>
                                                                <li><input type="radio" value="{{ $options->option4 }}"
                                                                        name="ans{{ $key + 1 }}">
                                                                    {{ $options->option4 }}
                                                                </li>

                                                                <li style="display: none;"><input value="0"
                                                                        type="radio" checked="checked"
                                                                        name="ans{{ $key + 1 }}">
                                                                    {{ $options->option4 }}</li>
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="index" value="{{ $key + 1 }}">
                                                        <button type="button" class="btn btn-primary previous"
                                                            onclick="previous(this)">Previous</button>
                                                        <button type="button" class="btn btn-primary next"
                                                            onclick="next(this)">Next</button>
                                                        <button type="submit" class="btn btn-primary submit" id="myCheck"
                                                            style="display: none;">Submit</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @foreach ($question as $key => $q)
                                                        <button class="btn btn-default"
                                                            onclick="show({{ $key }})">
                                                            {{ $key + 1 }}</button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-header -->

        <!-- Modal -->

    @endsection
    @section('js')

        <script>
            var currentQuestion = parseInt(localStorage.getItem("question") != undefined || localStorage.getItem("question") !=
                null ?
                localStorage.getItem("question") : 0);

            function show(question = 0) {

                localStorage.setItem("question", question);
                $(".question").hide();
                ques = document.getElementById('question_' + question);
                ques.style.display = 'block';
                currentQuestion = question;
                checkOptionColor(question);

            }
            show(parseInt(currentQuestion));


            function next(t) {

                if (currentQuestion >= parseInt($(".question").length - 1)) {

                    $(".next").prop('disabled', true);
                    $(".submit").show();

                } else {
                    show(currentQuestion + 1);
                }
                $(".previous").prop('disabled', false);
            }

            function previous(t) {
                if (currentQuestion < 1) {
                    $(".previous").prop('disabled', true);
                } else {
                    show(currentQuestion - 1);
                }
                $(".next").prop('disabled', false);
            }


            function checkOptionColor(question) {
                console.log($("#question_" + question).find("input[type=radio]:checked").attr('name'));
                // $($(this).find("input[type=radio]:checked")).attr('id')
            }
        </script>

    @endsection

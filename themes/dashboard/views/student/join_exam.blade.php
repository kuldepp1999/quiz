@extends('layouts.student')
@section('title', 'Exams')
@section('head')
    <style>
        .btn:hover {
            color: #ffffff;
            background-color: #2a2a81;
        }

        .tabs {
            cursor: pointer;
            font-weight: bold;
            height: 35px;
            margin: 5px 6px;
            padding-top: 7px;
            text-align: center;
            width: 9%;
            background-color: rgb(219 219 219);
            border-radius: 50px;
            color: #101ba6;
            border: none;
        }



        .all_tabs {
            /* height: 212px; */
            max-height: 184px;
            overflow: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .colors {

            width: 24px;
            height: 24px;
        }

        .tabs-color {
            display: flex;
            gap: 10px;
        }
    </style>
@endsection
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

                                <!-- Begin container -->
                                <div class="container">

                                    <div class="card shadow rounded border-info pb-0" style="padding: 16px;">
                                        <div class="row">
                                            <div class="tabs-color col-md-3">
                                                <div class="colors" style=" background-color: rgb(162, 165, 161);">&nbsp;
                                                </div>
                                                <p>Not Visited</p>
                                            </div>
                                            <div class="tabs-color col-md-3">
                                                <div class="colors" style="background-color: #076407;">&nbsp;</div>
                                                <p>Answered</p>
                                            </div>
                                            <div class="tabs-color col-md-3">
                                                <div class="colors" style="background-color: #760976;">&nbsp;</div>
                                                <p>bookmarked</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin: 20px 0;">
                                        <nav class="navbar navbar-expand-md navbar-light "
                                            style="    background-color: #101ba6; color:#fff">
                                            <a class="nav-link text-primary" id="navhighscorelink"></a>
                                            <spam>Welcome : {{ auth()->user()->name }}</spam>
                                            <span class="ml-auto" id="timer"></span>
                                        </nav>
                                    </div>
                                    <!-- Begin card -->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card shadow rounded border-info">
                                                <!-- Begin body -->
                                                <div class="card-body">


                                                    <div class="row">
                                                        <div class="col-md-10">

                                                            <div id="mainContent">

                                                                <form action="{{ url('student/submit_questions') }}"
                                                                    method="POST">
                                                                    <input type="hidden" name="exam_id"
                                                                        value="{{ Request::segment(3) }}">
                                                                    {{ csrf_field() }}
                                                                    <div class="row">

                                                                        @foreach ($question as $key => $q)
                                                                            <div class="col-sm-12 mt-4 questionQ question_{{ $key }}"
                                                                                style="display: none;"
                                                                                id="question_{{ $key }}">
                                                                                <button
                                                                                    class="float-right btn-sm btn btn-default"
                                                                                    onclick="bookmark({{ $key }})"
                                                                                    type="button"><i
                                                                                        class="fa fa-bookmark"></i>
                                                                                    Bookmark</button>
                                                                                <h5>{{ $key + 1 }}.
                                                                                    {{ $q->questions }}</h5>
                                                                                <?php
                                                                                
                                                                                $options = json_decode($q->options);
                                                                                ?>
                                                                                <input type="hidden"
                                                                                    name="question{{ $key + 1 }}"
                                                                                    value="{{ $q['id'] }}">


                                                                                <ul class="question_options">
                                                                                    <li><input type="radio"
                                                                                            value="{{ $options->option1 }}"
                                                                                            name="ans{{ $key + 1 }}">
                                                                                        {{ $options->option1 }}
                                                                                    </li>
                                                                                    <li><input type="radio"
                                                                                            value="{{ $options->option2 }}"
                                                                                            name="ans{{ $key + 1 }}">
                                                                                        {{ $options->option2 }}
                                                                                    </li>
                                                                                    <li><input type="radio"
                                                                                            value="{{ $options->option3 }}"
                                                                                            name="ans{{ $key + 1 }}">
                                                                                        {{ $options->option3 }}
                                                                                    </li>
                                                                                    <li><input type="radio"
                                                                                            value="{{ $options->option4 }}"
                                                                                            name="ans{{ $key + 1 }}">
                                                                                        {{ $options->option4 }}
                                                                                    </li>

                                                                                    <li style="display: none;"><input
                                                                                            value="0" type="radio"
                                                                                            checked="checked"
                                                                                            name="ans{{ $key + 1 }}">
                                                                                        {{ $options->option4 }}</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <button type="button"
                                                                                    class="btn btn-primary previous question_{{ $key }} question"
                                                                                    onclick="previous({{ $key }})"
                                                                                    style="display: none;">Previous</button>
                                                                                <button type="button"
                                                                                    class="btn btn-primary next question_{{ $key }} question"
                                                                                    onclick="next({{ $key }})"
                                                                                    style="display: none;">Next</button>
                                                                            </div>
                                                                        @endforeach
                                                                        <input type="hidden" name="index"
                                                                            value="{{ $key + 1 }}"
                                                                            class="question_{{ $key }}">
                                                                        <div
                                                                            style="display: flex;justify-content: center;margin:auto;">
                                                                            <button type="submit"
                                                                                class="btn bg-primary text-white rounded-pill mb-2  submit text-center"
                                                                                id="myCheck" style="display: none;"
                                                                                class="">Submit</button>
                                                                        </div>

                                                                    </div>
                                                                </form>


                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card shadow rounded border-info">
                                                <div class="container-fluid "
                                                    style="padding: 0 16px;background-color: #f9f9f9;">
                                                    <div class="row mt-2 all_tabs">
                                                        <!-- <div class="col "> -->
                                                        @foreach ($question as $key => $q)
                                                            <button class=" tabs questionQuickBtn_{{ $key }}"
                                                                onclick="show({{ $key }})"
                                                                style="color:#a2a5a1;color:black;">
                                                                {{ $key + 1 }}</button>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <br>
                                <!-- End main -->
                            

                            {{-- <div class="row">
                                <div class="col-md-8">
                                    <div class="card mt-4">

                                        <div class="card-body">

                                            <form action="{{ url('student/submit_questions') }}" method="POST">
                                                <input type="hidden" name="exam_id" value="{{ Request::segment(3) }}">
                                                {{ csrf_field() }}
                                                <div class="row">

                                                    @foreach ($question as $key => $q)
                                                        <div class="col-sm-12 mt-4 questionQ question_{{ $key }}"
                                                             style="display: none;" id="question_{{ $key }}">
                                                             <button class="float-right btn-sm btn btn-default" onclick="bookmark({{ $key }})" type="button"><i class="fa fa-bookmark"></i> Bookmark</button>
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
                                                        <div class="col-sm-12">                                                            
                                                            <button type="button" class="btn btn-primary previous question_{{ $key }} question"
                                                                onclick="previous({{ $key }})" style="display: none;">Previous</button>
                                                            <button type="button" class="btn btn-primary next question_{{ $key }} question"
                                                                onclick="next({{ $key }})"  style="display: none;">Next</button>                                                           
                                                        </div>
                                                    @endforeach
                                                    <input type="hidden" name="index" value="{{ $key + 1 }}" class="question_{{ $key }}">
                                                    <div style="display: flex;justify-content: center;margin:auto;">
                                                        <button type="submit" class="btn btn-primary submit text-center" id="myCheck" style="display: none;">Submit</button>
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
                                                        <button class="btn btn-default questionQuickBtn_{{ $key }}"
                                                            onclick="show({{ $key }})">
                                                            {{ $key + 1 }}</button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

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
            var QuestionArray = [{
                bgcolor: 'white',
                question_id: 0
            }];
            // var currentQuestion = parseInt(localStorage.getItem("question") != undefined || localStorage.getItem("question") !=
            //     null ?
            //     localStorage.getItem("question") : 0);
            var currentQuestion = 0;

            function show(question = 0, color = true) {
                console.log(question);
                console.log(parseInt($(".questionQ").length - 1));
                localStorage.setItem("question", question);
                $(".questionQ").hide();
                $(".question").hide();
                ques = $('.question_' + question).show();
                currentQuestion = question;
                if (color && parseInt($(".questionQ").length - 1) < question) {
                    // checkOptionColor(question);    
                }

            }
            show(parseInt(currentQuestion), false);


            function next(currentQuestion, color = true) {
                if (color) {
                    checkOptionColor(currentQuestion);
                }

                if (currentQuestion >= parseInt($(".questionQ").length - 1)) {
                    $(".next").prop('disabled', true);
                    $(".submit").show();
                } else {
                    $(".submit").hide();
                    show(currentQuestion + 1, false);
                }
                $(".previous").prop('disabled', false);
            }

            function previous(currentQuestion) {
                if (currentQuestion >= parseInt($(".questionQ").length - 1)) {
                    $(".next").prop('disabled', true);
                    $(".submit").show();
                } else {
                    $(".submit").hide();
                }
                checkOptionColor(currentQuestion - 1);
                if (currentQuestion < 1) {
                    $(".previous").prop('disabled', true);
                } else {
                    show(currentQuestion - 1, false);
                }
                $(".next").prop('disabled', false);
            }

            function checkOptionColor(question) {
                // alert(question);
                if ($("#question_" + question).find('input:checked').val() == 0) {
                    // $(".questionQuickBtn_"+ question).css('background','red');
                    $(".questionQuickBtn_" + question).css('color', 'black');
                } else {
                    $(".questionQuickBtn_" + question).css('background', '#076407');
                    $(".questionQuickBtn_" + question).css('color', 'white');
                }

            }

            function bookmark(question) {
                $(".questionQuickBtn_" + question).css('background', 'rgb(118 9 118)');
                $(".questionQuickBtn_" + question).css('color', 'white');
                next(question, false);
            }
            // 
            // window.onbeforeunload = function() {
            //     return "Dude, are you sure you want to leave? Think of the kittens!";
            // }
            function disableF5(e) {
                if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
            };

            $(document).ready(function() {
                $(document).on("keydown", disableF5);
            });
        </script>

    @endsection

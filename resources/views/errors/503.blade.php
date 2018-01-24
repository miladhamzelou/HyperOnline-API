<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>آرش حاتمی</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('errors/css/style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('errors/css/iransans.css') }}"/>
    <script type="text/javascript" src="{{ asset('errors/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('errors/js/wordsearch-resize.js') }}"></script>
    <script type="text/javascript">$(function () {
            $(this).delay(250).queue(function () {
                $(".one").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".two").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".three").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".four").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".five").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".six").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".seven").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".eight").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".nine").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".ten").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".eleven").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".twelve").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".thirteen").addClass("selected");
                $(this).dequeue();
            }).delay(350).queue(function () {
                $(".fourteen").addClass("selected");
                $(this).dequeue();
            })
        });</script>
</head>
<body>
<noscript>
    <div id="noscript-warning">This site works best with Javascript enabled, as you can plainly see.</div>
</noscript>
<div id="wrap">
    <div id="wordsearch">
        <ul>
            <li>f</li>
            <li>f</li>
            <li>m</li>
            <li>o</li>
            <li>z</li>
            <li>s</li>
            <li>e</li>
            <li>o</li>
            <li>d</li>
            <li>c</li>
            <li>j</li>
            <li>w</li>
            <li class="one">5</li>
            <li class="two">0</li>
            <li class="three">3</li>
            <li>w</li>
            <li>e</li>
            <li>x</li>
            <li>l</li>
            <li>i</li>
            <li>y</li>
            <li>e</li>
            <li>w</li>
            <li>g</li>
            <li class="four">s</li>
            <li class="five">e</li>
            <li class="six">r</li>
            <li class="seven">v</li>
            <li class="eight">i</li>
            <li class="nine">c</li>
            <li class="ten">e</li>
            <li>k</li>
            <li>f</li>
            <li>n</li>
            <li>o</li>
            <li>t</li>
            <li>w</li>
            <li>t</li>
            <li>q</li>
            <li>e</li>
            <li>a</li>
            <li>c</li>
            <li>a</li>
            <li class="eleven">d</li>
            <li class="twelve">o</li>
            <li class="thirteen">w</li>
            <li class="fourteen">n</li>
            <li>n</li>
            <li>c</li>
            <li>f</li>
            <li>o</li>
            <li>u</li>
            <li>n</li>
            <li>d</li>
            <li>q</li>
            <li>y</li>
            <li>k</li>
            <li>g</li>
            <li>d</li>
            <li>c</li>
            <li>w</li>
            <li>j</li>
            <li>k</li>
            <li>v</li>
        </ul>
    </div>
    <div id="main-content">
        <h1 style="text-align: center">متاسفم</h1>
        <p style="direction: rtl;text-align: center">وب سایت به علت " {{ $exception->getMessage() }} " موقتا در دسترس نمی باشد. به زودی با شما خواهیم بود.</p>
        <div id="navigation" style="text-align: center">
            <a class="navigation" href="{{ url('/') }}">خانه</a>
        </div>
    </div>
</div>
</body>
</html>
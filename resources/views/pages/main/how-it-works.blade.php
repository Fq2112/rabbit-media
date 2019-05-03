<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>How It Works | Rabbit Media – Digital Creative Service</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300i,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style>
        /*==========  Global  ==========*/
        /*==========  Basics  ==========*/
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 15px;
            line-height: 26px;
            background: #241837;
            color: #d8beff;
            font-family: 'Josefin Sans', sans-serif;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        body::-webkit-scrollbar-track {
            background: rgba(222, 222, 222, .75);
        }

        body::-webkit-scrollbar {
            width: 8px;
            background-color: #F5F5F5;
        }

        body::-webkit-scrollbar-thumb {
            width: 8px;
            background: rgba(0, 0, 0, .5);
            border-radius: 5px;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        body::-webkit-scrollbar-thumb:hover {
            background: rgba(49, 40, 85, .8);
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        body::-webkit-scrollbar-thumb:active {
            background: rgba(49, 40, 85, 1);
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        a {
            color: #d8beff;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        a:hover {
            color: #592f83;
            text-decoration: none;
        }

        /*==========  Sections  ==========*/
        .header {
            position: relative;
            background-color: black;
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .header video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: 0;
            -ms-transform: translateX(-50%) translateY(-50%);
            -moz-transform: translateX(-50%) translateY(-50%);
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        .header .container {
            position: relative;
            z-index: 2;
        }

        .header .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: black;
            opacity: 0.5;
            z-index: 1;
        }

        @media (pointer: coarse) and (hover: none) {
            .header {
                background: url({{asset('images/how-it-works/bg.JPG')}}) black no-repeat center center scroll;
            }

            .header video {
                display: none;
            }
        }

        .header .page-title {
            padding: 0 30px 0 30px;
            font-size: 3rem;
            line-height: 2em;
            letter-spacing: 10px;
            color: #FFF;
        }

        .header .page-title:after {
            content: "";
            left: 0;
            bottom: 0;
            position: absolute;
            width: 100px;
            height: 1px;
            background: #000;
        }

        .header .page-title.text-center:after {
            content: "";
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            content: "";
            left: 50%;
            bottom: 0;
            top: 33%;
            position: absolute;
            width: 100px;
            height: 1px;
            background: #fff;
        }

        .header .page-description {
            margin: 0 auto;
            max-width: 46rem;
            font-size: 1.25rem;
            line-height: 2em;
            color: #FFF;
        }

        .header button {
            font-size: 15px;
            margin-top: 2rem;
            letter-spacing: 5px;
            font-weight: 600;
            color: #fff;
            border-color: #fff;
        }

        .main-content {
            margin: 0 auto;
            position: relative;
        }

        .main-content .section-inner,
        .main-content .post-wrapper {
            *zoom: 1;
        }

        .main-content .section-inner:before,
        .main-content .post-wrapper:before,
        .main-content .section-inner:after,
        .main-content .post-wrapper:after {
            content: "";
            display: table;
        }

        .main-content .section-inner:after,
        .main-content .post-wrapper:after {
            clear: both;
        }

        .footer {
            background: #241837;
            padding: 6.5rem 0;
            position: relative;
            z-index: 1;
        }

        .footer .good-bye {
            text-align: center;
            font-size: 18px;
            line-height: 36px;
        }

        .footer .good-bye p {
            display: block;
            clear: both;
        }

        .section .section-inner {
            margin: 0 auto;
            width: 1024px;
        }

        @media only screen {
            .section .section-inner {
                width: auto;
                max-width: 1024px;
            }
        }

        /*==========  Stem  ==========*/
        .stem-wrapper {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 50%;
        }

        .stem-wrapper.color-blue .stem-background {
            background: #17a2b8;
        }

        .stem-wrapper.color-green .stem-background {
            background: #35C189;
        }

        .stem-wrapper.color-red .stem-background {
            background: #fa5555;
        }

        .stem-wrapper .stem,
        .stem-wrapper .stem-background {
            position: absolute;
            top: 0;
            left: -30px;
            width: 60px;
        }

        .stem-wrapper .stem {
            background: #592f83;
            height: 100%;
        }

        .stem-wrapper .stem-background {
            background: #17a2b8;
            height: 50%;
            transition-duration: 0.5s;
        }

        .stem-padding {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            background: transparent url({{asset('images/how-it-works/stem-mask.png')}}) repeat-y top center;
        }

        /*==========  Post wrapper ==========*/
        .post-wrapper {
            *zoom: 1;
        }

        .post-wrapper:before,
        .post-wrapper:after {
            content: "";
            display: table;
        }

        .post-wrapper:after {
            clear: both;
        }

        .post-wrapper .post {
            position: relative;
            width: 432px;
            padding: 0 0 60px 0;
            clear: both;
            opacity: 1;
            -webkit-perspective: 1000px;
            perspective: 1000px;
        }

        .post-wrapper .post.hidden .post-content {
            -webkit-transform: translateY(100px) rotateX(30deg);
            transform: translateY(100px) rotateX(30deg);
            opacity: 0;
        }

        .post-wrapper .post:hover .post-content,
        .post-wrapper .post.active .post-content {
            opacity: 1;
        }

        .post-wrapper .post:hover .post-content .meta,
        .post-wrapper .post.active .post-content .meta {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }

        .image-right {
            float: right;
            margin-left: 1rem;
        }

        .image-left {
            float: left;
            margin-right: 1rem;
        }

        .post-wrapper .post:nth-child(even) {
            float: right;
        }

        .post-wrapper .post:nth-child(odd) {
            float: left;
        }

        .post-wrapper .post:nth-child(even) .stem-overlay {
            left: -110px;
        }

        .post-wrapper .post:nth-child(odd) .stem-overlay {
            right: -110px;
        }

        .post-wrapper .post.music-icon .stem-overlay .icon {
            background-image: url({{asset('images/how-it-works/music-icon.png')}});
        }

        .post-wrapper .post.bitbucket-icon .stem-overlay .icon {
            background-image: url({{asset('images/how-it-works/bitbucket-icon.png')}});
        }

        .post-wrapper .post.m-icon .stem-overlay .icon {
            background-image: url({{asset('images/how-it-works/m-icon.png')}});
        }

        .post-wrapper .post.twitter-icon .stem-overlay .icon {
            background-image: url({{asset('images/how-it-works/twitter-icon.png')}});
        }

        .post-wrapper .post.scroll-to-top .stem-overlay .icon {
            background-image: url({{asset('images/how-it-works/scroll-to-top-icon.png')}});
        }

        .post-wrapper .post .stem-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 60px;
        }

        .post-wrapper .post .stem-overlay .icon {
            background: transparent no-repeat center center;
            height: 60px;
            width: 60px;
            cursor: pointer;
        }

        .post-wrapper .post .stem-overlay .stem-mask {
            position: absolute;
            top: 60px;
            bottom: 0;
            left: 0;
            right: 0;
            background: transparent url({{asset('images/how-it-works/stem-mask.png')}}) repeat-y top center;
        }

        .post-wrapper .post .post-content {
            opacity: 0.3;
            transition-duration: 0.4s;
            -webkit-transform: none;
            transform: none;
        }

        .post-wrapper .post .post-content .meta {
            color: rgba(255, 255, 255, 0.3);
            margin: 0 0 15px 0;
            letter-spacing: 1px;
            opacity: 0;
            transition-duration: 1s;
            transition-delay: 0.2s;
            -webkit-transform: translateY(-5px);
            transform: translateY(-5px);
        }

        .post-wrapper .post .post-content .post-title {
            font-size: 32px;
            line-height: 42px;
            margin: 0 0 15px 0;
        }

        /*==========  Media queries  ==========*/
        @media only screen and (max-width: 1080px) {
            .main-content,
            .main-content .section-inner {
                max-width: none;
            }

            .stem-wrapper {
                left: 80px;
            }

            .stem-padding {
                margin: 0;
                float: left;
                margin-left: 50px;
            }

            .post-wrapper .post,
            .post-wrapper .post:nth-child(even),
            .post-wrapper .post:nth-child(odd) {
                width: auto;
                margin-left: 110px;
                float: none;
            }

            .post-wrapper .post .stem-overlay,
            .post-wrapper .post:nth-child(even) .stem-overlay,
            .post-wrapper .post:nth-child(odd) .stem-overlay {
                left: -60px;
                right: auto;
            }

            .post-wrapper .post .post-content {
                padding: 0 50px;
            }
        }

        @media only screen and (max-width: 700px) {
            .header .page-title {
                font-size: 2rem;
            }

            .header .page-title.text-center:after {
                top: 12%;
            }

            .post-wrapper .post {
                margin-left: 90px !important;
            }

            .post-wrapper .post .post-content {
                padding: 0 25px;
            }

            .stem-wrapper {
                left: 60px;
            }

            .stem-padding {
                margin-left: 30px;
            }
        }

        .clearfix {
            *zoom: 1;
        }

        .clearfix:before,
        .clearfix:after {
            content: "";
            display: table;
        }

        .clearfix:after {
            clear: both;
        }

        .progress {
            position: fixed;
            margin-bottom: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            border-radius: 0;
            z-index: 20;
            background-color: rgba(222, 222, 222, 0.75);
        }

        .progress .bar {
            height: 100%;
            width: 10%;
            background: #592f83;
            transition: background 0.15s ease;
        }

        .bullet {
            display: inline;
            margin: 0 4px;
            color: #d8beff;
            text-shadow: 0 0 4px #592f83;
        }

        .bullet:after {
            content: '\2022';
        }

        .nicescroll-rails {
            width: 8px !important;
        }

        #particles-js canvas {
            display: block;
            vertical-align: bottom;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            background: transparent;
        }
    </style>
</head>
<body class="use-nicescroll">

<header class="header">
    <div class="overlay"></div>
    <video playsinline autoplay muted loop src="{{asset('images/how-it-works/video_bg.mp4')}}"></video>
    <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100 text-white">
                <h1 class="page-title text-center">How It Works</h1>
                <p class="page-description">Inilah hal-hal yang perlu Anda fahami sebelum memesan layanan Rabbit Media!
                    Disini kami akan menjelaskan segala sesuatu yang berkaitan dengan proses pemesanan layanan Rabbit
                    Media, mulai dari memilih layanan, booking tanggal, hingga jenis pembayaran beserta aturannya.
                    Apabila masih ada hal yang perlu Anda tanyakan, mohon untuk segera menghubungi kami sebelum
                    memesan.</p>
                <button class="btn btn-outline-primary py-3 px-4"
                        onClick="$('.post-wrapper .post:first-child .stem-overlay .icon').click();">LEARN MORE
                </button>
            </div>
        </div>
    </div>
</header>

<div class="stem-wrapper">
    <div class="stem"></div>
    <div class="stem-background"></div>
</div>
<div class="section main-content">
    <div id="particles-js" style="width: 100%;height: 100%"></div>

    <div class="section-inner">
        <div class="stem-padding"></div>

        <div class="post-wrapper">
            <article class="post bitbucket-icon">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-right"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post m-icon" data-stem-color="green">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-left"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post music-icon" data-stem-color="blue">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-right"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post twitter-icon" data-stem-color="red">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-left"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post bitbucket-icon">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-right"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post music-icon" data-stem-color="green">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>

                <div class="post-content">
                    <p class="meta">{{\Faker\Factory::create()->sentence}}</p>
                    <h2 class="post-title">{{\Faker\Factory::create()->jobTitle}}</h2>
                    <div class="entry-content">
                        <p>
                            <img src="{{\Faker\Factory::create()->imageUrl()}}" class="img-fluid rounded image-left"
                                 alt="Image" width="240px">
                            {{\Faker\Factory::create()->paragraphs(rand(2,3), true)}}
                        </p>
                    </div>
                </div>
            </article>

            <article class="post scroll-to-top trigger-scroll-to-top" data-stem-color="blue">
                <div class="stem-overlay">
                    <div class="icon"></div>
                    <div class="stem-mask"></div>
                </div>
            </article>
        </div>
    </div>
</div>

<footer class="footer section">
    <div class="section-inner">
        <div class="good-bye">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                &copy;&nbsp;{{now()->format('Y')}} Rabbit Media – Digital Creative Service. All rights reserved.<br>
                Template by <a href="https://twitter.com/nicklassandell" target="_blank">Nicklas Sandell</a>.
                Designed & Developed by <a href="{{route('about')}}">Rabbit Media</a>.<br>
                <a href="{{route('about')}}">About Us</a> <span class="bullet"></span>
                <a href="{{route('info')}}">Privacy Policy</a> <span class="bullet"></span>
                <a href="{{route('info')}}">Terms & Conditions</a> <span class="bullet"></span>
                <a href="{{route('faq')}}">FAQ</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div> <!-- section-inner -->
    </div>
</footer>

<div class="progress">
    <div class="bar"></div>
</div>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('admins/modules/selectivizr-min.js')}}"></script>
<script src="{{asset('admins/modules/nicescroll/jquery.nicescroll.js')}}"></script>
<script src="{{asset('admins/modules/checkMobileDevice.js')}}"></script>
<script src="{{asset('admins/modules/particles.min.js')}}"></script>
<script>
    (function ($) {

        $(document).ready(function () {
            setupFade();
            setupClickToScroll();
            setupPostAnimation();
            setupScrollToTop();
            enableScrollAbortion();

            // Trigger window.scroll, this will initiate some of the scripts
            $(window).scroll();

            window.mobilecheck() ? $("body").removeClass('use-nicescroll') : '';
            window.mobilecheck() ? $(".entry-content img").removeClass('image-left image-right') : '';
            window.mobilecheck() ? $("#particles-js").remove() : '';

            $(".use-nicescroll").niceScroll({
                cursorcolor: "rgba(49, 40, 85, 1)",
                cursorwidth: "8px",
                background: "rgba(222, 222, 222, .75)",
                cursorborder: "1px solid #312855",
                zindex: 1
            });
        });


        // Allow user to cancel scroll animation by manually scrolling
        function enableScrollAbortion() {
            var $viewport = $('html, body');
            $viewport.on('scroll mousedown DOMMouseScroll mousewheel keyup', function (e) {
                if (e.which > 0 || e.type === 'mousedown' || e.type === 'mousewheel') {
                    $viewport.stop();
                }
            });
        }

        function setupScrollToTop() {
            var scrollSpeed = 750;
            $('.trigger-scroll-to-top').click(function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, scrollSpeed);
            });
        }


        function setupPostAnimation() {
            var posts = $('.post-wrapper .post');
            $(window).on('scroll resize', function () {

                var currScroll = $(window).scrollTop() > $(document).scrollTop() ? $(window).scrollTop() : $(document).scrollTop(),
                    windowHeight = $(window).height(), // Needs to be here because window can resize
                    overScroll = Math.ceil(windowHeight * .20),
                    treshhold = (currScroll + windowHeight) - overScroll;

                posts.each(function () {

                    var post = $(this),
                        postScroll = post.offset().top

                    if (postScroll > treshhold) {
                        post.addClass('hidden');
                    } else {
                        post.removeClass('hidden');
                    }

                });

            });
        }

        function setupFade() {

            var posts = $('.post-wrapper .post').reverse(),
                stemWrapper = $('.stem-wrapper'),
                halfScreen = $(window).height() / 2;

            $(window).on('scroll resize', function () {

                delay(function () {

                    var currScroll = $(window).scrollTop() > $(document).scrollTop() ? $(window).scrollTop() : $(document).scrollTop(),
                        scrollSplit = currScroll + halfScreen;

                    posts.removeClass('active').each(function () {

                        var post = $(this),
                            postOffset = post.offset().top;

                        if (scrollSplit > postOffset) {

                            // Add active class to fade in
                            post.addClass('active')

                            // Get post color
                            var color = post.data('stem-color') ? post.data('stem-color') : null,
                                allColors = 'color-green color-blue color-red';

                            stemWrapper.removeClass(allColors);

                            if (color !== null) {
                                stemWrapper.addClass('color-' + color);
                            }

                            return false;
                        }

                    });
                }, 20);

            });

        }

        function setupClickToScroll(post) {

            var scrollSpeed = 750;

            $('.post-wrapper .post .stem-overlay .icon').click(function (e) {
                e.preventDefault();

                var icon = $(this),
                    post = icon.closest('.post'),
                    postTopOffset = post.offset().top,
                    postHeight = post.height(),
                    halfScreen = $(window).height() / 2,
                    scrollTo = postTopOffset - halfScreen + (postHeight / 2);

                $('html, body').animate({
                    scrollTop: scrollTo
                }, scrollSpeed);
            });

        }

    })(jQuery);

    /*==========  Helpers  ==========*/
    // Timeout function
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $.fn.reverse = function () {
        return this.pushStack(this.get().reverse(), arguments);
    };

    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));

    <!--Scroll Progress Bar-->
    function progress() {

        var windowScrollTop = $(window).scrollTop();
        var docHeight = $(document).height();
        var windowHeight = $(window).height();
        var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
        var $bgColor = progress > 99 ? '#312855' : '#592f83';
        var $textColor = progress > 99 ? '#fff' : '#333';

        $('.progress .bar').width(progress + '%').css({backgroundColor: $bgColor});
        // $('h1').text(Math.round(progress) + '%').css({color: $textColor});
        $('.fill').height(progress + '%').css({backgroundColor: $bgColor});
    }

    progress();

    $(document).on('scroll', progress);

    <!-- WhatsHelp.io widget -->
    (function () {
        var options = {
            whatsapp: "+6282234389870",
            line: "//line.me/ti/p/fqnkk",
            call_to_action: "Contact us",
            button_color: "#592f83",
            position: window.mobilecheck() ? 'right' : 'left',
            order: "line,whatsapp",
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () {
            WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();

    particlesJS('particles-js', {
        'particles': {
            'number': {
                'value': 80,
                'density': {
                    'enable': true,
                    'value_area': 800
                }
            },
            'color': {
                'value': ['#fff']
            },
            'shape': {
                'type': 'circle',
                'stroke': {
                    'width': 0,
                    'color': '#000'
                },
                'polygon': {
                    'nb_sides': 5
                }
            },
            'opacity': {
                'value': 0.5,
                'random': false,
                'anim': {
                    'enable': false,
                    'speed': 1,
                    'opacity_min': 0.1,
                    'sync': false
                }
            },
            'size': {
                'value': 3,
                'random': true,
                'anim': {
                    'enable': false,
                    'speed': 40,
                    'size_min': 0.1,
                    'sync': false
                }
            },
            'line_linked': {
                'enable': true,
                'distance': 150,
                'color': '#fff',
                'opacity': 0.4,
                'width': 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
            }
        },
        'interactivity': {
            'detect_on': 'canvas',
            'events': {
                'onhover': {
                    'enable': true,
                    'mode': 'grab'
                },
                'onclick': {
                    'enable': false,
                    'mode': 'push'
                },
                'resize': true
            },
            'modes': {
                'grab': {
                    'distance': 300,
                    'line_linked': {
                        'opacity': .5
                    }
                },
                'bubble': {
                    'distance': 400,
                    'size': 10,
                    'duration': 2,
                    'opacity': .5,
                    'speed': 3
                },
                'repulse': {
                    'distance': 200,
                    'duration': 0.4
                },
                'push': {
                    'particles_nb': 4
                },
                'remove': {
                    'particles_nb': 2
                }
            }
        },
        'retina_detect': true
    });
</script>
@include('layouts.partials._notification')
</body>
</html>
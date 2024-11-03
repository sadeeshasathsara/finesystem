<?php
include_once "../finesystem/notification.php";
include_once "app/loading.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="images/favicon.png" type="image/png">

    <title>Fine System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Mobile Styles */
        @media (max-width: 768px) {
            .custom-navbar {
                position: relative;
                padding: 10px;
                background-color: #333;
            }

            .custom-navbar-toggler {
                background-color: #fff;
                border: none;
                padding: 10px;
                font-size: 18px;
                cursor: pointer;
                display: block;
            }

            .custom-navbar-toggler-icon {
                display: block;
                width: 25px;
                height: 3px;
                background-color: #333;
                margin: 4px 0;
            }

            .custom-navbar-collapse {
                display: none;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background-color: #333;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                z-index: 999;
                margin-top: -10px;
            }

            .custom-navbar-collapse.show {
                display: flex;
            }

            .custom-navbar-nav {
                list-style-type: none;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .custom-nav-item {
                width: 100%;
            }

            .custom-nav-link {
                color: #fff;
                padding: 10px 15px;
                text-align: center;
                display: block;
                text-decoration: none;
            }

            .custom-nav-link:hover {
                background-color: #444;
            }

            .svg-wave {
                bottom: -55px;
            }

            body {
                font-size: 0.8rem;
            }

            .about {
                width: 100%;
            }

            .flex-row {
                flex-direction: column;
            }

            .content-narrow {
                display: none;
            }

            .one-third-width {
                width: 90%;
            }

            .one-third-width .icon-box p {
                width: 90%;
            }

            .testimonial {
                padding: 10px;
            }

            .test-text {
                border: 1px solid black;
            }

            .test-img {
                border: 1px solid black;
            }

            .contact-content {
                margin-left: 30px;
            }
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="custom-navbar">
        <div class="custom-container">
            <a class="custom-navbar-brand" href="#">
                <span class="custom-logo">FINE PAY.</span>
            </a>
            <button class="custom-navbar-toggler" type="button" aria-controls="customNavbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
            <div class="custom-navbar-collapse" id="customNavbarContent">
                <ul class="custom-navbar-nav">
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="" data-scroll-nav="0">Home</a> </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#" data-scroll-nav="1">About</a> </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#" data-scroll-nav="2">Features</a>
                    </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#" data-scroll-nav="3">Team</a> </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#"
                            data-scroll-nav="4">Testimonials</a> </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#" data-scroll-nav="5">Faq</a> </li>
                    <li class="custom-nav-item"> <a class="custom-nav-link" href="#" data-scroll-nav="6">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarToggler = document.querySelector('.custom-navbar-toggler');
            const navbarCollapse = document.querySelector('.custom-navbar-collapse');

            navbarToggler.addEventListener('click', function () {
                navbarCollapse.classList.toggle('show');
            });
        });

    </script>

    <!-- End Navbar -->
    <!-------Banner Start------->
    <section class="banner" data-scroll-index='0'>
        <div class="banner-overlay">
            <div class="layout-container ">
                <div class="flex-row ">
                    <div class="content-wide ">
                        <div class="banner-text">
                            <h1 class="white">Pay Your Fines Quickly and Securely Online</h1>

                            <p class="banner-text white">Welcome to our online fines payment system. We make it easy and
                                secure to pay your fines from anywhere, at any time. Our platform offers a user-friendly
                                interface and multiple payment options to ensure a smooth experience. No more waiting in
                                lines or dealing with paperwork—just a simple, efficient way to handle your fines with
                                confidence.</p>

                            <ul>
                                <li><a href="login.php"><button class="login-btn">
                                            LOG IN
                                        </button></a></li>
                                <li><a href="login.php"><button class="signup-btn">
                                            SIGN UP
                                        </button></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-narrow">
                        <img src="images/hero.png" class="img-fluid wow fadeInUp" />
                    </div>
                </div>
            </div>
        </div>
        <span class="svg-wave"> <img class="svg-hero" src="images/applight-wave.svg"> </span>
    </section>


    <!-------Banner End------->

    <!-------About End------->

    <section class="about section-padding prelative" data-scroll-index='1'>
        <div class="layout-container">
            <div class="flex-row">
                <div class="full-width">
                    <div class="header-center">
                        <h3>About Our Service</h3>
                        <span class="line"></span>
                        <p>Our online fines payment system is designed to make managing and paying your fines as simple
                            and efficient as possible. We prioritize user experience, security, and accessibility to
                            provide you with a seamless solution for handling fines.</p>
                    </div>
                    <div class="content-center">
                        <div class="flex-row">
                            <div class="one-third-width">
                                <div class="icon-box wow fadeInUp" data-wow-delay="0.2s">
                                    <i class="fa fa-shield-alt" aria-hidden="true"></i>
                                    <h5>Secure</h5>
                                    <p>Your data and transactions are protected with the highest security standards,
                                        ensuring your information is safe with us.</p>
                                </div>
                            </div>
                            <div class="one-third-width">
                                <div class="icon-box wow fadeInUp" data-wow-delay="0.4s">
                                    <i class="fa fa-desktop" aria-hidden="true"></i>
                                    <h5>User-Friendly</h5>
                                    <p>Our platform is designed for ease of use, allowing you to manage and pay your
                                        fines effortlessly from any device.</p>
                                </div>
                            </div>
                            <div class="one-third-width">
                                <div class="icon-box wow fadeInUp" data-wow-delay="0.6s">
                                    <i class="fa fa-clock" aria-hidden="true"></i>
                                    <h5>Fast</h5>
                                    <p>Experience quick processing times and immediate updates to your account, saving
                                        you time and hassle.</p>
                                </div>
                            </div>
                        </div>
                        <a href="#features" class="about-btn">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-------About End------->

    <!-------Video Start------->
    <section class="video-section prelative text-center white">
        <div class="video-padding video-overlay">
            <div class="video-container">
                <h3>Watch Now</h3>
                <i class="fa fa-play" id="video-icon" aria-hidden="true"></i>
                <div class="video-popup">
                    <div class="video-source">
                        <div class="iframe-wrapper">
                            <iframe src="" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-------Video End------->

    <!-------Features Start------->



    <!-------Features End------->



    <!-------Testimonial Start------->
    <section class="testimonial section-padding" data-scroll-index='4'>
        <div class="testimonial-container">
            <div class="testimonial-row">
                <div class="testimonial-full-width">
                    <div class="testimonial-header text-center white">
                        <h3>What Our Users Say</h3>
                        <span class="line"></span>
                        <p class="white">Hear from our satisfied users about how our online fines payment system has
                            made managing and paying fines easier and more efficient.</p>
                    </div>

                    <div class="testimonial-content">
                        <div class="testimonial-row">
                            <div class="testimonial-offset testimonial-main-width">
                                <div class="testimonial-slider">
                                    <div class="testimonial-slider-item">
                                        <div class="test-img">
                                            <img src="images/user1.jpg" alt="Placeholder" width="157" height="157">
                                        </div>
                                        <div class="test-text">
                                            <span class="title">
                                                <span>Emily Johnson</span> Regular User
                                            </span>
                                            “The online fines payment system is incredibly convenient
                                            and user-friendly. It has made managing my fines much easier, and I
                                            appreciate the prompt updates and support.”
                                        </div>
                                    </div>
                                    <div class="testimonial-slider-item">
                                        <div class="test-img">
                                            <img src="images/user2.jpg" alt="Placeholder" width="157" height="157">
                                        </div>
                                        <div class="test-text">
                                            <span class="title">
                                                <span>Michael Lee</span> Frequent Driver
                                            </span>
                                            “I used to dread dealing with fines, but this system has
                                            streamlined the process. The ability to pay fines quickly and securely is a
                                            huge relief.”
                                        </div>
                                    </div>
                                    <div class="testimonial-slider-item">
                                        <div class="test-img">
                                            <img src="images/user3.jpg" alt="Placeholder" width="157" height="157">
                                        </div>
                                        <div class="test-text">
                                            <span class="title">
                                                <span>Sarah Kim</span> Business Owner
                                            </span>
                                            “Managing fines through this online system has been a
                                            game-changer for me. The interface is intuitive, and the support team is
                                            always ready to help with any issues.”
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


    <!-------Testimonial End------->

    <!-------FAQ Start------->
    <section class="faq-section section-padding prelative" data-scroll-index='5'>
        <div class="faq-container">
            <div class="faq-row">
                <div class="faq-full-width">
                    <div class="faq-header text-center">
                        <h3>Frequently Asked Questions</h3>
                        <span class="line"></span>
                        <p>Find answers to the most common questions about using our online fines payment system. If you
                            have more questions, feel free to reach out to our support team.</p>
                    </div>
                    <div class="faq-content-area">
                        <div class="faq-row">
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.2s">
                                <h4>How do I pay my fines online?</h4>
                                <p>To pay your fines online, simply log into your account, navigate to the "Pay Fines"
                                    section, and follow the instructions to complete your payment using a credit or
                                    debit card.</p>
                            </div>
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.2s">
                                <h4>What payment methods are accepted?</h4>
                                <p>We accept various payment methods including major credit cards, debit cards, and
                                    online payment platforms. Check the payment options available in your account.</p>
                            </div>
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.4s">
                                <h4>How can I view my previous payments?</h4>
                                <p>You can view your previous payments by accessing the "Payment History" section in
                                    your account. This will provide you with a detailed list of all transactions.</p>
                            </div>
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.4s">
                                <h4>What should I do if I encounter issues with payment?</h4>
                                <p>If you experience any issues with payment, please contact our support team
                                    immediately. We are here to help resolve any problems you might encounter.</p>
                            </div>
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.6s">
                                <h4>Can I get a refund if I overpaid?</h4>
                                <p>Yes, if you have overpaid, please reach out to our support team with your payment
                                    details. We will review your case and process a refund if applicable.</p>
                            </div>
                            <div class="faq-item faq-content wow fadeInUp" data-wow-delay="0.6s">
                                <h4>How secure is my payment information?</h4>
                                <p>We use advanced encryption and security measures to protect your payment information.
                                    Our system is designed to ensure that all transactions are safe and secure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-------FAQ End------->

    <!-------Contact Start------->
    <section class="contact-section section-padding" data-scroll-index='6'>
        <div class="contact-container">
            <div class="contact-row">
                <div class="contact-full-width">
                    <div class="contact-header text-center">
                        <h3>Contact Us</h3>
                        <span class="line"></span>
                        <p>If you have any questions or need assistance with our fines payment system, please feel free
                            to reach out to us. We are here to help!</p>
                    </div>
                    <div class="contact-content ">
                        <div class="contact-row ">
                            <div class="contact-form-column ">
                                <form id="contact_form" action="">


                                    <input type="text" id="your_name" class="form-input" name="full-name"
                                        placeholder="Full Name" required>


                                    <input type="email" id="email" class="form-input" name="email" placeholder="Email"
                                        required>


                                    <input type="text" id="subject" class="form-input" name="subject"
                                        placeholder="Subject">
                                    <textarea class="form-input" id="message" placeholder="Message" name="message"
                                        required></textarea>
                                    <button class="submit-button text-uppercase" type="submit"
                                        name="button">Submit</button>
                                </form>
                            </div>
                            <div class="contact-info-column">
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="fa fa-map-marker-alt contact-icon"></i>
                                        <div class="contact-details">
                                            <p class="text-uppercase">Address</p>
                                            <p class="text-uppercase">New Delhi, India</p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fa fa-mobile contact-icon"></i>
                                        <div class="contact-details">
                                            <p class="text-uppercase">Phone</p>
                                            <p class="text-uppercase"><a class="contact-link"
                                                    href="tel:+15173977100">+91
                                                    9900 9900 99</a></p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fa fa-envelope contact-icon"></i>
                                        <div class="contact-details">
                                            <p class="text-uppercase">E-mail</p>
                                            <p class="text-uppercase"><a class="contact-link"
                                                    href="mailto:support@finespayment.com">support@finespayment.com</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fa fa-clock contact-icon"></i>
                                        <div class="contact-details">
                                            <p class="text-uppercase">Working Hours</p>
                                            <p class="text-uppercase">Mon-Fri 9:00 AM to 5:00 PM</p>
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



    <!-------Contact End------->

    <!-------Download End------->
    <!-------Login or Sign Up Start------->
    <section class="login-signup-section section-padding">
        <div class="login-signup-container">
            <div class="login-signup-row">
                <div class="login-signup-full-width">
                    <div class="login-signup-header text-center">
                        <h3>Login or Sign Up</h3>
                        <span class="header-line"></span>
                        <p>Access your account or create a new one to manage your fines and payments effortlessly. Join
                            us to experience a seamless fines management system.</p>
                    </div>
                </div>
                <div class="login-signup-buttons-container text-center">
                    <ul class="login-signup-buttons">
                        <li><a href="login.php" class="btn-login">Login</a></li>
                        <li><a href="login.php" class="btn-signup">Sign Up</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>



    <!-------Download End------->

    <!-------Footer Start------->
    <footer class="footer-copy">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2024 Online FIne System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <!-- scrollIt js -->
    <script src="js/scrollIt.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script>
        wow = new WOW();
        wow.init();
        $(document).ready(function (e) {

            $('#video-icon').on('click', function (e) {
                e.preventDefault();
                $('.video-popup').css('display', 'flex');
                $('.iframe-src').slideDown();
            });
            $('.video-popup').on('click', function (e) {
                var $target = e.target.nodeName;
                var video_src = $(this).find('iframe').attr('src');
                if ($target != 'IFRAME') {
                    $('.video-popup').fadeOut();
                    $('.iframe-src').slideUp();
                    $('.video-popup iframe').attr('src', " ");
                    $('.video-popup iframe').attr('src', video_src);
                }
            });

            $('.slider').bxSlider({
                pager: false
            });
        });

        $(window).on("scroll", function () {

            var bodyScroll = $(window).scrollTop(),
                navbar = $(".navbar");

            if (bodyScroll > 50) {
                $('.navbar-logo img').attr('src', 'images/logo-black.png');
                navbar.addClass("nav-scroll");

            } else {
                $('.navbar-logo img').attr('src', 'images/logo.png');
                navbar.removeClass("nav-scroll");
            }

        });
        $(window).on("load", function () {
            var bodyScroll = $(window).scrollTop(),
                navbar = $(".navbar");

            if (bodyScroll > 50) {
                $('.navbar-logo img').attr('src', 'images/logo-black.png');
                navbar.addClass("nav-scroll");
            } else {
                $('.navbar-logo img').attr('src', 'images/logo-white.png');
                navbar.removeClass("nav-scroll");
            }

            $.scrollIt({

                easing: 'swing',      // the easing function for animation
                scrollTime: 900,       // how long (in ms) the animation takes
                activeClass: 'active', // class given to the active nav element
                onPageChange: null,    // function(pageIndex) that is called when page is changed
                topOffset: -63
            });
        });

    </script>
</body>

</html>

<?php

if (isset($_SESSION["notification"]) && $_SESSION["notification"] == true) {
    callNotification("You are logged out from the system.");
    $_SESSION["notification"] = false;
}
?>
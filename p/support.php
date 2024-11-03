<?php
include "../app/connection.php";
if (isset($_SESSION['policeId'])) {
    $police_id = $_SESSION["policeId"];
} else {
    header("Location: ../login.php");
    exit;
}
?>

<link rel="stylesheet" href="css/support.css" />
<link rel="stylesheet" href="css/stylesheet.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Nav Bar -->
<div class="site-wrap">
    <div class="menu-toggle" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <script>
        function toggleMenu() {
            document.querySelector('.site-nav').classList.toggle('show');
            document.querySelector('.site-wrap').classList.toggle('menu-open');
        }
    </script>
    <nav class="site-nav">
        <div class="name">Fine System</div>

        <ul class="site-nav-ul">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="penalties.php">Penalties</a></li>
            <li><a href="fine-details.php">Fine Details</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li class="active"><a href="support.php">Support</a></li>
        </ul>

        <div id="go-profile" class="note">
            <?php
            $police_id = $_SESSION['policeNumber'];
            $sql_name = "select name, profile_picture from policeman where police_id = '$police_id'";
            $result = mysqli_query($conn, $sql_name);
            if ($result) {

                $row = mysqli_fetch_assoc($result);
                $name = $row['name'];
                $profile_picture_url = 'src/profile_photo/' . $row['profile_picture'];
                ?>
                <h3><?php echo $name;
            } ?></h3>
            <?php echo '<img src="' . $profile_picture_url . ' " alt="pp" />' ?>

        </div>
    </nav>
    <!-- ---------------------------------------------------- -->

    <!-- Main Content -->
    <main>
        <!-------------- Main Header------------->
        <header>
            <div class="breadcrumbs">
                <a href="index.html">Home</a>
            </div>

            <h1 class="title">Support</h1>
        </header>

        <!-- -------------------------------- -->

        <div id="sub-content">
            <div class="support">
                <header>
                    <h1>Fine System Support</h1>
                    <p>Everything you need to effectively use the fine system.</p>
                </header>
                <div class="container">
                    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
                    <script>
                        function toggleSidebar() {
                            const sidebar = document.querySelector('.support .sidebar');
                            sidebar.style.display = sidebar.style.display === 'none' || sidebar.style.display === '' ? 'block' : 'none';
                        }

                    </script>
                    <aside class="sidebar">
                        <h2>Sections</h2>
                        <ul>
                            <li><a href="#overview" class="selected">Overview</a></li>
                            <li><a href="#user-guides">User Guides</a></li>
                            <li><a href="#technical-support">Technical Support</a></li>
                            <li><a href="#documentation">Documentation</a></li>
                            <li><a href="#resources">Resources</a></li>
                            <li><a href="#updates">Updates</a></li>
                            <li><a href="#feedback">Feedback</a></li>
                            <li><a href="#best-practices">Best Practices</a></li>
                            <li><a href="#legal">Legal Information</a></li>
                        </ul>
                    </aside>
                    <main>
                        <section id="overview" class="card">
                            <h2>Overview</h2>
                            <p>Welcome to the Fine System support page. This section provides a comprehensive overview
                                of the system's functionalities and features to help you get started.</p>

                            <h3>System Features</h3>
                            <ul>
                                <li><strong>Create Penalties:</strong> Easily create and manage penalties for various
                                    violations.</li>
                                <li><strong>View Fine Details:</strong> Access detailed information on fines, including
                                    title, description, and price.</li>
                                <li><strong>Generate Reports:</strong> Generate and customize reports to analyze fine
                                    data and trends.</li>
                            </ul>

                            <h3>Quick Tips</h3>
                            <ul>
                                <li><strong>Creating Penalties:</strong> Ensure you include all relevant details and
                                    review for accuracy before saving.</li>
                                <li><strong>Viewing Fine Details:</strong> Use the search and filter options to quickly
                                    locate specific fines.</li>
                                <li><strong>Generating Reports:</strong> Customize your reports to focus on the most
                                    relevant data for your needs.</li>
                            </ul>

                            <h3>Getting Help</h3>
                            <p>If you need further assistance, please visit the <a href="#technical-support">Technical
                                    Support</a> section or reach out via our support channels.</p>
                        </section>

                        <section id="user-guides" class="card">
                            <h2>User Guides</h2>
                            <div class="guide">
                                <h3>Creating Penalties</h3>
                                <p>Step-by-step guide on creating penalties.</p>
                                <button onclick="showTutorial('creating-penalties')">Watch Tutorial</button>
                                <div id="creating-penalties" class="tutorial hidden">
                                    <video src="creating-penalties.mp4" controls></video>
                                </div>
                            </div>
                            <div class="guide">
                                <h3>Viewing Fine Details</h3>
                                <p>Instructions on navigating the fine details tab.</p>
                                <button onclick="showTutorial('viewing-fine-details')">Watch Tutorial</button>
                                <div id="viewing-fine-details" class="tutorial hidden">
                                    <video src="viewing-fine-details.mp4" controls></video>
                                </div>
                            </div>
                            <div class="guide">
                                <h3>Generating Reports</h3>
                                <p>Guide on generating and interpreting reports.</p>
                                <button onclick="showTutorial('generating-reports')">Watch Tutorial</button>
                                <div id="generating-reports" class="tutorial hidden">
                                    <video src="generating-reports.mp4" controls></video>
                                </div>
                            </div>
                            <h3>FAQs</h3>
                            <p>Common questions and answers.</p>
                            <div class="faq">
                                <div class="faq-item">
                                    <button class="faq-question">How do I create a penalty?</button>
                                    <div class="faq-answer hidden">
                                        <p>To create a penalty, navigate to the "Create Penalties" section, fill out the
                                            required fields, and save. Ensure that you include a clear description and
                                            accurate details for each penalty.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <button class="faq-question">Where can I view fine details?</button>
                                    <div class="faq-answer hidden">
                                        <p>Fine details can be viewed in the "View Fine Details" section. Use the search
                                            and filter options to find specific fines, and click on a fine to see its
                                            title, description, and price.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <button class="faq-question">How do I generate a report?</button>
                                    <div class="faq-answer hidden">
                                        <p>To generate a report, go to the "Generate Reports" section. Choose the report
                                            type and customize the parameters to include the data you need. You can then
                                            download or view the report directly.</p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <button class="faq-question">What should I do if I encounter a technical
                                        issue?</button>
                                    <div class="faq-answer hidden">
                                        <p>If you encounter a technical issue, please visit the "Technical Support"
                                            section for troubleshooting steps or contact our support team directly for
                                            assistance.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="technical-support" class="card">
                            <h2>Technical Support</h2>
                            <p>Contact information for technical support.</p>
                            <p>Phone: 123-456-7890</p>
                            <p>Email: support@finesystem.com</p>
                            <p>Live Chat: Available on our website</p>
                            <h3>Troubleshooting Guides</h3>
                            <p>Solutions for common technical issues.</p>
                        </section>

                        <section id="documentation" class="card">
                            <h2>Documentation</h2>
                            <a href="user-manual.pdf" download>User Manual</a>
                            <p>Policies and Procedures information.</p>
                        </section>

                        <section id="resources" class="card">
                            <h2>Resources</h2>
                            <p><a href="forms/template.pdf" download>Downloadable Forms</a></p>
                            <p><a href="#">Useful Links</a></p>
                        </section>

                        <section id="updates" class="card">
                            <h2>Updates</h2>
                            <p>Latest news and updates about the system.</p>
                            <p>Maintenance Schedule: Every Sunday, 2-4 AM</p>
                        </section>

                        <section id="feedback" class="card feedback-form">
                            <h2>Feedback</h2>
                            <form action="/submit-feedback" method="post">
                                <label for="feedback-text">Your Feedback:</label>
                                <textarea id="feedback-text" name="feedback-text" rows="4" required></textarea>
                                <button type="submit">Submit Feedback</button>
                            </form>
                            <h3>Suggestions for Improvement</h3>
                            <p>Share your ideas for new features or improvements.</p>
                        </section>

                        <section id="best-practices" class="card">
                            <h2>Best Practices</h2>
                            <p>Follow these best practices to make the most out of the Fine System and ensure efficient
                                and effective management of fines.</p>

                            <h3>1. Accurate Penalty Creation</h3>
                            <p>When creating penalties, ensure all details are accurate and comprehensive. Include clear
                                titles, detailed descriptions, and precise pricing to avoid confusion and ensure proper
                                enforcement.</p>

                            <h3>2. Regular Data Review</h3>
                            <p>Regularly review and update fine records to maintain accuracy. Use the system's reporting
                                tools to identify trends and make necessary adjustments to improve the enforcement
                                process.</p>

                            <h3>3. Utilize Reporting Features</h3>
                            <p>Make full use of the system’s reporting features to generate insightful reports.
                                Customize your reports to track performance, monitor compliance, and analyze data
                                effectively.</p>

                            <h3>4. Training and Documentation</h3>
                            <p>Ensure that all users are properly trained on how to use the Fine System. Provide them
                                with up-to-date documentation and support materials to help them navigate the system
                                efficiently.</p>

                            <h3>5. Data Security and Privacy</h3>
                            <p>Adhere to best practices for data security and privacy. Regularly review and update your
                                security protocols to protect sensitive information and comply with data protection
                                regulations.</p>

                            <h3>6. Feedback and Improvement</h3>
                            <p>Encourage feedback from users and use it to continuously improve the system. Address any
                                issues promptly and make necessary enhancements to ensure the system meets the needs of
                                all users.</p>
                        </section>


                        <section id="legal" class="card">
                            <h2>Legal Information</h2>
                            <p>Welcome to the Legal Information section. Here you will find important details regarding
                                the legal aspects of using the Fine System.</p>

                            <h3>Terms of Service</h3>
                            <p>By using the Fine System, you agree to comply with our <a href="#terms-of-service">Terms
                                    of Service</a>. This document outlines the terms and conditions under which our
                                services are provided.</p>

                            <h3>Privacy Policy</h3>
                            <p>Your privacy is important to us. Please review our <a href="#privacy-policy">Privacy
                                    Policy</a> to understand how we collect, use, and protect your personal information.
                            </p>

                            <h3>Data Protection</h3>
                            <p>We are committed to protecting your data. Our <a href="#data-protection">Data Protection
                                    Policy</a> explains the measures we take to ensure the security and confidentiality
                                of your data.</p>

                            <h3>Disclaimer</h3>
                            <p>The information provided by the Fine System is for general informational purposes only.
                                While we strive to keep the information up-to-date and correct, we make no
                                representations or warranties of any kind about the completeness, accuracy, reliability,
                                or suitability of the information.</p>

                            <h3>Contact Us</h3>
                            <p>If you have any questions about our legal policies, please feel free to <a
                                    href="#contact-us">contact us</a>. We are here to help and provide clarification on
                                any legal matters.</p>
                        </section>
                    </main>
                </div>
                <footer>
                    <p>&copy; 2024 Fine System. All rights reserved.</p>
                </footer>
            </div>

        </div>
    </main>

    <!-- --------------------------------------------------- -->
</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', function () {
                const answer = this.nextElementSibling;

                // Toggle the visibility of the answer
                if (answer.classList.contains('hidden')) {
                    answer.classList.remove('hidden');
                } else {
                    answer.classList.add('hidden');
                }
            });
        });

        // Sidebar active tab management
        const links = document.querySelectorAll('.sidebar ul li a');

        links.forEach(link => {
            link.addEventListener('click', function () {
                links.forEach(link => link.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    });

</script>

<script>
    goProfile();
    function goProfile() {
        document.getElementById("go-profile").addEventListener("click", function () {
            window.location.href = "profile";
        });
    }
</script>
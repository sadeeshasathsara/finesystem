<?php
include "../app/connection.php";
if (isset($_SESSION['policeId'])) {
    $police_id = $_SESSION["policeId"];
} else {
    header("Location: ../login.php");
    exit;
}
?>

<link rel="stylesheet" href="css/stylesheet.css" />
<link rel="stylesheet" href="css/reports.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
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
            <li class="active"><a href="reports.php">Reports</a></li>
            <li><a href="support.php">Support</a></li>
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
                <a href="index.html">Home</a>>><a href="support.html">Support</a>
            </div>

            <h1 class="title">Support</h1>
        </header>

        <!-- -------------------------------- -->

        <div id="sub-content">
            <div class="reports">
                <header>
                    <h1>Police Reports Dashboard</h1>
                    <p>Generate and view various reports related to fines and activities.</p>
                </header>
                <div class="container">
                    <aside class="sidebar">
                        <h2>Reports</h2>
                        <ul>
                            <li><a href="#daily-activity" class="selected">Daily Activity Report</a></li>
                            <li><a href="#monthly-summary">Monthly Fine Summary</a></li>
                            <li><a href="#violation-trends">Violation Trends Report</a></li>
                        </ul>
                    </aside>
                    <main>
                        <section id="daily-activity" class="card">
                            <h2>Daily Activity Report</h2>
                            <div id="report-content">
                                <!-- Report content will be injected here -->
                            </div>
                            <button id="generate-report">Generate Report</button>
                            <button id="download-pdf">Download as PDF</button>
                            <!-- Include a form or controls to generate and view the report -->
                        </section>

                        <section id="monthly-summary" class="card">
                            <h2>Monthly Fine Summary</h2>
                            <div id="monthly-summary-content" class="hidden">

                                <h3>Summary for August</h3>
                                <p><strong>Total Fines Issued:</strong> <span id="total-fines">...</span></p>
                                <p><strong>Total Amount Collected:</strong> Rs.<span id="total-amount">...</span></p>
                                <p><strong>Average Fine Amount:</strong> Rs.<span id="average-fine">...</span></p>

                                <h4>Breakdown by Violation Type</h4>
                                <div id="violation-breakdown">
                                    <!-- Violation breakdown will be injected here -->
                                </div>

                                <h4>Trends and Comparisons</h4>
                                <div id="trends-comparison">
                                    <!-- Trends and comparisons will be injected here -->
                                </div>

                                <h4>Detailed Data Table</h4>
                                <table id="fine-details">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type of Violation</th>
                                            <th>Amount</th>
                                            <th>Officer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Fine details will be injected here -->
                                    </tbody>
                                </table>


                            </div>
                            <button id="generate-monthly-report">Generate Report</button>
                            <button id="download-monthly-pdf">Download as PDF</button>
                        </section>

                        <section id="violation-trends" class="card">
                            <h2>Violation Trends</h2>
                            <div id="violation-trends-content" class="hidden">
                                <h3>Summary for <span id="report-period">August</span></h3>
                                <p><strong>Total Violations:</strong> <span id="total-violations">...</span></p>
                                <p><strong>Percentage Change:</strong> <span id="percentage-change">...</span></p>
                                <p><strong>Peak Period:</strong> <span id="peak-period">...</span></p>

                                <h4>Trends Over Time</h4>
                                <div id="trends-over-time">
                                    <canvas id="trends-chart"></canvas>
                                </div>

                                <h4>Violation Breakdown</h4>
                                <div id="violation-breakdown">
                                    <!-- Violation breakdown will be injected here -->
                                </div>

                                <h4>Insights and Recommendations</h4>
                                <div id="insights-recommendations">
                                    <!-- Insights and recommendations will be injected here -->
                                </div>
                            </div>
                            <button id="generate-trends-report">Generate Report</button>
                            <button id="download-trends-pdf">Download as PDF</button>
                        </section>
                    </main>
                </div>

            </div>

        </div>
    </main>

    <!-- --------------------------------------------------- -->
</div>

<script src="js/userdashboard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sidebar ul li a').forEach(tab => {
            tab.addEventListener('click', function (event) {
                event.preventDefault();
                document.querySelectorAll('.sidebar ul li a').forEach(tab => tab.classList.remove('selected'));
                this.classList.add('selected');

                // Handle showing the correct report content
                document.querySelectorAll('main > section').forEach(section => section.style.display = 'none');
                const targetId = this.getAttribute('href').substring(1);
                document.getElementById(targetId).style.display = 'block';
            });
        });

        // Ensure the selected tab is displayed on page load
        document.querySelectorAll('main > section').forEach(section => section.style.display = 'none');
        document.querySelector('.sidebar ul li a.selected').click();

        document.getElementById('generate-report').addEventListener('click', function () {
            // Example data - replace this with actual data retrieval logic
            const totalIncidents = 3;

            fetch('../p/app/today_report.php')
                .then(response => response.json())
                .then(data => {
                    const totalFines = data.totalFines;
                    const totalAmount = data.totalAmount;

                    console.log('Total Fines:', totalFines);
                    console.log('Total Amount:', totalAmount);

                    // Generate and update the report content after data is fetched
                    const reportContent = `
                <h3>Report for ${new Date().toLocaleDateString()}</h3>
                <p><strong>Total Fines Issued:</strong> ${totalFines}</p>
                <p><strong>Total Amount Collected:</strong> Rs.${totalAmount}</p>
                <p><strong>Total Incidents Attended:</strong> ${totalIncidents}</p>
            `;

                    document.getElementById('report-content').innerHTML = reportContent;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });


        document.getElementById('download-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const reportContent = document.getElementById('report-content').innerHTML;
            const contentToConvert = document.createElement('div');
            contentToConvert.innerHTML = reportContent;
            document.body.appendChild(contentToConvert);
            const contentText = contentToConvert.innerText;
            document.body.removeChild(contentToConvert);

            doc.text(contentText, 10, 10);
            doc.save('daily_activity_report.pdf');
        });

        document.getElementById('generate-monthly-report').addEventListener('click', function () {
            document.getElementById('monthly-summary-content').classList.remove("hidden");

            fetch('../p/app/monthly_report.php')
                .then(response => response.json())
                .then(data => {
                    const totalFines = data.totalFines;
                    const totalAmount = data.totalAmount;
                    const averageFine = data.averageFine;
                    const violationBreakdown = data.violationBreakdown;
                    const fineDetails = data.fineDetails;

                    document.getElementById('total-fines').textContent = totalFines;
                    document.getElementById('total-amount').textContent = totalAmount;
                    document.getElementById('average-fine').textContent = averageFine;

                    const breakdownContent = violationBreakdown.map(v => `
                <p>${v.type}: ${v.count} fines, Rs.${v.amount} collected</p>
            `).join('');
                    document.getElementById('violation-breakdown').innerHTML = breakdownContent;

                    const trendsComparisonContent = `
                <p>Compared to the previous month, fines increased by 10%</p>
            `;
                    document.getElementById('trends-comparison').innerHTML = trendsComparisonContent;

                    const fineDetailsRows = fineDetails.map(f => `
                <tr>
                    <td>${f.date}</td>
                    <td>${f.type}</td>
                    <td>Rs.${f.amount}</td>
                    <td>${f.officer}</td>
                </tr>
            `).join('');
                    document.querySelector('#fine-details tbody').innerHTML = fineDetailsRows;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });


        document.getElementById('download-monthly-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const reportContent = document.getElementById('monthly-summary-content').innerHTML;
            const contentToConvert = document.createElement('div');
            contentToConvert.innerHTML = reportContent;
            document.body.appendChild(contentToConvert);
            const contentText = contentToConvert.innerText;
            document.body.removeChild(contentToConvert);

            doc.text(contentText, 10, 10);
            doc.save('monthly_fine_summary.pdf');
        });


        document.getElementById('generate-trends-report').addEventListener('click', function () {
            document.getElementById("violation-trends-content").classList.remove("hidden");

            fetch('../p/app/trends_report.php')
                .then(response => response.json())
                .then(data => {
                    const totalViolations = data.totalViolations;
                    const percentageChange = data.percentageChange;
                    const monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    const monthIndex = parseInt(data.peakPeriod, 10) - 1;
                    const peakPeriod = monthNames[monthIndex];
                    const commonViolation = data.commonViolation;
                    const trendsData = data.trendsData;
                    const violationBreakdown = data.violationBreakdown;

                    console.log(document.getElementById('report-period'));
                    document.getElementById('report-period').textContent = 'January - December 2024';
                    document.getElementById('total-violations').textContent = totalViolations;
                    document.getElementById('percentage-change').textContent = percentageChange + '%';
                    document.getElementById('peak-period').textContent = peakPeriod;

                    const ctx = document.getElementById('trends-chart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: trendsData.labels,
                            datasets: [{
                                label: 'Violations',
                                data: trendsData.data,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    const breakdownContent = violationBreakdown.map(v => `
                <p>${v.type}: ${v.count} violations</p>
            `).join('');
                    document.getElementById('violation-breakdown').innerHTML = breakdownContent;

                    const insightsContent = `
                <p>${commonViolation} remains the most common violation, contributing to a significant portion of the total violations. The peak period observed is ${peakPeriod}, with a notable increase in violations. It is recommended to increase monitoring and enforcement during this period to address the spike in violations.</p>
            `;
                    document.getElementById('insights-recommendations').innerHTML = insightsContent;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });


        document.getElementById('download-trends-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Extract content from dynamically generated elements

            // Summary header and details
            const reportPeriod = document.getElementById('report-period').innerText;
            const totalViolations = document.getElementById('total-violations').innerText;
            const percentageChange = document.getElementById('percentage-change').innerText;
            const peakPeriod = document.getElementById('peak-period').innerText;

            // Add summary content to the PDF
            doc.setFontSize(16);
            doc.text(`Summary for ${reportPeriod}`, 10, 10);  // Add the report period
            doc.setFontSize(12);
            doc.text(`Total Violations: ${totalViolations}`, 10, 20);  // Add total violations
            doc.text(`Percentage Change: ${percentageChange}%`, 10, 30);  // Add percentage change
            doc.text(`Peak Period: ${peakPeriod}`, 10, 40);  // Add peak period

            // Capture the paragraph content (Insights and Recommendations)
            const insightsText = document.getElementById('insights-recommendations').innerText;
            const splitInsightsText = doc.splitTextToSize(insightsText, 180); // Adjust width for wrapping

            // Add the paragraph text to the PDF
            doc.text("Insights and Recommendations:", 10, 50);
            doc.text(splitInsightsText, 10, 60); // Add the formatted paragraph

            // Capture the chart (canvas) using html2canvas
            const trendsChart = document.getElementById('trends-chart');

            // Use html2canvas to capture the chart and add it to the PDF
            html2canvas(trendsChart).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 90, 180, 90);  // Adjust size and position as needed

                // Save the PDF after adding both text and chart
                doc.save('violation_trends_report.pdf');
            });
        });



    });

    function goProfile() {
        document.getElementById("go-profile").addEventListener("click", function () {
            window.location.href = "profile";
        });
    }

</script>
<script>
    goProfile();
    function goProfile() {
        document.getElementById("go-profile").addEventListener("click", function () {
            window.location.href = "profile";
        });
    }
</script>
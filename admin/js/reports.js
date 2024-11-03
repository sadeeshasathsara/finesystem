// Function to generate reports
function generateReport(reportType) {
  var reportOutput = document.getElementById("report-output");
  var xhr = new XMLHttpRequest();
  var url = "";
  var params = "";

  // Clear previous output
  reportOutput.innerHTML = "<p>Loading...</p>";

  switch (reportType) {
    case "fine-overview":
      url = "app/generate_fine_overview.php";
      break;

    case "fines-by-department":
      var department = document.getElementById("department").value;
      url = "app/generate_fines_by_department.php";
      params = "department=" + encodeURIComponent(department);
      break;

    case "fines-by-date-range":
      var startDate = document.getElementById("start-date").value;
      var endDate = document.getElementById("end-date").value;
      url = "app/generate_fines_by_date_range.php";
      params =
        "start_date=" +
        encodeURIComponent(startDate) +
        "&end_date=" +
        encodeURIComponent(endDate);
      break;

    default:
      reportOutput.innerHTML = "<h3>Error: Unknown report type.</h3>";
      return;
  }

  xhr.open("GET", url + "?" + params, true);
  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 400) {
      var response = JSON.parse(xhr.responseText);
      var content = "";

      if (response.error) {
        content = "<h3>Error: " + response.error + "</h3>";
      } else {
        content = generateReportContent(reportType, response);
      }

      reportOutput.innerHTML = content;
    } else {
      reportOutput.innerHTML =
        "<h3>Error fetching data. Please try again later.</h3>";
    }
  };

  xhr.onerror = function () {
    reportOutput.innerHTML =
      "<h3>Network error. Please check your connection and try again.</h3>";
  };

  xhr.send();
}

// Function to generate HTML content for each report type
function generateReportContent(reportType, data) {
  var content = "";

  switch (reportType) {
    case "fine-overview":
      content = "<h3>Fine Overview Report</h3>";
      content +=
        "<table><thead><tr><th>Total Fines Issued</th><th>Total Amount</th><th>Paid</th><th>Unpaid</th></tr></thead><tbody>";
      content +=
        "<tr><td>" +
        data.total_fines +
        "</td><td>" +
        data.total_amount +
        "</td><td>" +
        data.paid_fines +
        "</td><td>" +
        data.unpaid_fines +
        "</td></tr>";
      content += "</tbody></table>";
      break;

    case "fines-by-department":
      content = "<h3>Fines by Department Report</h3>";
      content +=
        "<table><thead><tr><th>Department</th><th>Total Fines</th><th>Total Amount</th></tr></thead><tbody>";
      data.forEach(function (department) {
        content +=
          "<tr><td>" +
          department.department_name +
          "</td><td>" +
          department.total_fines +
          "</td><td>" +
          department.total_amount +
          "</td></tr>";
      });
      content += "</tbody></table>";
      break;

    case "fines-by-date-range":
      content = "<h3>Fines by Date Range Report</h3>";
      content +=
        "<table><thead><tr><th>Date</th><th>Total Fines</th><th>Total Amount</th></tr></thead><tbody>";
      data.forEach(function (dateRange) {
        content +=
          "<tr><td>" +
          dateRange.date +
          "</td><td>" +
          dateRange.total_fines +
          "</td><td>" +
          dateRange.total_amount +
          "</td></tr>";
      });
      content += "</tbody></table>";
      break;
  }

  // Add PDF download button
  content +=
    "<button class='report-down' onclick=\"downloadPDF('" +
    reportType +
    "')\">Download as PDF</button>";

  return content;
}

function downloadPDF(reportType) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Add title based on report type
  let title = "";
  switch (reportType) {
    case "fine-overview":
      title = "Fine Overview Report";
      break;
    case "fines-by-department":
      title = "Fines by Department Report";
      break;
    case "fines-by-date-range":
      title = "Fines by Date Range Report";
      break;
  }
  doc.text(title, 10, 10);

  // Get the table content from the report output
  var reportContent = document.getElementById("report-output");
  var table = reportContent.querySelector("table");

  // Convert HTML table to array data
  var data = [];
  var headers = [];
  table.querySelectorAll("thead tr th").forEach(function (th) {
    headers.push(th.innerText);
  });
  table.querySelectorAll("tbody tr").forEach(function (tr) {
    var rowData = [];
    tr.querySelectorAll("td").forEach(function (td) {
      rowData.push(td.innerText);
    });
    data.push(rowData);
  });

  // Generate the table in the PDF
  doc.autoTable({
    head: [headers],
    body: data,
    startY: 20,
  });

  // Save the PDF
  doc.save(reportType + "_report.pdf");
}

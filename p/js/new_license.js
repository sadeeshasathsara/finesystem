$(document).ready(function () {
  // Handle form submission
  $("#add-license-form").on("submit", function (e) {
    e.preventDefault();

    var newLicenseNumber = $("#new-license-number").val();
    var newLicenseName = $("#new-license-name").val();

    // Make an AJAX request to add the new license
    $.ajax({
      url: "../app/add_license.php", // Create this script to handle adding the new license
      type: "POST",
      data: {
        license_number: newLicenseNumber,
        license_name: newLicenseName,
      },
      success: function (response) {
        alert("License added successfully");
        $("#popup-form").hide();
        $("#firstname").val(newLicenseNumber + ", "); // Set the input field to the new license number
        $("#suggestions").empty(); // Clear suggestions
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
      },
    });
  });

  // Close popup when clicking on the close button
  $(".close-popup").on("click", function () {
    $("#popup-form").hide();
  });

  // Close popup when clicking outside the popup form
  $(window).on("click", function (event) {
    if ($(event.target).is("#popup-form")) {
      $("#popup-form").hide();
    }
  });
});

$(document).ready(function () {
  $("button[id^='show-details-']").on("click", function () {
    var pid = $(this).attr("id").replace("show-details-", "");

    $.ajax({
      url: "../p/app/get_penalty_details.php",
      type: "GET",
      data: { pid: pid },
      success: function (data) {
        $("#penalty-details").html(data);
        $("#penalty-sheet-popup").show();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
      },
    });
  });

  $("#close-penalty-popup").on("click", function () {
    $("#penalty-sheet-popup").hide();
  });

  // Print functionality
  $("#print-penalty-sheet").on("click", function () {
    var printContent = $("#penalty-details").html();
    var originalContent = $("body").html();

    $("body").html(printContent);
    window.print();
    $("body").html(originalContent);
    $("#penalty-sheet-popup").hide();
  });
});

$(document).ready(function () {
  $("#firstname").on("input", function () {
    var inputVal = $(this).val().trim();

    if (inputVal.length > 0) {
      $.ajax({
        url: "../p/app/suggest_license.php",
        type: "GET",
        data: { term: inputVal },
        success: function (data) {
          console.log("Raw data:", data);
          var parsedData = data;

          $("#suggestions").empty();

          if (Array.isArray(parsedData) && parsedData.length > 0) {
            var suggestionsHtml = "<ul>";
            $.each(parsedData, function (index, value) {
              suggestionsHtml += "<li>" + value + "</li>";
            });
            suggestionsHtml += "<li class='add-license'>+ ADD LICENSE</li>";
            suggestionsHtml += "</ul>";
            $("#suggestions").html(suggestionsHtml);

            // Attach click event to list items
            $("#suggestions li").on("click", function () {
              if ($(this).hasClass("add-license")) {
                // Show the popup form
                $("#popup-form").show();
              } else {
                var selectedText = $(this).text();

                // Set the input field to the selected suggestion
                $("#firstname").val(selectedText);

                // Clear suggestions
                $("#suggestions").empty();

                // Re-focus on input field to continue typing
                $("#firstname").focus();
              }
            });
          } else {
            // No suggestions found
            $("#suggestions").html(
              "<ul><li id='add-license-btn'>+ ADD LICENSE</li></ul>"
            );

            // Attach click event to #add-license-btn
            $("#add-license-btn").on("click", function () {
              // Show the popup form
              $("#popup-form").show();
              console.log("Add License button clicked");

              // Clear the input field and suggestions
              $("#firstname").val("");
              $("#suggestions").empty();
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
        },
      });
    } else {
      $("#suggestions").empty();
    }
  });

  // Optional: Clear suggestions if clicking outside
  $(document).click(function (event) {
    if (!$(event.target).closest("#firstname, #suggestions").length) {
      $("#suggestions").empty();
    }
  });
});

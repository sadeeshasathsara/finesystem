$(document).ready(function () {
  $("#add-fines").on("input", function () {
    var inputVal = $(this).val();

    // Extract text after the last comma
    var lastCommaIndex = inputVal.lastIndexOf(",");
    var searchTerm =
      lastCommaIndex === -1
        ? inputVal.trim()
        : inputVal.substring(lastCommaIndex + 1).trim();

    if (searchTerm.length > 0) {
      $.ajax({
        url: "../p/app/suggest_fines.php",
        type: "GET",
        data: { term: searchTerm },
        success: function (data) {
          console.log("Raw data:", data);
          var parsedData = data;

          $("#suggestions").empty();

          if (Array.isArray(parsedData) && parsedData.length > 0) {
            var suggestionsHtml = "<ul>";
            $.each(parsedData, function (index, value) {
              suggestionsHtml += "<li>" + value + "</li>";
            });
            suggestionsHtml += "</ul>";
            $("#suggestions").html(suggestionsHtml);

            // Attach click event to list items
            $("#suggestions li").on("click", function () {
              var selectedText = $(this).text();

              // Update the input field with the selected suggestion
              var newText =
                inputVal.substring(0, lastCommaIndex + 1).trim() +
                selectedText +
                ", ";

              $("#add-fines").val(newText);

              // Clear suggestions
              $("#suggestions").empty();

              // Re-focus on input field to continue typing
              $("#add-fines").focus();
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
    if (!$(event.target).closest("#add-fines, #suggestions").length) {
      $("#suggestions").empty();
    }
  });
});

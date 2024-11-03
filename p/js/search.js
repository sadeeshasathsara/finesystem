document.addEventListener("DOMContentLoaded", function () {
  // Get the search input element and no search results label
  const searchInput = document.querySelector(".InputContainer input");
  const noSearchResultsLabel = document.getElementById("no-search-results");
  const fineCards = document.querySelectorAll(".fine-card.recent-fine-card"); // Get all fine cards

  // Add an event listener for input changes
  searchInput.addEventListener("input", function () {
    const filter = searchInput.value.toLowerCase(); // Get the search query

    let hasResults = false; // Flag to check if there are any results

    fineCards.forEach(function (card) {
      const fineId = card.children[0].textContent.toLowerCase();
      const licenseNumber = card.children[1].textContent.toLowerCase();
      const issuedDate = card.children[2].textContent.toLowerCase();
      const totalFine = card.children[3].textContent.toLowerCase();

      // Check if any of the text in the fine card matches the search query
      if (
        fineId.includes(filter) ||
        licenseNumber.includes(filter) ||
        issuedDate.includes(filter) ||
        totalFine.includes(filter)
      ) {
        card.style.display = ""; // Show the card
        hasResults = true; // Set flag to true if there's at least one match
      } else {
        card.style.display = "none"; // Hide the card
      }
    });

    // Show or hide the "No search results" label based on the results
    noSearchResultsLabel.style.display =
      hasResults || filter === "" ? "none" : "flex";
  });
});

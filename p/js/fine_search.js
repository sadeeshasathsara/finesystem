document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");
  const noResultsDiv = document.getElementById("no-search-results");
  const fineCards = document.querySelectorAll(".nft");

  searchInput.addEventListener("input", function () {
    const filter = searchInput.value.toLowerCase(); // Get the search query
    let hasResults = false; // Flag to track if there are any results

    fineCards.forEach(function (card) {
      const fineId = card.querySelector("h2").textContent.toLowerCase();
      const fineName = card.querySelector("h2").textContent.toLowerCase();
      const fineDescription = card
        .querySelector(".description")
        .textContent.toLowerCase();
      const finePrice = card
        .querySelector(".price p")
        .textContent.toLowerCase();

      // Check if any of the text in the fine card matches the search query
      if (
        fineId.includes(filter) ||
        fineName.includes(filter) ||
        fineDescription.includes(filter) ||
        finePrice.includes(filter)
      ) {
        card.style.display = ""; // Show the card
        hasResults = true; // Set flag to true if there's at least one result
      } else {
        card.style.display = "none"; // Hide the card
      }
    });

    // Show or hide the no-results message based on whether there are results
    if (hasResults) {
      noResultsDiv.style.display = "none"; // Hide the no-results message
    } else {
      noResultsDiv.style.display = "flex"; // Show the no-results message
    }
  });
});

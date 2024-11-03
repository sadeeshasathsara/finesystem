navTabSelect();
showFineCards();
fineDetailsPopup();

function adjustLabelPositions() {
  // Select the first fine card
  const fineCard = document.querySelector(".fine-card");
  // Select the thead labels
  const theadLabels = document.querySelectorAll(".thead label");

  // Check if elements exist
  if (fineCard && theadLabels.length) {
    // Get the labels in the fine card
    const fineCardElements = fineCard.querySelectorAll("label, button");

    // Loop through the labels in the fine card and set the positions
    fineCardElements.forEach((element, index) => {
      const rect = element.getBoundingClientRect();
      const topPosition = rect.top - fineCard.getBoundingClientRect().top;

      // Set the position of the corresponding thead label
      if (theadLabels[index]) {
        theadLabels[index].style.position = "absolute";
        theadLabels[index].style.top = `${topPosition}px`;
      }
    });
  }
}

function navTabSelect() {
  const navTabs = document.querySelectorAll("#nav-tabs > a");
  navTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      navTabs.forEach((tab) => {
        tab.classList.remove("active");
        if (tab.id == "fine-tab") {
          document.getElementById("fines-content").classList.add("hidden");
        } else if (tab.id == "payment-tab") {
          document.getElementById("payment-content").classList.add("hidden");
        } else if (tab.id == "notification-tab") {
          document
            .getElementById("notificaton-content")
            .classList.add("hidden");
        }
      });
      tab.classList.add("active");
      if (tab.id == "fine-tab") {
        document.getElementById("fines-content").classList.remove("hidden");
      } else if (tab.id == "payment-tab") {
        document.getElementById("payment-content").classList.remove("hidden");
      } else if (tab.id == "notification-tab") {
        document
          .getElementById("notificaton-content")
          .classList.remove("hidden");
      }
    });
  });
}

function showFineCards() {
  var overdueClicked = 0;
  var tobeClicked = 0;

  document.querySelector("#overdue-txt").addEventListener("click", () => {
    if (overdueClicked == 0) {
      document.querySelector("#overdue-content").classList.remove("hidden");
      document.querySelector("#overdue-arrow").classList.add("rotate");
      overdueClicked = 1;
    } else {
      document.querySelector("#overdue-content").classList.add("hidden");
      document.querySelector("#overdue-arrow").classList.remove("rotate");
      overdueClicked = 0;
    }
  });

  document.querySelector("#tobe-txt").addEventListener("click", () => {
    if (overdueClicked == 0) {
      document.querySelector("#tobe-content").classList.remove("hidden");
      document.querySelector("#tobe-arrow").classList.add("rotate");
      overdueClicked = 1;
    } else {
      document.querySelector("#tobe-content").classList.add("hidden");
      document.querySelector("#tobe-arrow").classList.remove("rotate");
      overdueClicked = 0;
    }
  });

  document.querySelector("#overdue-arrow").addEventListener("click", () => {
    if (overdueClicked == 0) {
      document.querySelector("#overdue-content").classList.remove("hidden");
      document.querySelector("#overdue-arrow").classList.add("rotate");
      overdueClicked = 1;
    } else {
      document.querySelector("#overdue-content").classList.add("hidden");
      document.querySelector("#overdue-arrow").classList.remove("rotate");
      overdueClicked = 0;
    }
  });

  document.querySelector("#tobe-arrow").addEventListener("click", () => {
    if (overdueClicked == 0) {
      document.querySelector("#tobe-content").classList.remove("hidden");
      document.querySelector("#tobe-arrow").classList.add("rotate");
      overdueClicked = 1;
    } else {
      document.querySelector("#tobe-content").classList.add("hidden");
      document.querySelector("#tobe-arrow").classList.remove("rotate");
      overdueClicked = 0;
    }
  });
}

function fineDetailsPopup() {
  let btns = document.querySelectorAll(".Documents-btn");

  for (let btn of btns) {
    btn.addEventListener("click", () => {
      document.querySelector(".details-popup").classList.remove("hidden");
      document.querySelector(".fileBack").classList.add("hidden");
      document.querySelector(".filePage").classList.add("hidden");
      document.querySelector(".fileFront").classList.add("hidden");
    });
  }

  let close = document.querySelector(".icon-button");
  let closeBtn = document.querySelector(".close-btn");

  close.addEventListener("click", () => {
    document.querySelector(".details-popup").classList.add("hidden");
    document.querySelector(".fileBack").classList.remove("hidden");
    document.querySelector(".filePage").classList.remove("hidden");
    document.querySelector(".fileFront").classList.remove("hidden");
  });

  closeBtn.addEventListener("click", () => {
    document.querySelector(".details-popup").classList.add("hidden");
    document.querySelector(".fileBack").classList.remove("hidden");
    document.querySelector(".filePage").classList.remove("hidden");
    document.querySelector(".fileFront").classList.remove("hidden");
  });
}

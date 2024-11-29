document.addEventListener("DOMContentLoaded", function () {
    // Get the modal and its elements
    var modal = document.getElementById("myTripModal");
    var span = document.querySelector("#myTripModal .close");
    var modalTitle = document.getElementById("modal-title");
    var modalDescription = document.getElementById("modal-description");
    var modalFamous = document.getElementById("modal-famous");
    var modalEntryFee = document.getElementById("modal-entry-fee");
    var removeBtn = document.querySelector("#myTripModal .remove-btn");

    // Get all cards
    var cards = document.getElementsByClassName("card");

    // Loop through the cards and add click event listeners
    for (var i = 0; i < cards.length; i++) {
        cards[i].onclick = function () {
            modalTitle.innerText = this.getAttribute("data-title");
            modalDescription.innerText = this.getAttribute("data-description");
            modalFamous.innerText = this.getAttribute("data-famous");
            modalEntryFee.innerText = this.getAttribute("data-entry-fee");
            modal.style.display = "block";
        };
    }

    // Close the modal when the user clicks on <span> (x)
    span.onclick = function () {
        modal.style.display = "none";
    };

    // Close the modal when the user clicks outside it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Remove the current card when the remove button is clicked
    removeBtn.onclick = function () {
        var currentCardTitle = modalTitle.innerText;
        for (var i = 0; i < cards.length; i++) {
            if (cards[i].getAttribute("data-title") === currentCardTitle) {
                cards[i].remove();
                break;
            }
        }
        modal.style.display = "none";
    };
});
document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myTripModal");
    var span = document.querySelector("#myTripModal .close");
    var modalTitle = document.getElementById("modal-title");
    var modalDescription = document.getElementById("modal-description");
    var modalFamous = document.getElementById("modal-famous");
    var modalEntryFee = document.getElementById("modal-entry-fee");
    var removeBtn = document.querySelector("#myTripModal .remove-btn");

    var cards = document.getElementsByClassName("card");

    for (var i = 0; i < cards.length; i++) {
        cards[i].onclick = function () {
            modalTitle.innerText = this.getAttribute("data-title");
            modalDescription.innerText = this.getAttribute("data-description");
            modalFamous.innerText = this.getAttribute("data-famous");
            modalEntryFee.innerText = this.getAttribute("data-entry-fee");
            modal.style.display = "block";
        };
    }

    span.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

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
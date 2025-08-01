function applyFilters() {
  const statusFilter = document.getElementById("statusFilter").value
  const dateFilter = document.getElementById("dateFilter").value
  const searchFilter = document.getElementById("searchFilter").value.toLowerCase()

  const bookingCards = document.querySelectorAll("#bookingsList .card")

  bookingCards.forEach((card) => {
    let showCard = true

    // Status filter
    if (statusFilter) {
      const statusBadge = card.querySelector(".badge")
      const cardStatus = statusBadge.textContent.toLowerCase().replace(" ", "-")
      if (cardStatus !== statusFilter) {
        showCard = false
      }
    }

    // Search filter
    if (searchFilter) {
      const customerName = card.querySelector("strong").nextSibling.textContent.toLowerCase()
      if (!customerName.includes(searchFilter)) {
        showCard = false
      }
    }

    // Show/hide card
    card.style.display = showCard ? "block" : "none"
  })

  window.showNotification("Filters applied successfully", "info")
}

// Clear filters
function clearFilters() {
  document.getElementById("statusFilter").value = ""
  document.getElementById("dateFilter").value = ""
  document.getElementById("searchFilter").value = ""

  const bookingCards = document.querySelectorAll("#bookingsList .card")
  bookingCards.forEach((card) => {
    card.style.display = "block"
  })

  window.showNotification("Filters cleared", "info")
}

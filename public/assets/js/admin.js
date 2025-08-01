document.addEventListener("DOMContentLoaded", () => {
  const sidebarToggle = document.getElementById("sidebarToggle")
  const sidebar = document.querySelector(".admin-sidebar")

  // Toggle sidebar on mobile
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })
  }

  // Close sidebar when clicking outside on mobile
  document.addEventListener("click", (e) => {
    if (window.innerWidth <= 768) {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove("show")
      }
    }
  })
})

// Global functions for admin operations
function updateBookingStatus(bookingId, status) {
  if (confirm(`Are you sure you want to change the booking status to ${status}?`)) {
    // Simulate API call
    console.log(`Updating booking ${bookingId} to ${status}`)

    // Show success message
    showNotification(`Booking #${bookingId} status updated to ${status}`, "success")

    // Refresh the page or update the UI
    setTimeout(() => {
      location.reload()
    }, 1000)
  }
}

function assignStaff(bookingId, staffId) {
  if (staffId) {
    // Simulate API call
    console.log(`Assigning staff ${staffId} to booking ${bookingId}`)

    // Show success message
    showNotification(`Staff assigned to booking #${bookingId}`, "success")

    // Refresh the page or update the UI
    setTimeout(() => {
      location.reload()
    }, 1000)
  }
}

function viewBookingDetails(bookingId) {
  // In a real application, this would open a modal or navigate to a detail page
  alert(`Viewing details for booking #${bookingId}`)
}

function showNotification(message, type = "info") {
  // Create notification element
  const notification = document.createElement("div")
  notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`
  notification.style.cssText = "top: 20px; right: 20px; z-index: 9999; min-width: 300px;"
  notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `

  // Add to page
  document.body.appendChild(notification)

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentNode) {
      notification.parentNode.removeChild(notification)
    }
  }, 5000)
}

document.addEventListener("DOMContentLoaded", () => {
  const bookingForm = document.getElementById("bookingForm")
  const serviceSelect = document.getElementById("serviceId")
  const selectedServiceDiv = document.getElementById("selectedService")
  const noServiceDiv = document.getElementById("noService")
  const serviceName = document.getElementById("serviceName")
  const servicePrice = document.getElementById("servicePrice")
  const formMessage = document.getElementById("formMessage")
  const submitButton = bookingForm.querySelector('button[type="submit"]')
  const submitText = submitButton.querySelector(".submit-text")
  const spinner = submitButton.querySelector(".spinner-border")

  // Service data
  const services = {
    1: { name: "Standard House Cleaning", price: "$120" },
    2: { name: "Deep Cleaning", price: "$200" },
    3: { name: "Move-in/Move-out Cleaning", price: "$250" },
    4: { name: "Office Cleaning", price: "$80" },
    5: { name: "Post-Construction Cleanup", price: "$300" },
  }

  // Set minimum date to today
  const dateInput = document.getElementById("bookingDate")
  const today = new Date().toISOString().split("T")[0]
  dateInput.min = today

  // Handle service selection
  serviceSelect.addEventListener("change", function () {
    const selectedValue = this.value

    if (selectedValue && services[selectedValue]) {
      serviceName.textContent = services[selectedValue].name
      servicePrice.textContent = services[selectedValue].price
      selectedServiceDiv.classList.remove("d-none")
      noServiceDiv.classList.add("d-none")
    } else {
      selectedServiceDiv.classList.add("d-none")
      noServiceDiv.classList.remove("d-none")
    }
  })

  // Check URL parameters for pre-selected service
  const urlParams = new URLSearchParams(window.location.search)
  const serviceParam = urlParams.get("service")
  if (serviceParam && services[serviceParam]) {
    serviceSelect.value = serviceParam
    serviceSelect.dispatchEvent(new Event("change"))
  }

  // Handle form submission
  bookingForm.addEventListener("submit", (e) => {
    e.preventDefault()

    // Show loading state
    submitButton.disabled = true
    submitText.textContent = "Submitting..."
    spinner.classList.remove("d-none")

    // Simulate form submission
    setTimeout(() => {
      // Redirect to confirmation page
      window.location.href = "booking-confirmation.html"
    }, 2000)
  })
})

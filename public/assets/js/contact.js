document.addEventListener("DOMContentLoaded", () => {
  const contactForm = document.getElementById("contactForm")
  const formMessage = document.getElementById("formMessage")
  const submitButton = contactForm.querySelector('button[type="submit"]')
  const submitText = submitButton.querySelector(".submit-text")
  const spinner = submitButton.querySelector(".spinner-border")

  contactForm.addEventListener("submit", (e) => {
    e.preventDefault()

    // Show loading state
    submitButton.disabled = true
    submitText.textContent = "Sending..."
    spinner.classList.remove("d-none")

    // Simulate form submission
    setTimeout(() => {
      // Hide loading state
      submitButton.disabled = false
      submitText.textContent = "Send Message"
      spinner.classList.add("d-none")

      // Show success message
      formMessage.innerHTML = `
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Thank you for your message! We'll get back to you soon.
                </div>
            `

      // Reset form
      contactForm.reset()

      // Hide message after 5 seconds
      setTimeout(() => {
        formMessage.innerHTML = ""
      }, 5000)
    }, 2000)
  })
})

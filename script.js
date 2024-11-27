// Smooth Scroll to Section
function scrollToSection(sectionId) {
    document.querySelector(sectionId).scrollIntoView({ behavior: 'smooth' });
}

// Navigate to Detailed Page
function navigateToPage(pageUrl) {
    window.location.href = pageUrl;
}

// Form Submission
document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;

    alert(`Welcome, ${username}! Your email ${email} has been registered.`);
});

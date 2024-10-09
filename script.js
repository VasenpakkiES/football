d// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Dropdown Menu Toggle
document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('mouseover', function() {
        this.querySelector('.dropdown-content').style.display = 'block';
    });
    dropdown.addEventListener('mouseout', function() {
        this.querySelector('.dropdown-content').style.display = 'none';
    });
});

// Form Validation
document.querySelector('.contact-form').addEventListener('submit', function(e) {
    let isValid = true;
    const formElements = this.elements;

    // Validate required fields
    for (let element of formElements) {
        if (element.hasAttribute('required') && !element.value.trim()) {
            isValid = false;
            element.style.borderColor = 'red';
        } else {
            element.style.borderColor = '';
        }
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        alert('Please fill out all required fields.');
    }
});

// Example of a simple image carousel or slider (optional)
let currentSlide = 0;
const slides = document.querySelectorAll('.product-card img');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = (i === index) ? 'block' : 'none';
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

// Initial display
showSlide(currentSlide);

// Optional: Add auto-slide functionality
setInterval(nextSlide, 5000); // Change slide every 5 seconds

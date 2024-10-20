document.addEventListener('DOMContentLoaded', function() {
    const slideshows = document.querySelectorAll('.slideshow');
    
    slideshows.forEach(slideshow => {
        let currentIndex = 0;
        const slides = slideshow.querySelectorAll('.slides');
        const totalSlides = slides.length;

        // Set interval to change images every 2 seconds
        setInterval(() => {
            // Hide current slide
            slides[currentIndex].style.display = 'none';
            
            // Move to next slide
            currentIndex = (currentIndex + 1) % totalSlides;
            
            // Show next slide
            slides[currentIndex].style.display = 'block';
        }, 4000);  // 2000 ms = 2 seconds
    });
});
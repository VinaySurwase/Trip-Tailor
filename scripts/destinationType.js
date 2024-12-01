document.addEventListener('DOMContentLoaded', function() {
    const slideshows = document.querySelectorAll('.slideshow');
    
    slideshows.forEach(slideshow => {
        let currentIndex = 0;
        const slides = slideshow.querySelectorAll('.slides');
        const totalSlides = slides.length;

        setInterval(() => {
            slides[currentIndex].style.display = 'none';
            
            currentIndex = (currentIndex + 1) % totalSlides;
            
            slides[currentIndex].style.display = 'block';
        }, 4000); 
    });
});
let theForm = document.querySelector('form');
theForm.onsubmit = function()
{
    alert('Thank you for joining!');
};

let slideIndex = 0;

function changeSlide()
{
    let slides = document.getElementsByClassName('slide');
    for (let i = 0; i < slides.length; i++) 
    {
        slides[i].style.display = 'none';
    }
    slideIndex++;
    if (slideIndex > slides.length) 
    {
        slideIndex = 1;
    }
    slides[slideIndex-1].style.display = 'inline-block';
    setTimeout(changeSlide, 2000);
}
changeSlide();
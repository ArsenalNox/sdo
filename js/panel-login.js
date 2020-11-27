var timer = setInterval(function() { 
    let pageWidth = window.innerWidth
    let pageHeight = window.innerHeight
    // console.log("Высота равна: " + pageHeight + ", высота равна: " + pageWidth)
    height = pageHeight / 100 * 30;
    // console.log(height)
    let form = document.getElementById("adap");
    form.style.top = height + 'px'
    width = pageWidth / 100 * 70;
    form.style.left = width + 'px'
    let img = document.getElementById("adapimg")
    height = pageHeight / 100 * 20;
    // console.log(height)
    width = pageWidth / 100 * 10;
    img.style.top = height + 'px'
    img.style.left = width + 'px'
}, 1);
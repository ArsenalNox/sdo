function tema(){
    document.getElementById('tema').style.background ="#fff";
    body = document.body;
    color = window.getComputedStyle(body).backgroundColor;
    console.log(color)
    

    if(color == "#fff"){
        body.style.background = "black"
        console.log(color)
    }
}


AOS.init();  
let scrollRef = 0;

$(window).on("resize scroll", function () {
    // increase value up to 10, then refresh AOS
    scrollRef <= 10 ? scrollRef++ : AOS.refresh();
});
$(window).load(function() {
    $(".loader").fadeOut("slow");
    window.scrollTo(0, 0);                
});

const about_us = [ document.querySelector("#about_Us_1"),
                   document.querySelector("#about_Us_2"),
                   document.querySelector("#about_Us_3"),
                   document.querySelector("#about_Us_4")]

const root = document.querySelector(':root');

function abrir_Sobre_Nos(id) {

    switch (id) {
        case 0:
            
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta; 
                    about_us[i].style.left = "5%";
                    about_us[i].style.width = "75%"; 
                    about_us[i].style.cursor = "context-menu";
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");
                    about_us[i].style.width = "5%"; 
                    about_us[i].style.cursor = "pointer";        
                }                
            }

            about_us[1].style.left = "80%"; 
            about_us[2].style.left = "85%";
            about_us[3].style.left = "90%";
            break;
        case 1:
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta;
                    about_us[i].style.left = "10%";
                    about_us[i].style.width = "75%"; 
                    about_us[i].style.cursor = "context-menu";  
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");                                      
                    about_us[i].style.width = "5%"; 
                    about_us[i].style.cursor = "pointer";        
                }                
            }

            about_us[0].style.left = "5%"; 
            about_us[2].style.left = "85%";
            about_us[3].style.left = "90%";
            break;
        case 2:
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta;
                    about_us[i].style.left = "15%";
                    about_us[i].style.width = "75%"; 
                    about_us[i].style.cursor = "context-menu"; 
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");                                       
                    about_us[i].style.width = "5%"; 
                    about_us[i].style.cursor = "pointer";        
                }                
            }

            about_us[0].style.left = "5%"; 
            about_us[1].style.left = "10%";
            about_us[3].style.left = "90%";
            break;
        case 3:               
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta;
                    about_us[i].style.left = "20%";
                    about_us[i].style.width = "75%"; 
                    about_us[i].style.cursor = "context-menu";       
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");                                 
                    about_us[i].style.width = "5%"; 
                    about_us[i].style.cursor = "pointer";        
                }                
            }

            about_us[0].style.left = "5%"; 
            about_us[1].style.left = "10%";
            about_us[2].style.left = "15%";  
            break;
        default:
            break;
    }
    
}

let mouseDown = false;
let startX, scrollLeft;
const slider = document.querySelector('.time_carrosel');

const startDragging = (e) => {
    mouseDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
}

const stopDragging = (e) => {
    mouseDown = false;      
}

const move = (e) => {
    e.preventDefault();
    if(!mouseDown) { return; }
    const x = e.pageX - slider.offsetLeft;
    const scroll = x - startX;
    slider.scrollLeft = scrollLeft - scroll;
}

// Add the event listeners
slider.addEventListener('mousemove', move, false);
slider.addEventListener('mousedown', startDragging, false);
slider.addEventListener('mouseup', stopDragging, false);
slider.addEventListener('mouseleave', stopDragging, false);
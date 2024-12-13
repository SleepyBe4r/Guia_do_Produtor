let screen_W = screen.width;
let scrollRef = 0;
let clicked = 0;

const producer_Left = document.querySelectorAll(".producer-left");
const producer_Right = document.querySelectorAll(".producer-right");

const about_us = [ document.querySelector("#about_Us_1"),
    document.querySelector("#about_Us_2"),
    document.querySelector("#about_Us_3")]    

const root = document.querySelector(':root');

let categoria = "P";
let mouseDown = false;
let startX, scrollLeft;
const lista_Professores = document.querySelector("#carrosel_Prof");
const lista_Alunos = document.querySelector("#carrosel_Alunos");

const txtProfessor = document.querySelector("#txt_Carrosel_Professores");
const txtAluno = document.querySelector("#txt_Carrosel_Alunos");

function modificar_style() {
    screen_W = screen.width; 767
    if (screen_W <= 575) {
        producer_Left.forEach(producer => {
            producer.children[1].children[2].children[0].classList.remove("w-50");
        });
        producer_Right.forEach(producer => {
            producer.children[0].children[2].children[0].classList.remove("w-50");
        });
    } else if (screen_W > 575 && screen_W <= 720) {

        abrir_Sobre_Nos(clicked);        
        producer_Left.forEach(producer => {                       
            let tem_class = 0;
            producer.children[1].children[2].children[0].classList.forEach(classItem => {                
                if (classItem == "w-50") tem_class++;
            });
            if(tem_class == 0) producer.children[1].children[2].children[0].classList.add("w-50");
        });
        producer_Right.forEach(producer => {
            let tem_class = 0;
            producer.children[0].children[2].children[0].classList.forEach(classItem => {                
                if (classItem == "w-50") tem_class++;
            });
            if(tem_class == 0) producer.children[0].children[2].children[0].classList.add("w-50");
        });
    } else{
        abrir_Sobre_Nos(clicked);        
        producer_Left.forEach(producer => {
            let tem_class = 0;
            producer.children[1].children[2].children[0].classList.forEach(classItem => {                
                if (classItem == "w-50") tem_class++;
            });
            if(tem_class == 0) producer.children[1].children[2].children[0].classList.add("w-50");
        });
        producer_Right.forEach(producer => {
            let tem_class = 0;
            producer.children[0].children[2].children[0].classList.forEach(classItem => {                
                if (classItem == "w-50") tem_class++;
            });
            if(tem_class == 0) producer.children[0].children[2].children[0].classList.add("w-50");
        });
    }
}

$(window).load(function() {
    $(".loader").fadeOut("slow");
    window.scrollTo(0, 0);

    $(window).on("resize", function(event){
        modificar_style();                
    });
    modificar_style();       
});

function abrir_Sobre_Nos(id) {

    switch (id) {
        case 0:            
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta; 
                    if (screen_W <= 720) {
                        about_us[i].style.top = "5%";
                        about_us[i].style.height = "80%"; 
                    } else{
                        about_us[i].style.left = "5%";
                        about_us[i].style.width = "80%"; 
                    }
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "visible";
                    }
                    about_us[i].style.cursor = "context-menu";
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");
                    if (screen_W <= 720) {                        
                        about_us[i].style.height = "5%";
                    } else{
                        about_us[i].style.width = "5%";                         
                    }                    
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "hidden";
                    } 
                    about_us[i].style.cursor = "pointer";        
                }                
            }

            if (screen_W <= 720) {
                about_us[1].style.top = "85%"; 
                about_us[2].style.top = "90%";
            } else{
                about_us[1].style.left = "85%"; 
                about_us[2].style.left = "90%";
            }
            clicked = 0;
            break;
        case 1:
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta;
                    if (screen_W <= 720) {
                        about_us[i].style.top = "10%";
                        about_us[i].style.height = "80%"; 
                    } else{
                        about_us[i].style.left = "10%";
                        about_us[i].style.width = "80%"; 
                    }
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "visible";
                    }
                    about_us[i].style.cursor = "context-menu";  
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");                                      
                    if (screen_W <= 720) {                        
                        about_us[i].style.height = "5%"; 
                    } else{
                        about_us[i].style.width = "5%";                         
                    }
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "hidden";
                    }
                    about_us[i].style.cursor = "pointer";        
                }                
            }
            if (screen_W <= 720) {
                about_us[0].style.top = "5%"; 
                about_us[2].style.top = "90%";
            } else{
                about_us[0].style.left = "5%"; 
                about_us[2].style.left = "90%";
            }
            clicked = 1;
            break;
        case 2:
            for (let i = 0; i < about_us.length; i++) {
                if (id == i) { //div aberta;
                    if (screen_W <= 720) {
                        about_us[i].style.top = "15%";
                        about_us[i].style.height = "80%"; 
                    } else{
                        about_us[i].style.left = "15%";
                        about_us[i].style.width = "80%"; 
                    }
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "visible";
                    }
                    about_us[i].style.cursor = "context-menu"; 
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "100%");
                } else { //div fechada;
                    root.style.setProperty("--about-us-"+ (i+1) +"-brightness", "90%");                                       
                    if (screen_W <= 720) {                        
                        about_us[i].style.height = "5%"; 
                    } else{
                        about_us[i].style.width = "5%";                         
                    }
                    for (let j = 0; j < about_us[i].children.length; j++) {                            
                        about_us[i].children[j].style.visibility = "hidden";
                    }
                    about_us[i].style.cursor = "pointer";        
                }                
            }
            if (screen_W <= 720) {
                about_us[0].style.top = "5%"; 
                about_us[1].style.top = "10%";
            } else{
                about_us[0].style.left = "5%"; 
                about_us[1].style.left = "10%";
            }
            clicked = 2;
            break;
        default:
            break;
    }
    
}

const startDragging = (e) => {
    mouseDown = true;
    if (categoria == "P") {
        startX = e.pageX - lista_Professores.offsetLeft;
        scrollLeft = lista_Professores.scrollLeft;                
    } else {
        startX = e.pageX - lista_Alunos.offsetLeft;
        scrollLeft = lista_Alunos.scrollLeft;
    }
}

const stopDragging = (e) => {
    mouseDown = false;      
}

const move = (e) => {
    e.preventDefault();
    if(!mouseDown) { return; }
    if (categoria == "P") {
        const x = e.pageX - lista_Professores.offsetLeft;
        const scroll = x - startX;
        lista_Professores.scrollLeft = scrollLeft - scroll;        
    } else {
        const x = e.pageX - lista_Alunos.offsetLeft;
        const scroll = x - startX;
        lista_Alunos.scrollLeft = scrollLeft - scroll;
    }
}

// Add the event listeners
lista_Professores.addEventListener('mousemove', move, false);          lista_Professores.addEventListener('touchmove', move, false); 
lista_Professores.addEventListener('mousedown', startDragging, false); lista_Professores.addEventListener('touchstart', startDragging, false); 
lista_Professores.addEventListener('mouseup', stopDragging, false);    lista_Professores.addEventListener('touchend', stopDragging, false); 
lista_Professores.addEventListener('mouseleave', stopDragging, false); lista_Professores.addEventListener('touchcancel', stopDragging, false); 
 
lista_Alunos.addEventListener('mousemove', move, false);          lista_Professores.addEventListener('touchmove', move, false); 
lista_Alunos.addEventListener('mousedown', startDragging, false); lista_Professores.addEventListener('touchstart', startDragging, false); 
lista_Alunos.addEventListener('mouseup', stopDragging, false);    lista_Professores.addEventListener('touchend', stopDragging, false); 
lista_Alunos.addEventListener('mouseleave', stopDragging, false); lista_Professores.addEventListener('touchcancel', stopDragging, false); 

function trocar_Categoria(txt) {
    if (txt == "P") {
        lista_Professores.style.display = "flex";
        lista_Alunos.style.display = "none";
        txtProfessor.children[0].style.color = "#fbad1c";
        txtProfessor.children[1].style.backgroundColor = "#fbad1c";
        txtAluno.children[0].style.color = "black";
        txtAluno.children[1].style.backgroundColor = "black";
        categoria = "P";
    } else {
        lista_Professores.style.display = "none";
        lista_Alunos.style.display = "flex";
        txtProfessor.children[0].style.color = "black";
        txtProfessor.children[1].style.backgroundColor = "black";
        txtAluno.children[0].style.color = "#fbad1c";
        txtAluno.children[1].style.backgroundColor = "#fbad1c";
        categoria = "A";
    }
}

trocar_Categoria("P");

function ver_Mais(id) {           
    window.location.href='./assets/pages/produtor_Tudo.php?id_produtor='+id;                        
}
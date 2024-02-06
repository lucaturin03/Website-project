var elemento=document.body;
var isDarkMode = localStorage.getItem('dark') === 'dark'; 
if(isDarkMode)
    elemento.classList.add("dark-mode");
else    
    elemento.classList.remove("dark-mode");
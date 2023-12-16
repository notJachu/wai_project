var fact = document.getElementById('fact')
const button = document.createElement('button');
var fun = document.getElementById('fun');
button.innerText = "Click me!";
button.classList.add('funButton');

fact?.insertBefore(button, fact.children[1]);

button.onclick = () =>{
    console.log("click");
    console.log(fun?.style.display);
    console.log(fun);
    if (fun?.style.display && fun.style.display === 'block') {
        fun.style.display = "none";
    } else if (fun?.style.display && fun.style.display === 'none')  {
        fun.style.display = "block";
    }
}

"use strict";
var fact = document.getElementById('fact');
const button = document.createElement('button');
var fun = document.getElementById('fun');
button.innerText = "Click me!";
button.classList.add('funButton');
fact === null || fact === void 0 ? void 0 : fact.insertBefore(button, fact.children[1]);
button.onclick = () => {
    console.log("click");
    console.log(fun === null || fun === void 0 ? void 0 : fun.style.display);
    console.log(fun);
    if ((fun === null || fun === void 0 ? void 0 : fun.style.display) && fun.style.display === 'block') {
        fun.style.display = "none";
    }
    else if ((fun === null || fun === void 0 ? void 0 : fun.style.display) && fun.style.display === 'none') {
        fun.style.display = "block";
    }
};

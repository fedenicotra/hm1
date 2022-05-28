function unlocksub(event){
    const bt = document.querySelector('#sub');
    if(event.currentTarget.value !=''){
        bt.disabled = false;
    }else{
        bt.disabled = true;
    }
}

const textbox = document.querySelector("#querytextbox");

textbox.addEventListener("keyup", unlocksub);
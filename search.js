function unlocksub(event){
    const bt = document.querySelector('#sub');
    if(event.currentTarget.value !=''){
        bt.disabled = false;
    }else{
        bt.disabled = true;
    }
}

function onResponse(data){
	return data.json();
}

function getThreads(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const querytext = urlParams.get('querytext');
    
    fetch("http://192.168.1.137/hm1/api_db/searchThreads.php?q=" + encodeURIComponent(querytext))
    .then(onResponse)
    .then(data => {

        const parentDiv = document.querySelector("#parentN");
        const len = data["Lenght"];
        parentDiv.innerHTML = "";

        if(len === "0"){
            const nores = document.createElement("p");
            nores.textContent="Nessun risultato";
            parentDiv.appendChild(nores);
            return;
        }

        const threads = data["Threads"];

        for(let thread of threads)
        {
            const div_th = document.createElement("div");
            const link = document.createElement("a");
            link.href = "thread.php?thread=" + thread["ID"];
            div_th.classList.add("post");
            const headpost = document.createElement("div");
            const content = document.createElement("p");
            const title = document.createElement("p");
            headpost.classList.add("flex_cont", "head-post");
            title.classList.add("author");
            content.classList.add("post-content");

            title.textContent = thread["titolo"];
            if(thread["contenuto"].length > 320){
                content.textContent = thread["contenuto"].substring(0, 320) + "...";
            }
            else{
                content.textContent = thread["contenuto"];
            }

            headpost.appendChild(title);
            link.appendChild(headpost);
            link.appendChild(content);
            div_th.appendChild(link);
            parentDiv.appendChild(div_th);
        }
    });
}

getThreads();

const textbox = document.querySelector("#querytextbox");

textbox.addEventListener("keyup", unlocksub);

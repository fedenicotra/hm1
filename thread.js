function hideReplyForm(event){
    const repcont = document.querySelector("#repcont");
    repcont.classList.add("hidden");
    br.removeEventListener("click", hideReplyForm);
    br.addEventListener("click", showReplyForm);
    br.textContent="Rispondi";
}

function showReplyForm(event){
    const repcont = document.querySelector("#repcont");
    repcont.classList.remove("hidden");
    br.removeEventListener("click", showReplyForm);
    br.addEventListener("click", hideReplyForm);
    window.scrollTo(0, document.body.scrollHeight);
    br.textContent="Nascondi";
}

function onInput(event){
    event.currentTarget.style.height = "auto";
    event.currentTarget.style.height = (event.currentTarget.scrollHeight) + 10 + "px";
    event.currentTarget.style.border = "";
    window.scrollTo(0, document.body.scrollHeight);
}

function onResponse(data){
	return data.json();
}

function redirectToLogin(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id_th = parseInt(urlParams.get('thread'));

    if(isNaN(id_th)){
        window.location.href = "http://192.168.1.137/hm1/index.php";
    }

    window.location.href = "http://192.168.1.137/hm1/login.php?th=" + id_th;
}
function like(event){
    const buttonlike = event.currentTarget;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id_th = parseInt(urlParams.get('thread'));
    buttonlike.removeEventListener("click", like);
    buttonlike.addEventListener("click", unlike);
    const cnodes = buttonlike.childNodes;
    console.log("liked " + buttonlike.dataset.id);
    fetch("http://192.168.1.137/hm1/api_db/likePost.php", {
        method: "POST",
        body: JSON.stringify({
            user_id: login_id.textContent,
            lu: "l",
            thread: id_th,
            n_ordine: buttonlike.dataset.id
        })
    })
    .then(onResponse)
    .then(data => {
        if(data.localeCompare("true") == 0){
            cnodes[0].textContent = parseInt(cnodes[0].textContent) + 1;
            cnodes[1].src = "heart-solid.svg";
        }
    });
}

function unlike(event){
    const buttonlike = event.currentTarget;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id_th = parseInt(urlParams.get('thread'));
    buttonlike.removeEventListener("click", unlike);
    buttonlike.addEventListener("click", like);
    const cnodes = buttonlike.childNodes;
    console.log("unliked " + buttonlike.dataset.id);
    fetch("http://192.168.1.137/hm1/api_db/likePost.php", {
        method: "POST",
        body: JSON.stringify({
            user_id: login_id.textContent,
            lu: "u",
            thread: id_th,
            n_ordine: buttonlike.dataset.id
        })
    })
    .then(onResponse)
    .then(data => {
        if(data.localeCompare("true") == 0){
            cnodes[0].textContent = parseInt(cnodes[0].textContent) - 1;
            cnodes[1].src = "heart-regular.svg";
        }
    });
}

function sendReply(event){
    const id = login_id.textContent;
    const cont = document.querySelector("#replybody");
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id_th = parseInt(urlParams.get('thread'));
    
    if(cont.value === ""){
        cont.style.border = "var(--red_error) groove 3px";
        return;
    }
    fetch("http://192.168.1.137/hm1/api_db/addPost.php", {
        method: "POST",
        body: JSON.stringify({
            user_id: login_id.textContent,
            content: cont.value,
            thread: id_th
        })
    })
    .then(onResponse)
    .then(data => {
        const div_post = document.createElement("div");
        div_post.classList.add("post");
        div_post.id="post-" + data["n_ordine"];
        div_post.style.border = "var(--primary_color_light) groove 2px";

        const headpost = document.createElement("div");
        const auth = document.createElement("p");
        const date = document.createElement("p");
        const content = document.createElement("p");
        const parentDiv = document.querySelector("#parentN");

        headpost.classList.add("flex_cont", "head-post");
        auth.classList.add("author");
        date.classList.add("author", "date");
        content.classList.add("post-content");

        auth.textContent = data["username"];
        date.textContent = data["data_creazione"];
        content.textContent = data["contenuto"];

        headpost.appendChild(auth);
        headpost.appendChild(date);
        div_post.appendChild(headpost);
        div_post.appendChild(content);

        const divbrep = document.querySelector("#br").parentNode;
        const repcont = document.querySelector("#repcont");
        parentDiv.removeChild(divbrep);
        parentDiv.removeChild(repcont);
        parentDiv.appendChild(div_post);
        parentDiv.appendChild(divbrep);
        parentDiv.appendChild(repcont);

        hideReplyForm();
    });
}


function getPosts(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const id_th = parseInt(urlParams.get('thread'));

    if(isNaN(id_th)){
        window.location.href = "http://192.168.1.137/hm1/index.php";
    }

    //  console.log(id_th);
    fetch("http://192.168.1.137/hm1/api_db/getThread.php?thread=" + id_th)
    .then(onResponse)
    .then(data => {
        //Generazione Titolo
        const parentDiv = document.querySelector("#parentN");
        const titlesite = document.querySelector("title");
        parentDiv.innerHTML = "";
        const div_title = document.createElement("div");
        div_title.classList.add("post", "thread-title");
        div_title.textContent = data[0];
        titlesite.textContent = data[0] + " - Effectopic";
        if(data["error"]){
            div_title.textContent = "Thread not found";
            div_title.classList.add("error");
            titlesite.textContent = "Thread not found";
            parentDiv.appendChild(div_title);
            return;
        }

        parentDiv.appendChild(div_title);

        //Generazione posts

        const posts = data[1];
        const songs = data[2];

        for(let post of posts)
        {
            const div_post = document.createElement("div");
            div_post.classList.add("post");
            div_post.id="post-" + post["n_ordine"];

            const headpost = document.createElement("div");
            const auth = document.createElement("p");
            const date = document.createElement("p");
            const content = document.createElement("p");

            headpost.classList.add("flex_cont", "head-post");
            auth.classList.add("author");
            date.classList.add("author", "date");
            content.classList.add("post-content");

            auth.textContent = post["username"];
            date.textContent = post["data_creazione"];
            content.textContent = post["contenuto"];

            headpost.appendChild(auth);
            headpost.appendChild(date);
            div_post.appendChild(headpost);
            div_post.appendChild(content);

            //Se contiene link spotify
            if(songs[post["n_ordine"]].length != 0){
                const element = songs[post["n_ordine"]];
                const div_spot = document.createElement("div");
                div_spot.classList.add("spotdiv");
                for(let index in element){
                    const song = element[index];
                    const link = document.createElement("a");
                    const br = document.createElement("br");
                    // console.log(song);
                    link.href = song["link"];
                    link.textContent = song["artists"] + " - " + song["titolo"];
                    div_spot.appendChild(link);
                    div_spot.appendChild(br);
                }
                div_post.appendChild(div_spot);
            }
            //////////////////////////


            ///// LIKES /////
            const footpost = document.createElement("div");
            const buttonlike = document.createElement("div");
            const heart = document.createElement("img");
            const likes = document.createElement("p");
            footpost.classList.add("flex_cont", "foot-post");
            buttonlike.classList.add("flex_cont", "button-like");
            
            buttonlike.dataset.id = post["n_ordine"];

            heart.classList.add("heart");
            if(login_id===null){
                heart.src = "heart-regular.svg";
                buttonlike.addEventListener("click", redirectToLogin);
            }else{
                fetch("http://192.168.1.137/hm1/api_db/checkLikes.php", {
                    method: "POST",
                    body: JSON.stringify({
                        user_id: login_id.textContent,
                        thread: id_th,
                        n_ordine: buttonlike.dataset.id
                    })
                })
                .then(onResponse)
                .then(data => {
                    if(data.localeCompare("true") == 0){
                        heart.src = "heart-solid.svg";
                        buttonlike.addEventListener("click", unlike);
                    }else{
                        heart.src = "heart-regular.svg";
                        buttonlike.addEventListener("click", like);
                    }
                });
            }

            likes.textContent = post["likes"];
            
            buttonlike.appendChild(likes);
            buttonlike.appendChild(heart);
            footpost.appendChild(buttonlike);
            div_post.appendChild(footpost);

            parentDiv.appendChild(div_post);
        }

        // Bottone Risposta

        const replybutton = document.createElement("button");
        const brContainer = document.createElement("div");
        replybutton.id = "br";
        replybutton.textContent = "Rispondi";
        brContainer.classList.add("flex_cont", "br-container");

        replybutton.addEventListener("click", showReplyForm);

        brContainer.appendChild(replybutton);
        parentDiv.appendChild(brContainer);

        // Sezione di risposta
        
        if(login_id===null){
            replybutton.addEventListener("click", redirectToLogin);
        }
        else
        {
            const replyContainer = document.createElement("div");
            const headpost = document.createElement("div");
            const divta = document.createElement("div");
            const divSub = document.createElement("div");
            const auth = document.createElement("p");

            replyContainer.id = "repcont";
            replyContainer.classList.add("post", "reply-container", "hidden");
            headpost.classList.add("flex_cont", "head-post");
            auth.classList.add("author");

            auth.textContent = login_user.textContent;

            headpost.appendChild(auth);
            replyContainer.appendChild(headpost);

            divta.classList.add("flex_cont", "flex_column", "ac_content", "center_content");
            const textarea = document.createElement("textarea");
            textarea.classList.add("main-content", "not-resizable");
            textarea.placeholder = "Rispondi qui";
            textarea.name = "replybody";
            textarea.id = "replybody";
            textarea.rows = "4";
            divta.appendChild(textarea);
            replyContainer.appendChild(divta);

            textarea.addEventListener("input", onInput);

            const subreply = document.createElement("button");
            subreply.id = "subreply";
            subreply.textContent = "Invia";
            divSub.classList.add("flex_cont", "br-container");

            divSub.appendChild(subreply);

            replyContainer.appendChild(divSub);

            parentDiv.appendChild(replyContainer);
            subreply.addEventListener("click", sendReply);

        }
    });
}

const login_user = document.querySelector("#loggedas");
const login_id = document.querySelector("#loggedID");

getPosts();

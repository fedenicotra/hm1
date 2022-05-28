const d = new Date();
let time = d.getHours();
if(time > 21 || time < 7){
    document.body.style.backgroundColor = "var(--darkmode)";
    const h1 = document.querySelector(".welcome h1");
    if(h1 != null) h1.style.color = "var(--grey_2)";
    const ps = document.querySelector(".container div div p");
    if(ps != null) ps.style.color = "var(--grey_2)";
    const log = document.querySelector("#h3_1");
    if(log != null) log.style.color = "var(--grey_2)";
    const reg = document.querySelector("#h3_r");
    if(reg != null) reg.style.color = "var(--grey_2)";
    const span = document.querySelector("form span");
    if(span !=null) span.style.color = "var(--grey_2)";
    const h2 = document.querySelector("form h2");
    if(h2 !=null) h2.style.color = "var(--grey_2)";
}
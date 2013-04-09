// start ml-adverts
function maskLink(el,e,mask){
    e = e || event;
    el.originalHref = el.originalHref || el.href;
    if (/click|out/i.test(e.type)){
        return el.href = el.originalHref;
    } else {
        el.href = mask;
    }
}
// end ml-advers
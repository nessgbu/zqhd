var doc = document.documentElement;
function resize() {
    var clientWidth = doc.clientWidth;
    if(clientWidth>1024){
        clientWidth=1024
    }
    doc.style.fontSize = clientWidth / 750 * 100 + 'px';
}
window.onresize = function () {
    resize()
}
resize()

function getQueryString(name) {
    let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    let r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return decodeURIComponent(r[2]);
    };
    return null;
}
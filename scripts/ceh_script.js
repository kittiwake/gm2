var width=screen.width; // ширина
var height=screen.height; // высота

var clwidth=document.body.clientWidth; // ширина
var clheight=document.body.clientHeight; // высота

var surpage = window.location.pathname;
var dir = surpage.split('/')[1];
var tag_css = document.createElement('link');
tag_css.type = 'text/css';
tag_css.rel = 'stylesheet';
tag_css.href = '/css/ceh.css';
var tag_head = document.getElementsByTagName('head');
tag_head[0].appendChild(tag_css);


function setEqualHeight(columns){
    var tallestcolumn = 0;
    columns.each(
        function(){
            currentHeight = $(this).height();
            if(currentHeight > tallestcolumn){
                tallestcolumn = currentHeight;
            }
        }
    );
    columns.height(tallestcolumn);
}

$(document).ready(function() {
setEqualHeight($(".span3"));
});
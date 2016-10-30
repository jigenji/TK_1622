document.on("pagecreate", "#page", function () {
    $("div[role=main]").on("swipeleft", function (event) {
        changeNavTab(true);
    });

    $("div[role=main]").on("swiperight", function (event) {
        changeNavTab(false);
    });
});


function changeNavTab(left) {
    var $tabs = $('ul[data-role="nd2tabs"] li');
    console.log($tabs);
    var len = $tabs.length;
    var curidx = 0;
    $tabs.each(function(idx){
        if ($(this).hasClass("nd2Tabs-active")){
            curidx = idx;
        }
    });

    var nextidx = 0;
    if (left) {
        nextidx = (curidx >= len - 1) ? 0 : curidx + 1;
    } else {
        nextidx = (curidx <= 0) ? len - 1 : curidx - 1;
    }
    $tabs.eq(nextidx).click();

}

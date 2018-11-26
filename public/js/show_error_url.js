/**
 * Created by Administrator on 2018-11-12.
 */
$(function () {

    var is_360 = is360se();
    if(is_360 == true){
       $('#error_href').hide();
    }
});

function is360se(){
    var where = "suffixes", value = "dll", name = "description", nameReg = /fancy/;
    var mimeTypes = window.navigator.mimeTypes, i;
    for (i in mimeTypes) {
        if (mimeTypes[i][where] == value) {
            if (nameReg.test(mimeTypes[i][name])) return false;
        }
    }
    return true;
}
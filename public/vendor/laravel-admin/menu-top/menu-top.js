/**
 * Created by Administrator on 2018-09-06.
 */

// //鼠标移过/移出事件
// $('.navbar-sidebar-menu').hover(function (){
//     $(".treeview-menu-top").show(100);
// },function () {
//     $(".treeview-menu-top").hide(100);
// });

$('.navbar-sidebar-menu').click(function (){

    $(".treeview-menu-top").toggle();
});

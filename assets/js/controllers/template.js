var Template = {
 getSideMenu: function(elm, e){
  e.preventDefault();
  helper.getSideNavigation();
 },
 
 showModal: function(){
  $('.modal').modal();
 }
};

$(function(){
//  helper.getSideNavigation();
helper.setToolTip();
helper.setCollapse();
});
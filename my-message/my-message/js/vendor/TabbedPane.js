function TabbedPane(o)
{
  var instance = this;
  instance.tabcontainerDIV = o.tabcontainerDIV;
  instance.nrclass = o.nrclass;
  instance.hoverclass = o.hoverclass;
  instance.clickedclass = o.clickedclass;
  instance.contentclass = o.contentclass;
  instance.currenttab=null;
  
  instance.mouseoverFunction = function()
  {
	   if($(this).attr('opened')==0)
	   {
	   $(this).removeClass(instance.nrclass.split(".")[1]).addClass(instance.hoverclass.split(".")[1]);
	   }
  }
  
  instance.mouseoutFunction = function()
  {
	   if($(this).attr('opened')==0)
	   {
	   $(this).removeClass(instance.hoverclass.split(".")[1]).addClass(instance.nrclass.split(".")[1]);
	   }
  }
  
  instance.clickFunction = function()
  {
	if($(this).attr('opened')==0)
	{  
	   if(instance.currenttab!=null)
	   {
		   instance.currenttab.attr('opened',0);
		   instance.currenttab.removeClass(instance.clickedclass.split(".")[1]).addClass(instance.nrclass.split(".")[1]);
		   $(instance.contentclass).eq(instance.currenttab.attr('serial')).slideUp();
	   }
	   
	   $(this).attr('opened',1);
	   $(this).removeClass(instance.hoverclass.split(".")[1]).addClass(instance.clickedclass.split(".")[1]);
	   instance.currenttab = $(this);
	   
	   $(instance.contentclass).eq($(this).attr('serial')).slideDown();
	   
	}
  }
  instance.setInitialcondition = function()
  {
	  $(instance.tabcontainerDIV+" li").eq(0).attr('opened',1);
	  $(instance.tabcontainerDIV+" li").eq(0).removeClass(instance.hoverclass.split(".")[1]).addClass(instance.clickedclass.split(".")[1]);
	  instance.currenttab =  $(instance.tabcontainerDIV+" li").eq(0);
	  $(instance.contentclass).eq(0).slideDown();
  }
  $(instance.contentclass).hide();
  $(instance.tabcontainerDIV+" li").attr('opened',0);
  $(instance.tabcontainerDIV+" li").each(function(n){ $(this).attr('serial',n);});
  $(instance.tabcontainerDIV+" li").removeClass(instance.clickedclass.split(".")[1]).addClass(instance.nrclass.split(".")[1]);
  $(instance.tabcontainerDIV+" li").css('cursor','pointer')
  $(instance.tabcontainerDIV+" li").bind('mouseover',instance.mouseoverFunction);
  $(instance.tabcontainerDIV+" li").bind('mouseout',instance.mouseoutFunction);
  $(instance.tabcontainerDIV+" li").bind('click',instance.clickFunction);
  
  
  instance.setInitialcondition();
	
}





$(document).ready(function(){
						   
 
 $("#tabwrapper").show();
  
  var obj = new Object();
  obj.tabcontainerDIV = ".tabber-nav";
  obj.nrclass = ".tabber-nav-normal";
  obj.hoverclass = ".tabber-nav-hover";
  obj.clickedclass = ".tabber-nav-click";	
  obj.contentclass = ".tabber-con-txt-area";	
  

  
  var tab = new TabbedPane(obj);
							
});

$(document).ready(function(){
						   
 
 $("#tabwrapper_1").show();
  
  var obj = new Object();
  obj.tabcontainerDIV = ".tabber-nav_1";
  obj.nrclass = ".tabber-nav-normal_1";
  obj.hoverclass = ".tabber-nav-hover_1";
  obj.clickedclass = ".tabber-nav-click_1";	
  obj.contentclass = ".tabber-con-txt-area_1";	
  

  
  var tab = new TabbedPane(obj);
							
});

$(document).ready(function(){
						   
 
 $("#tabwrapper_2").show();
  
  var obj = new Object();
  obj.tabcontainerDIV = ".tabber-nav_2";
  obj.nrclass = ".tabber-nav-normal_2";
  obj.hoverclass = ".tabber-nav-hover_2";
  obj.clickedclass = ".tabber-nav-click_2";	
  obj.contentclass = ".bid-detail";	
  

  
  var tab = new TabbedPane(obj);
							
});
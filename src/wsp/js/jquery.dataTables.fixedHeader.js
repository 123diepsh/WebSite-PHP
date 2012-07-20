/*
 * File:        FixedHeader.min.js
 * Version:     2.0.6
 * Author:      Allan Jardine (www.sprymedia.co.uk)
 * Info:        www.datatables.net
 * 
 * Copyright 2008-2012 Allan Jardine, all rights reserved.
 *
 * This source file is free software, under either the GPL v2 license or a
 * BSD style license, available at:
 *   http://datatables.net/license_gpl2
 *   http://datatables.net/license_bsd
 * 
 * This source file is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 */
var FixedHeader=function(b,a){if(typeof this.fnInit!="function"){alert("FixedHeader warning: FixedHeader must be initialised with the 'new' keyword.");
return}var c=this;var d={aoCache:[],oSides:{top:true,bottom:false,left:false,right:false},oZIndexes:{top:104,bottom:103,left:102,right:101},oMes:{iTableWidth:0,iTableHeight:0,iTableLeft:0,iTableRight:0,iTableTop:0,iTableBottom:0},oOffset:{top:0},nTable:null,bUseAbsPos:false,bFooter:false};
this.fnGetSettings=function(){return d};this.fnUpdate=function(){this._fnUpdateClones();
this._fnUpdatePositions()};this.fnPosition=function(){this._fnUpdatePositions()};
this.fnInit(b,a);if(typeof b.fnSettings=="function"){b._oPluginFixedHeader=this}};
FixedHeader.prototype={fnInit:function(b,a){var c=this.fnGetSettings();var d=this;
this.fnInitSettings(c,a);if(typeof b.fnSettings=="function"){if(typeof b.fnVersionCheck=="functon"&&b.fnVersionCheck("1.6.0")!==true){alert("FixedHeader 2 required DataTables 1.6.0 or later. Please upgrade your DataTables installation");
return}var e=b.fnSettings();if(e.oScroll.sX!=""||e.oScroll.sY!=""){alert("FixedHeader 2 is not supported with DataTables' scrolling mode at this time");
return}c.nTable=e.nTable;e.aoDrawCallback.push({fn:function(){FixedHeader.fnMeasure();
d._fnUpdateClones.call(d);d._fnUpdatePositions.call(d)},sName:"FixedHeader"})}else{c.nTable=b
}c.bFooter=($(">tfoot",c.nTable).length>0)?true:false;c.bUseAbsPos=(jQuery.browser.msie&&(jQuery.browser.version=="6.0"||jQuery.browser.version=="7.0"));
if(c.oSides.top){c.aoCache.push(d._fnCloneTable("fixedHeader","FixedHeader_Header",d._fnCloneThead))
}if(c.oSides.bottom){c.aoCache.push(d._fnCloneTable("fixedFooter","FixedHeader_Footer",d._fnCloneTfoot))
}if(c.oSides.left){c.aoCache.push(d._fnCloneTable("fixedLeft","FixedHeader_Left",d._fnCloneTLeft))
}if(c.oSides.right){c.aoCache.push(d._fnCloneTable("fixedRight","FixedHeader_Right",d._fnCloneTRight))
}FixedHeader.afnScroll.push(function(){d._fnUpdatePositions.call(d)});jQuery(window).resize(function(){FixedHeader.fnMeasure();
d._fnUpdateClones.call(d);d._fnUpdatePositions.call(d)});FixedHeader.fnMeasure();
d._fnUpdateClones();d._fnUpdatePositions()},fnInitSettings:function(b,a){if(typeof a!="undefined"){if(typeof a.top!="undefined"){b.oSides.top=a.top
}if(typeof a.bottom!="undefined"){b.oSides.bottom=a.bottom}if(typeof a.left!="undefined"){b.oSides.left=a.left
}if(typeof a.right!="undefined"){b.oSides.right=a.right}if(typeof a.zTop!="undefined"){b.oZIndexes.top=a.zTop
}if(typeof a.zBottom!="undefined"){b.oZIndexes.bottom=a.zBottom}if(typeof a.zLeft!="undefined"){b.oZIndexes.left=a.zLeft
}if(typeof a.zRight!="undefined"){b.oZIndexes.right=a.zRight}if(typeof a.offsetTop!="undefined"){b.oOffset.top=a.offsetTop
}}b.bUseAbsPos=(jQuery.browser.msie&&(jQuery.browser.version=="6.0"||jQuery.browser.version=="7.0"))
},_fnCloneTable:function(f,e,d){var b=this.fnGetSettings();var a;if(jQuery(b.nTable.parentNode).css("position")!="absolute"){b.nTable.parentNode.style.position="relative"
}a=b.nTable.cloneNode(false);a.removeAttribute("id");var c=document.createElement("div");
c.style.position="absolute";c.style.top="0px";c.style.left="0px";c.className+=" FixedHeader_Cloned "+f+" "+e;
if(f=="fixedHeader"){c.style.zIndex=b.oZIndexes.top}if(f=="fixedFooter"){c.style.zIndex=b.oZIndexes.bottom
}if(f=="fixedLeft"){c.style.zIndex=b.oZIndexes.left}else{if(f=="fixedRight"){c.style.zIndex=b.oZIndexes.right
}}a.style.margin="0";c.appendChild(a);document.body.appendChild(c);return{nNode:a,nWrapper:c,sType:f,sPosition:"",sTop:"",sLeft:"",fnClone:d}
},_fnMeasure:function(){var d=this.fnGetSettings(),a=d.oMes,c=jQuery(d.nTable),b=c.offset(),f=this._fnSumScroll(d.nTable.parentNode,"scrollTop"),e=this._fnSumScroll(d.nTable.parentNode,"scrollLeft");
a.iTableWidth=c.outerWidth();a.iTableHeight=c.outerHeight();a.iTableLeft=b.left+d.nTable.parentNode.scrollLeft;
a.iTableTop=b.top+f;a.iTableRight=a.iTableLeft+a.iTableWidth;a.iTableRight=FixedHeader.oDoc.iWidth-a.iTableLeft-a.iTableWidth;
a.iTableBottom=FixedHeader.oDoc.iHeight-a.iTableTop-a.iTableHeight},_fnSumScroll:function(c,b){var a=c[b];
while(c=c.parentNode){if(c.nodeName=="HTML"||c.nodeName=="BODY"){break}a=c[b]}return a
},_fnUpdatePositions:function(){var c=this.fnGetSettings();this._fnMeasure();for(var b=0,a=c.aoCache.length;
b<a;b++){if(c.aoCache[b].sType=="fixedHeader"){this._fnScrollFixedHeader(c.aoCache[b])
}else{if(c.aoCache[b].sType=="fixedFooter"){this._fnScrollFixedFooter(c.aoCache[b])
}else{if(c.aoCache[b].sType=="fixedLeft"){this._fnScrollHorizontalLeft(c.aoCache[b])
}else{this._fnScrollHorizontalRight(c.aoCache[b])}}}}},_fnUpdateClones:function(){var c=this.fnGetSettings();
for(var b=0,a=c.aoCache.length;b<a;b++){c.aoCache[b].fnClone.call(this,c.aoCache[b])
}},_fnScrollHorizontalRight:function(g){var e=this.fnGetSettings(),f=e.oMes,b=FixedHeader.oWin,a=FixedHeader.oDoc,d=g.nWrapper,c=jQuery(d).outerWidth();
if(b.iScrollRight<f.iTableRight){this._fnUpdateCache(g,"sPosition","absolute","position",d.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",d.style);this._fnUpdateCache(g,"sLeft",(f.iTableLeft+f.iTableWidth-c)+"px","left",d.style)
}else{if(f.iTableLeft<a.iWidth-b.iScrollRight-c){if(e.bUseAbsPos){this._fnUpdateCache(g,"sPosition","absolute","position",d.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",d.style);this._fnUpdateCache(g,"sLeft",(a.iWidth-b.iScrollRight-c)+"px","left",d.style)
}else{this._fnUpdateCache(g,"sPosition","fixed","position",d.style);this._fnUpdateCache(g,"sTop",(f.iTableTop-b.iScrollTop)+"px","top",d.style);
this._fnUpdateCache(g,"sLeft",(b.iWidth-c)+"px","left",d.style)}}else{this._fnUpdateCache(g,"sPosition","absolute","position",d.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",d.style);this._fnUpdateCache(g,"sLeft",f.iTableLeft+"px","left",d.style)
}}},_fnScrollHorizontalLeft:function(g){var e=this.fnGetSettings(),f=e.oMes,b=FixedHeader.oWin,a=FixedHeader.oDoc,c=g.nWrapper,d=jQuery(c).outerWidth();
if(b.iScrollLeft<f.iTableLeft){this._fnUpdateCache(g,"sPosition","absolute","position",c.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",c.style);this._fnUpdateCache(g,"sLeft",f.iTableLeft+"px","left",c.style)
}else{if(b.iScrollLeft<f.iTableLeft+f.iTableWidth-d){if(e.bUseAbsPos){this._fnUpdateCache(g,"sPosition","absolute","position",c.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",c.style);this._fnUpdateCache(g,"sLeft",b.iScrollLeft+"px","left",c.style)
}else{this._fnUpdateCache(g,"sPosition","fixed","position",c.style);this._fnUpdateCache(g,"sTop",(f.iTableTop-b.iScrollTop)+"px","top",c.style);
this._fnUpdateCache(g,"sLeft","0px","left",c.style)}}else{this._fnUpdateCache(g,"sPosition","absolute","position",c.style);
this._fnUpdateCache(g,"sTop",f.iTableTop+"px","top",c.style);this._fnUpdateCache(g,"sLeft",(f.iTableLeft+f.iTableWidth-d)+"px","left",c.style)
}}},_fnScrollFixedFooter:function(h){var f=this.fnGetSettings(),g=f.oMes,b=FixedHeader.oWin,a=FixedHeader.oDoc,c=h.nWrapper,e=jQuery("thead",f.nTable).outerHeight(),d=jQuery(c).outerHeight();
if(b.iScrollBottom<g.iTableBottom){this._fnUpdateCache(h,"sPosition","absolute","position",c.style);
this._fnUpdateCache(h,"sTop",(g.iTableTop+g.iTableHeight-d)+"px","top",c.style);this._fnUpdateCache(h,"sLeft",g.iTableLeft+"px","left",c.style)
}else{if(b.iScrollBottom<g.iTableBottom+g.iTableHeight-d-e){if(f.bUseAbsPos){this._fnUpdateCache(h,"sPosition","absolute","position",c.style);
this._fnUpdateCache(h,"sTop",(a.iHeight-b.iScrollBottom-d)+"px","top",c.style);this._fnUpdateCache(h,"sLeft",g.iTableLeft+"px","left",c.style)
}else{this._fnUpdateCache(h,"sPosition","fixed","position",c.style);this._fnUpdateCache(h,"sTop",(b.iHeight-d)+"px","top",c.style);
this._fnUpdateCache(h,"sLeft",(g.iTableLeft-b.iScrollLeft)+"px","left",c.style)}}else{this._fnUpdateCache(h,"sPosition","absolute","position",c.style);
this._fnUpdateCache(h,"sTop",(g.iTableTop+d)+"px","top",c.style);this._fnUpdateCache(h,"sLeft",g.iTableLeft+"px","left",c.style)
}}},_fnScrollFixedHeader:function(f){var j=this.fnGetSettings(),c=j.oMes,d=FixedHeader.oWin,h=FixedHeader.oDoc,b=f.nWrapper,g=0,e=j.nTable.getElementsByTagName("tbody");
for(var a=0;a<e.length;++a){g+=e[a].offsetHeight}if(c.iTableTop>d.iScrollTop+j.oOffset.top){this._fnUpdateCache(f,"sPosition","absolute","position",b.style);
this._fnUpdateCache(f,"sTop",c.iTableTop+"px","top",b.style);this._fnUpdateCache(f,"sLeft",c.iTableLeft+"px","left",b.style)
}else{if(d.iScrollTop+j.oOffset.top>c.iTableTop+g){this._fnUpdateCache(f,"sPosition","absolute","position",b.style);
this._fnUpdateCache(f,"sTop",(c.iTableTop+g)+"px","top",b.style);this._fnUpdateCache(f,"sLeft",c.iTableLeft+"px","left",b.style)
}else{if(j.bUseAbsPos){this._fnUpdateCache(f,"sPosition","absolute","position",b.style);
this._fnUpdateCache(f,"sTop",d.iScrollTop+"px","top",b.style);this._fnUpdateCache(f,"sLeft",c.iTableLeft+"px","left",b.style)
}else{this._fnUpdateCache(f,"sPosition","fixed","position",b.style);this._fnUpdateCache(f,"sTop",j.oOffset.top+"px","top",b.style);
this._fnUpdateCache(f,"sLeft",(c.iTableLeft-d.iScrollLeft)+"px","left",b.style)}}}},_fnUpdateCache:function(e,c,b,d,a){if(e[c]!=b){a[d]=b;
e[c]=b}},_fnCloneThead:function(d){var c=this.fnGetSettings();var a=d.nNode;d.nWrapper.style.width=jQuery(c.nTable).outerWidth()+"px";
while(a.childNodes.length>0){jQuery("thead th",a).unbind("click");a.removeChild(a.childNodes[0])
}var b=jQuery("thead",c.nTable).clone(true)[0];a.appendChild(b);jQuery("thead>tr th",c.nTable).each(function(e){jQuery("thead>tr th:eq("+e+")",a).width(jQuery(this).width())
});jQuery("thead>tr td",c.nTable).each(function(e){jQuery("thead>tr td:eq("+e+")",a).width(jQuery(this).width())
})},_fnCloneTfoot:function(d){var c=this.fnGetSettings();var a=d.nNode;d.nWrapper.style.width=jQuery(c.nTable).outerWidth()+"px";
while(a.childNodes.length>0){a.removeChild(a.childNodes[0])}var b=jQuery("tfoot",c.nTable).clone(true)[0];
a.appendChild(b);jQuery("tfoot:eq(0)>tr th",c.nTable).each(function(e){jQuery("tfoot:eq(0)>tr th:eq("+e+")",a).width(jQuery(this).width())
});jQuery("tfoot:eq(0)>tr td",c.nTable).each(function(e){jQuery("tfoot:eq(0)>tr th:eq("+e+")",a)[0].style.width(jQuery(this).width())
})},_fnCloneTLeft:function(g){var c=this.fnGetSettings();var b=g.nNode;var f=$("tbody",c.nTable)[0];
var e=$("tbody tr:eq(0) td",c.nTable).length;var a=($.browser.msie&&($.browser.version=="6.0"||$.browser.version=="7.0"));
while(b.childNodes.length>0){b.removeChild(b.childNodes[0])}b.appendChild(jQuery("thead",c.nTable).clone(true)[0]);
b.appendChild(jQuery("tbody",c.nTable).clone(true)[0]);if(c.bFooter){b.appendChild(jQuery("tfoot",c.nTable).clone(true)[0])
}$("thead tr",b).each(function(h){$("th:gt(0)",this).remove()});$("tfoot tr",b).each(function(h){$("th:gt(0)",this).remove()
});$("tbody tr",b).each(function(h){$("td:gt(0)",this).remove()});this.fnEqualiseHeights("tbody",f.parentNode,b);
var d=jQuery("thead tr th:eq(0)",c.nTable).outerWidth();b.style.width=d+"px";g.nWrapper.style.width=d+"px"
},_fnCloneTRight:function(g){var c=this.fnGetSettings();var f=$("tbody",c.nTable)[0];
var b=g.nNode;var e=jQuery("tbody tr:eq(0) td",c.nTable).length;var a=($.browser.msie&&($.browser.version=="6.0"||$.browser.version=="7.0"));
while(b.childNodes.length>0){b.removeChild(b.childNodes[0])}b.appendChild(jQuery("thead",c.nTable).clone(true)[0]);
b.appendChild(jQuery("tbody",c.nTable).clone(true)[0]);if(c.bFooter){b.appendChild(jQuery("tfoot",c.nTable).clone(true)[0])
}jQuery("thead tr th:not(:nth-child("+e+"n))",b).remove();jQuery("tfoot tr th:not(:nth-child("+e+"n))",b).remove();
$("tbody tr",b).each(function(h){$("td:lt("+(e-1)+")",this).remove()});this.fnEqualiseHeights("tbody",f.parentNode,b);
var d=jQuery("thead tr th:eq("+(e-1)+")",c.nTable).outerWidth();b.style.width=d+"px";
g.nWrapper.style.width=d+"px"},fnEqualiseHeights:function(e,d,g){var f=this,c=$(e+" tr:eq(0)",d).children(":eq(0)"),b=c.outerHeight()-c.height(),a=($.browser.msie&&($.browser.version=="6.0"||$.browser.version=="7.0"));
$(e+" tr",g).each(function(h){if($.browser.mozilla||$.browser.opera){$(this).children().height($(e+" tr:eq("+h+")",d).outerHeight())
}else{$(this).children().height($(e+" tr:eq("+h+")",d).outerHeight()-b)}if(!a){$(e+" tr:eq("+h+")",d).height($(e+" tr:eq("+h+")",d).outerHeight())
}})}};FixedHeader.oWin={iScrollTop:0,iScrollRight:0,iScrollBottom:0,iScrollLeft:0,iHeight:0,iWidth:0};
FixedHeader.oDoc={iHeight:0,iWidth:0};FixedHeader.afnScroll=[];FixedHeader.fnMeasure=function(){var d=jQuery(window),c=jQuery(document),b=FixedHeader.oWin,a=FixedHeader.oDoc;
a.iHeight=c.height();a.iWidth=c.width();b.iHeight=d.height();b.iWidth=d.width();b.iScrollTop=d.scrollTop();
b.iScrollLeft=d.scrollLeft();b.iScrollRight=a.iWidth-b.iScrollLeft-b.iWidth;b.iScrollBottom=a.iHeight-b.iScrollTop-b.iHeight
};FixedHeader.VERSION="2.0.6";FixedHeader.prototype.VERSION=FixedHeader.VERSION;jQuery(window).scroll(function(){FixedHeader.fnMeasure();
for(var b=0,a=FixedHeader.afnScroll.length;b<a;b++){FixedHeader.afnScroll[b]()}});
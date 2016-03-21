function getElementsByClass(str)
{
var itemsfound = new Array;
var elements; 
if(str!="All")
elements = document.getElementsByTagName("*");
else
elements = document.getElementById("userTable").getElementsByTagName("*");
for(var i=0;i<elements.length;i++)
{
if(str!="All")
{
if(elements[i].className == str)
{
itemsfound.push(elements[i]);
}
}
else
{
if(elements[i].className && (elements[i].className!="subHead" && elements[i].className!="subres"))
{
itemsfound.push(elements[i]);
}
}
}
return itemsfound;
}

function classHide(str,cond)
{
var dis;

if(cond)
dis="";
else
dis="none";


for(var i=0;i<getElementsByClass(str).length;i++)
{
	
if(dis=="none" && getElementsByClass(str)[i].tagName=="INPUT")
{
if(getElementsByClass(str)[i].type=="text")
getElementsByClass(str)[i].value="";
else
getElementsByClass(str)[i].checked=false;	
}
else if(dis=="none" && getElementsByClass(str)[i].tagName=="SELECT")
{
getElementsByClass(str)[i].value="Select";	
}
else if(dis=="none" && getElementsByClass(str)[i].tagName=="TEXTAREA")
{
getElementsByClass(str)[i].value="";	
}
else if(!getElementsByClass(str)[i].type)
{ 
	getElementsByClass(str)[i].style.display=dis;
}

}

}


function closeAll()
{
var classArr = new Array();
classArr = getElementsByClass("All");
for(var i=0;i<classArr.length;i++)
{
if(classArr[i].type=="text")
{
classArr[i].value="";
}
else if(classArr[i].type=="checkbox" || classArr[i].type=="radio")
{
classArr[i].checked=false;	
}
else  if(!classArr[i].type)
{
classArr[i].style.display= "none";
}
}
}
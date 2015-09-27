var global_pjsid=0;
function getHTTPObject()
{
 if (typeof XMLHttpRequest != 'undefined')
  {
  return new XMLHttpRequest();
  }
  try
  {
  return new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
  try
  {
   return new ActiveXObject("Microsoft.XMLHTTP");
   } catch (e) {}
  } return false;
}
function getReturns()
{  // 4 is complete
 if (http.readyState == 4)
 {
  allDivs = document.getElementsByTagName("div");
  for (i=0;i<allDivs.length;i++)
  {
   if (allDivs.item(i).id=="pjs"+global_pjsid)
    allDivs[i].innerHTML = http.responseText;
  }
 }
}
function deletepjs(table_name,pjsid,title)
{
 global_pjsid=pjsid;
 var url = "delete.php";
 var params = "table_name="+table_name+"&id="+pjsid+"&title="+escape(title);
 if (confirm("Are you sure you want to delete:\n\n\""+title+"\" ?"))
 {
  http = getHTTPObject();
  http.open("POST", url, true);
  http.onreadystatechange = getReturns;
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.setRequestHeader("Content-length", params.length);
  http.setRequestHeader("Connection", "close");
  http.send(params);
 }
}
function modify(id)
{
  document.ff.action="modify.php";
  document.ff.id.value=id;
  document.ff.submit();
}
function show_hide(obj)
{
 var objE = document.getElementById(obj);
 if ( objE.style.display != "none" )
   objE.style.display = 'none';
 else
   objE.style.display = '';
}

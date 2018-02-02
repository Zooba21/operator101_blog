$('input.postSearch').on("keyup",function(){
  var searchedTitle = $('input.postSearch').val()
  $.ajax(
    {
  type:"GET",
  url:"blog/application/www/js/ajaxrequest/gettitle.php ",
  data:"postTitle="+searchedTitle,
  datatype:'html',
}).success(ft_done).fail(ft_fail)
console.log("ft_getTitle End");})


function ft_done(result)
{
  console.log(result);
  console.log("done");
}

function ft_fail()
{
  console.log("echec");
}

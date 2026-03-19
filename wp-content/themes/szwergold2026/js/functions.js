function rate_unregistered() {
    var obj = document.getElementById('rating_text');
    if(obj) {
        obj.innerHTML = '<a href="/register">Register</a> and <a href="/login">login</a> to rate';
    }
    var obj = document.getElementById('rating_stars');
    if(obj) {
        obj.style.display='none';
    }
    return false;
}

function showcomments() {
  var obj = document.getElementById('commentsdiv');
  if(obj) {
    if( "none" == obj.style.display )
      obj.style.display='block';
    else
      obj.style.display='none';
  }
  var obj2 = document.getElementById('showcomments');
  if(obj2) {
    if(obj2.innerHTML.search("Hide")==-1)
      obj2.innerHTML = obj2.innerHTML.replace("Show","Hide");
    else
      obj2.innerHTML = obj2.innerHTML.replace("Hide","Show");
  }
}

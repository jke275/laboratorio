function warnBeforeRedirect(title, text, linkURL){
   swal({
      title: title,
      text: text,
      type: "warning",
      showCancelButton: true
      }, function(){
         // Redirect the user
         window.location.href = linkURL;
      });
}

function warnBeforeDelete(title, text, linkURL){
   swal({
      title: title,
      text: text,
      type: "warning",
      showCancelButton: true
      }, function() {
         // Redirect the user
         //window.location.href = linkURL;
         //console.log('true');
         //return 'true';
      });
   return true;
}
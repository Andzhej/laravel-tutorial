$(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });

    $('#tags').tagEditor({
        maxTags:8,
        maxLength: 25
    });
  });
(function ($, Drupal) {
 
    if (Drupal.AjaxCommands) {
   
      // Custom Ajax command
      Drupal.AjaxCommands.prototype.customAjaxCommand2 = function (ajax, response, status) {

        function preloadImages(array) {
          if (!preloadImages.list) {
              preloadImages.list = [];
          }
          var list = preloadImages.list;
          for (var i = 0; i < array.length; i++) {
              var img = new Image();
              img.onload = function() {
                  var index = list.indexOf(this);
                  if (index !== -1) {
                      // remove image from the array once it's loaded
                      // for memory consumption reasons
                      list.splice(index, 1);
                  }
              }
              list.push(img);
              img.src = array[i];
          }
        }
        var img_list = [
          "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740332.png", 
          "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740333.png", 
          "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740334.png",
          "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740335.png",
          "/sites/test-apashnin.web.cern.ch/files/EventDisplay/buffer/ss_1561740336.png"
        ];
        preloadImages(img_list);
        console.log("Images (5) have been preloaded. ")

        var i = 0;
        function run_1s_timer() {
          setInterval(function() {
            var myImageElement = document.getElementById('ed00');
            console.log("switching to the next image" + i)
            myImageElement.src = img_list[i]; // '?rand=' + Math.random();
            i = (i+1)%4;
          }, 1000);
        }
        run_1s_timer();

      }
   
    }
   
  }) (jQuery, Drupal);
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
              console.log("Preloading image: " + array[i]);
              img.src = array[i];
          }
        }
        console.log("!!! Current buffer now is: " + response['message']['current_buf_now']);
        console.log(response);
        var ed_ss_path = response['message']['img_path'];
        var ed_ss_list = response['message']['d'];
        console.log(ed_ss_list);
        var ed_ss_num = ed_ss_list.length; 
        console.log("IMAGES: " + ed_ss_list.join(','));

        const ed_ss_list_of_url = ed_ss_list.map(x => ed_ss_path + '/' + x);
        preloadImages(ed_ss_list_of_url);

        console.log("Images (" + ed_ss_num + ") have been preloaded. ")

        var i = 0;
        var x = "";
        function run_1s_timer() {
          setInterval(function() {
            var myImageElement = document.getElementById('ed00');
            var myImageStatus = document.getElementById('ed00_status');
            //myImageStatus.innerText = "STALE = " + ed00_status;

            console.log("switching to the next image" + i + " : " + ed_ss_list_of_url[i]);
            myImageElement.src = ed_ss_list_of_url[i];
            i = (i+1)%ed_ss_num;
            if (i == 6) {
              x = fetch('https://test-apashnin.web.cern.ch/custom_ajax_command/customalert2')
              .then(
                function(response) {
                  if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' +
                      response.status);
                    return;
                  }

                  // Examine the text in the response
                  response.json().then(function(data) {
                    console.log(data);
                  });
                }
              )
              .catch(function(err) {
                console.log('Fetch Error :-S', err);
              });
              console.log("list = ", ed_ss_list);
            }
            if (i == 9) {
              console.log('old = ' + ed_ss_list);
              console.log('new = ' + x);
              ed_ss_path = x['message']['img_path'];
              ed_ss_list = x['message']['d'];
              console.log('new new ================  ' + ed_ss_list);
      
            }
          }, 1000);
        }
        run_1s_timer();

      }
   
    }
   
  }) (jQuery, Drupal);
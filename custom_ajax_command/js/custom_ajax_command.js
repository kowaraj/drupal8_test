(function ($, Drupal) {
 
    if (Drupal.AjaxCommands) {
   
      // Custom Ajax command
      Drupal.AjaxCommands.prototype.customAjaxCommand = function (ajax, response, status) {

          let f1 = (a) => {
            fetch(a).then(
              (response) => {
                                if (response.status !== 200) {
                                  console.log('Looks like there was a problem. Status Code: ' +
                                    response.status);
                                  return;
                                }
                                response.json().then(
                                  (data) =>  {
                                                var d_msg = data[0]['message'];
                                                setData(d_msg);
                                              });
                            }
            ).catch(
              (err) =>  {
                          console.log('Fetch Error :-S', err);
                        });
        }

        function getData() {
            var d_index = document.getElementById("ed00ss").dataset.index;
            console.log("getData: INDEX = " + d_index);
            if (d_index == "1") {
              var d_json = document.getElementById("ed00ss").dataset.list1;
            } else if (d_index == "2") { 
              var d_json = document.getElementById("ed00ss").dataset.list2;
            }
            console.log(d_json);
            var d = JSON.parse(d_json);
            return d;
        }

        function setData(d_msg, initializing=false) {
          var ss_url = d_msg['img_path'];
          var ss_names = d_msg['d'];
          const d = ss_names.map(x => ss_url + '/' + x);
          var d_json = JSON.stringify(d);
          var d_index = document.getElementById("ed00ss").dataset.index;
          console.log("setData: INDEX = " + d_index);

          if (initializing) {
            console.log("INITIALIZING?????????????????????????????????????????????????????");
            document.getElementById("ed00ss").dataset.list1 = d_json;
          } 
          else {
            if (d_index == "1") {
              document.getElementById("ed00ss").dataset.list2 = d_json;
            } else if (d_index == "2") { 
              document.getElementById("ed00ss").dataset.list1 = d_json;
            }
          }
        }

        function switchDataIndex() {
          var d_index = document.getElementById("ed00ss").dataset.index;
          console.log("setData: current INDEX = " + d_index + " is about to be switched!");
          if (d_index == "1") {
            document.getElementById("ed00ss").dataset.index = "2";
          } else if (d_index == "2") { 
            document.getElementById("ed00ss").dataset.index = "1";
          }
        }

        function initializeData(r) {
          console.log(r);

          m = r['message'];
          const initial_d = m['d'];
          
          if (initial_d.length == 0) {
            alert("Received 0 elements from the server! Refresh the page?");
          }
          else {
            setData(m, true);
          }  
        }

        // It all starts here!
        initializeData(response);


        function preloadImagesX() 
        {
          var d = getData();

          if (!preloadImagesX.list) {
              preloadImagesX.list = [];
          }
          var list = preloadImagesX.list;
          for (var i = 0; i < d.length; i++) {
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
              console.log("Preloading image: " + d[i]);
              img.src = d[i];
          }
        }
        preloadImagesX();

        let f_trigger = (a) => {
          fetch(a)
          .then(
            (response) => {
                              if (response.status !== 200) {
                                console.log('Looks like there was a problem. Status Code: ' +
                                  response.status);
                                return;
                              }
                              response.json().then(
                                (data) =>  {
                                              console.log("Trigger's reply ==== ");
                                              console.log(data);
                                            });
                          }
          )
          .catch(
            (err) =>  {
                        console.log('Fetch Error :-S', err);
                      });
      }

        function run_1s_timer() {
          var i = 0;
          setInterval(function() {

            var d = getData();
            var d_src = d[i];
            console.log("switching to the next image" + i + " : " + d_src);

            var current_image = document.getElementById('ed00');
            current_image.src = d_src;

            if (i == 3) {
              console.log("========================================== FETCH!");
              f1("https://test-apashnin.web.cern.ch/custom_ajax_command/customalert");
            }

            if (i == 5) {
              console.log("========================================== PRELOAD!");
              preloadImagesX();
            }

            if (i == 9) {
              console.log("========================================== LAST IMAGE => Let's switch the index");
              switchDataIndex();
            }

            i = (i+1)%d.length;
          }, 1000);
        }
        run_1s_timer();

      }
    }

}) (jQuery, Drupal);
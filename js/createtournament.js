
 /*
 Author: Zhuocheng Shang
 Description:
        This fle contain all Javascript and Jquery function needed in the foolowing files:
        - When create tournament ivoving with 'DatePcker' in ' index.php '
        - fetch_team.php
        - deleteTM.php
        - deny.php
        - approved.php
        - update_tournament.php
 */
 
 
 
    //function used for PDatetimePicker
    /* For more information, check ' tempus dominus-bootstrap-4 '*/
 $(function () {

                //function for the start date
          $('#StartDate').datetimepicker({
              useCurrent: false,
              minDate: moment(),
              allowInputToggle: true,
              widgetPositioning:{
                  horizontal: 'auto',
                  vertical: 'bottom'
              }
          });
                //function for the end date
          $('#EndDate').datetimepicker({
              useCurrent: false,
              minDate: moment(),
              allowInputToggle: true,
              widgetPositioning:{
                  horizontal: 'auto',
                  vertical: 'bottom'
              }
          });
                //set linked date time picker, make sure end date later than start date
          $("#StartDate").on("change.datetimepicker", function (e) {
              $('#EndDate').datetimepicker('minDate', e.date);

          });
          $("#EndDate").on("change.datetimepicker", function (e) {
              $('#StartDate').datetimepicker('maxDate', e.date);
          });

    });


        //function for check limit characters in the description text area
    $(document).ready(function(){
        $('#gType').on('change', function() {
            if ( this.value == 'Team')
            {
                $("#selectteam").show();
                $("#numteam").show();
            }
            else
            {
                $("#selectteam").hide();
                $("#numteam").hide();
            }
        });
    });

    $('#spnCharLeft').css('display', 'none');
    var maxLimit = 150;
    $(document).ready(function () {
        $('#description').keyup(function () {
            var lengthCount = this.value.length;
            if (lengthCount > maxLimit) {
                this.value = this.value.substring(0, maxLimit);
                var charactersLeft = maxLimit - lengthCount + 1;
            }
            else {
                var charactersLeft = maxLimit - lengthCount;
            }
            $('#spnCharLeft').css('display', 'block');
            $('#spnCharLeft').text(charactersLeft + ' Characters left');
        });
    });



        //function to fetch team in select menue
        //function to send information about the tournament
    function fetch_team(val){
            $.ajax({
                type: 'post',
                url: 'fetch_team.php', //link to php file
                data: {
                    get_option: val 
                },
                success: function (response) {
                    //find the palce to insert select tag
                document.getElementById("new_select").innerHTML=response;
           }
        });

    }


        //function to send information about the tournament
    function deleteTM(val){
      $.ajax({
          type: 'post',
          url: 'deleteTM.php',
          data: {
              get_id: val,
          },
          success: function (data) {
              $(".status").html(data);
          }
      });
    }

        //function to send information about the tournament
    function updateTM(val){
    var name = document.getElementById('tmname'+val).value;
    var des =  document.getElementById('desc'+val).value;
    $.ajax({
      type: 'post',
      url: 'update_tournament.php',
      data: {
          get_id:val,
          tm_name:name,
          desc:des
      },
      success: function (response) {
         // alert("got response as "+"'"+response+"'");
      }
    });
  
    }

        //function to send information about the tournament
    function trans_Approve(val) {
    $.ajax({
        type: 'post',
        url: 'approved.php',
        data: {get_id: val,
        },
        success: function (response) {
           // alert("got response as "+"'"+ response + "'");
        }
    });
    }


        //function to send information about the tournament
    function trans_Deny(val){
    var reason = document.getElementById('denyreason'+val).value;
    $.ajax({
        type: 'post',
        url: 'deny.php',
        data: {
            get_id:val,
            get_reason:reason,
        },
        success: function (response) {
           // alert("got response as "+"'"+response+"'");
        }
    });


}